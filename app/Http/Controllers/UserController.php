<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Repositories\UserRepository;
use App\Repositories\PlanRepository;
use App\Repositories\GeneralStatusRepository;
use App\Repositories\UserTypeRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;
use Illuminate\Support\Facades\DB;

class UserController extends AppBaseController
{
    /** @var  UserRepository */
    private $userRepository;
    private $planRepository;
    private $userTypeRepository;
    private $generalStatusRepository;

    public function __construct(UserRepository $userRepo, 
        PlanRepository $planRepo, 
        UserTypeRepository $userTypeRepo,
        GeneralStatusRepository $generalStatusRepo)
    {
        $this->middleware('auth')->except('updatePaymentSituations');
        $this->userRepository = $userRepo;
        $this->planRepository = $planRepo;
        $this->userTypeRepository = $userTypeRepo;
        $this->generalStatusRepository = $generalStatusRepo;
    }

    /**
     * Display a listing of the User.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        if(auth()->user()->user_type_id != 1) {
            return $this->paymentPanel();
        }

        $this->userRepository->pushCriteria(new RequestCriteria($request));
        $users = $this->userRepository->paginate(20);

        return view('users.index')
        ->with('users', $users);
    }

    /**
     * Show the form for creating a new User.
     *
     * @return Response
     */
    public function create()
    {
        $plans = $this->planRepository->makeModel()->select(
            DB::raw("CONCAT(name,' - R$ ',format(price,2,'de_DE')) AS name"),'id')->pluck('name', 'id')->toArray();
        $plans[0] = 'Selecione';

        $userTypes = $this->userTypeRepository->pluck('name', 'id')->toArray();
        $userTypes[0] = 'Selecione';
        
        $generalStatuses = $this->generalStatusRepository->pluck('name', 'id')->toArray();
        $generalStatuses[0] = 'Selecione';
        
        return view('users.create')
        ->with('plans', $plans)
        ->with('userTypes', $userTypes)
        ->with('generalStatuses', $generalStatuses);
    }

    /**
     * Store a newly created User in storage.
     *
     * @param CreateUserRequest $request
     *
     * @return Response
     */
    public function store(CreateUserRequest $request)
    {
        $input = $request->all();

        $user = $this->userRepository->create($input);

        Flash::success('Usuário '.$user->username.' adicionado com sucesso!');

        if(auth()->user()->user_type_id != 1) {
            return $this->paymentPanel();
        } else {
            return redirect(route('users.index'));
        }
    }

    /**
     * Display the specified User.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $user = $this->userRepository->findWithoutFail($id);

        if (empty($user)) {
            Flash::error('Usuário não encontrado');

            return redirect(route('users.index'));
        }

        return view('users.show')->with('user', $user);
    }

    /**
     * Show the form for editing the specified User.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        if(auth()->user()->user_type_id > 2) {
            $id = auth()->user()->id;
        }

        $user = $this->userRepository->findWithoutFail($id);

        if (empty($user)) {
            Flash::error('Usuário não encontrado');

            return redirect(route('users.index'));
        }

        $plans = $this->planRepository->makeModel()->select(
            DB::raw("CONCAT(name,' - R$ ',format(price,2,'de_DE')) AS name"),'id')->pluck('name', 'id')->toArray();
        $plans[0] = 'Selecione';

        $userTypes = $this->userTypeRepository->pluck('name', 'id')->toArray();
        $userTypes[0] = 'Selecione';
        
        $generalStatuses = $this->generalStatusRepository->pluck('name', 'id')->toArray();
        $generalStatuses[0] = 'Selecione';

        return view('users.edit')
        ->with('user', $user)
        ->with('plans', $plans)
        ->with('userTypes', $userTypes)
        ->with('generalStatuses', $generalStatuses);
    }

    /**
     * Update the specified User in storage.
     *
     * @param  int              $id
     * @param UpdateUserRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateUserRequest $request)
    {
        $user = $this->userRepository->findWithoutFail($id);

        if (empty($user)) {
            Flash::error('Usuário não encontrado');

            switch (auth()->user()->user_type_id) {
                case 2:
                return $this->paymentPanel();      
                break;

                case 3:
                return $this->account();       
                break;
                
                default:
                return redirect(route('users.index'));
                break;
            }
        }

        $user = $this->userRepository->update($request->all(), $id);

        Flash::success('Usuário alterado com sucesso!');

        switch (auth()->user()->user_type_id) {
            case 2:
            return $this->paymentPanel();      
            break;

            case 3:
            return $this->account();       
            break;
            
            default:
            return redirect(route('users.index'));
            break;
        }
    }

    /**
     * Remove the specified User from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        if(auth()->user()->user_type_id > 2) {
            return $this->account();
        }

        $user = $this->userRepository->findWithoutFail($id);

        if (empty($user)) {
            Flash::error('Usuário não encontrado');

            return redirect(route('users.index'));
        }

        $this->userRepository->delete($id);

        Flash::success('Usuário deletado com sucesso!');

        return redirect(route('users.index'));
    }

    /**
     * Painel de caixa: pagamento e desbloqueio de conta.
     *
     * @param Request $request
     * @return ResponseSe tem 'Tosco', foi o canadense 
     */
    public function paymentPanel()
    {
        if(auth()->user()->user_type_id > 2) {
            return $this->account();
        }

        $users = $this->userRepository->makeModel()->where(['user_type_id' => 3])
        ->orderBy('general_status_id', 'DESC')->orderBy('payment_promise', 'DESC')->orderBy('username', 'ASC')->get();

        return view('users.payment_panel')
        ->with('users', $users);
    }

