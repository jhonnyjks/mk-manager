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
        $this->middleware('auth');
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
            return redirect(route('users.paymentPanel'));
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
        $plans = $this->planRepository->pluck('name', 'id')->toArray();
        array_unshift($plans, 'Selecione');
        $userTypes = $this->userTypeRepository->pluck('name', 'id')->toArray();
        array_unshift($userTypes, 'Selecione');
        $generalStatuses = $this->generalStatusRepository->pluck('name', 'id')->toArray();
        array_unshift($generalStatuses, 'Selecione');

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

        Flash::success('Usuário adicionado com sucesso!');

        if(auth()->user()->user_type_id != 1) {
            return redirect(route('users.paymentPanel'));
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

        $plans = $this->planRepository->pluck('name', 'id')->toArray();
        array_unshift($plans, 'Selecione');
        $userTypes = $this->userTypeRepository->pluck('name', 'id')->toArray();
        array_unshift($userTypes, 'Selecione');
        $generalStatuses = $this->generalStatusRepository->pluck('name', 'id')->toArray();
        array_unshift($generalStatuses, 'Selecione');

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
        if(auth()->user()->user_type_id > 2) {
            return $this->edit(auth()->user()->id);
        }

        $user = $this->userRepository->findWithoutFail($id);

        if (empty($user)) {
            Flash::error('Usuário não encontrado');

            if(auth()->user()->user_type_id != 1) {
                return redirect(route('users.paymentPanel'));
            } else {
                return redirect(route('users.index'));
            }
        }

        $user = $this->userRepository->update($request->all(), $id);

        Flash::success('Usuário alterado com sucesso!');

        if(auth()->user()->user_type_id != 1) {
            return redirect(route('users.paymentPanel'));
        } else {
            return redirect(route('users.index'));
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
            return $this->edit(auth()->user()->id);
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
     * @return Response
     */
    public function paymentPanel(Request $request)
    {
       // $this->userRepository->loadDatabase();

        if(auth()->user()->user_type_id > 2) {
            return $this->edit(auth()->user()->id);
        }

        $this->userRepository->pushCriteria(new RequestCriteria($request));
        $users = $this->userRepository->makeModel()
        ->where([
            'user_type_id' => 3,
            ['last_payment', '<=', date('Y-m-d', strtotime(date('Y-m-d'). ' - 30 days'))
        ]])->orWhere([
            'user_type_id' => 3,
            ['last_payment', '=', null
        ]])->orderBy('username')->get();

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
    public function confirmPayment($id)
    {

        if(auth()->user()->user_type_id > 2) {
            return $this->edit(auth()->user()->id);
        }

        $user = $this->userRepository->findWithoutFail($id);

        if (empty($user)) {
            Flash::error('Usuário não encontrado.');

            return redirect(route('users.paymentPanel'));
        }

        $user = $this->userRepository->update(['last_payment' => date('Y-m-d'), 'payment_promise' => 0],$id);

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
            return $this->edit(auth()->user()->id);
        }

        $user = $this->userRepository->findWithoutFail($id);

        if (empty($user)) {
            Flash::error('Usuário não encontrado.');

            return redirect(route('users.paymentPanel'));
        }

        $user = $this->userRepository->promisePayment($id);

        if(empty($user)) {
            Flash::error('Não foi possível registrar a promessa de pagamento do usuário. Por favor, tente novamente.');

            return redirect(route('users.paymentPanel'));
        }

        Flash::success('Promessa de pagamento do usuário <b>'.$user->username.'</b> confirmada!');

        return redirect(route('users.paymentPanel'));
    }

    public function updatePaymentSituations()
    {
        $this->userRepository->updatePaymentSituations();
    }
}