    /**
     * Confirma o pagamento do usuário definindo o attr last_payment com a data atual 
     *
     * @param  int $id
     *
     * @return Response
     */
    public function confirmPayment(Request $request)
    {
        if(empty($request->id)) {
            return $this->paymentPanel();
        }
        
        if(auth()->user()->user_type_id > 2) {
            return $this->account();
        }

        $user = $this->userRepository->findWithoutFail($request->id);

        if (empty($user)) {
            Flash::error('Usuário não encontrado.');

            return $this->paymentPanel();
        }

        // Adiciona 30 dias a partir da última data de pagamento.
        $lastPayment = '';
        if($user->general_status_id == 1) {
            // Necessário ser relativo à ultima data de pagamento por que temos a 
            //funcionalidade de promessa de pagamento que usa a mesma data como base.
            $lastPayment = date('Y-m-d', strtotime($user->last_payment. ' + 30 days'));
        } else  {
            // Se não estava ativo, utilizar a data atual menos os dias de promessa de pagamento.
            $lastPayment = date('Y-m-d', strtotime(date('Y-m-d'). ' - '.($user->payment_promise * 3).' days'));
        }

        $user = $this->userRepository->update([
            'last_payment' => $lastPayment,
            'payment_promise' => 0
        ], $request->id);

        if(empty($user)) {
            Flash::error('Não foi possível confirmar o pagamento desse usuário. Por favor, tente novamente.');

            return redirect(route('users.paymentPanel'));
        }

        Flash::success('Pagamento do usuário <b>'.$user->username.'</b> confirmado!');

        return redirect(route('users.paymentPanel'));
    }

    /**
     * Confirma o pagamento do usuário definindo o attr last_payment com a data atual 
     *
     * @param  int $id
     *
     * @return Response
     */
    public function promisePayment($id)
    {
        if(auth()->user()->user_type_id > 2) {
            $id = auth()->user()->id;
        }

        $user = $this->userRepository->findWithoutFail($id);

        if (empty($user)) {
            Flash::error('Usuário não encontrado');

            switch (auth()->user()->user_type_id) {
                case 2:
                return $this->paymentPanel();      
                break;

                case 3:
                return $this->account();       
                break;
                
                default:
                return redirect(route('users.index'));
                break;
            }
        }

        $user = $this->userRepository->promisePayment($id);

        if (empty($user)) {
            Flash::error('Não foi possível registrar a promessa de pagamento do usuário. Por favor, tente novamente.');
        } else {
            Flash::success('Promessa de pagamento do usuário <b>'.$user->username.'</b> confirmada!');
        }

        switch (auth()->user()->user_type_id) {
            case 2:
            return $this->paymentPanel();      
            break;

            case 3:
            return redirect(route('users.account'));       
            break;

            default:
            return redirect(route('users.index'));
            break;
        }

    }

    /**
     * Atualiza asituação do pagamento de todos os usuários, desativando quem estiver vencido. 
     * Deve ser executado uma vez por dia.
     * @param  int $id
     *
     * @return Response
     */ 
    public function updatePaymentSituations($token)
    {
        //Validação temporária utilizando a APP_KEY para garantir que só com autorização interna seja
        // possível executar essa funcionalidade. Necessário informar pelo menos 14 dígitos da APP_KEY
        if(strlen($token) > 14 && strpos(env('APP_KEY'), $token) > 0) {
            $this->userRepository->updatePaymentSituations();
        }
    }

    // Deve ser executado apenas UMA VEZ. Carrega todos os dados necessários do mikrotik pro BD do sistema.
    public function loadHotspotData()
    {
        if(1 == auth()->user()->user_type_id) {
            $this->userRepository->loadDatabase();
        }
    }

    /**
     * Remove todas as sessões do usuário informado
     *
     * @param  int $id
     *
     * @return Response
     */
    public function resetSessions($id)
    {
        if(auth()->user()->user_type_id > 2) {
            $id = auth()->user()->id;
        }

        $user = $this->userRepository->resetSessions($id);

        if(empty($user)) {
            Flash::error('Não foi possível fechar as sessões. Por favor, tente novamente.');

            return redirect(route('users.account'));
        }

        Flash::success('Sessões fechadas com sucesso! Você terá que efetuar login novamente em todos os dispositivos!');

        return redirect(route('users.account'));
    }

    /**
     * Home do usuário. Contém informações gerais da conta.
     *
     * @return Response
     */
    public function account()
    {        
        return view('users.account');
    }

    /**
     * Atualiza os IDs dos usuários de acordo com o que está no mikrotik atual.
     * Rotina necessária quando o mk é substituido.
     */
    public function updateHotspotIds()
    {

        if(1 == auth()->user()->user_type_id) {

            $this->userRepository->updateHotspotIds();
        }
    }
}
