<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Repositories\UserRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

class UserController extends AppBaseController
{
    /** @var  UserRepository */
    private $userRepository;

    public function __construct(UserRepository $userRepo)
    {
        $this->middleware('auth');
        $this->userRepository = $userRepo;
    }

    /**
     * Display a listing of the User.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
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
        return view('users.create');
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

        Flash::success('User saved successfully.');

        return redirect(route('users.index'));
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
            Flash::error('User not found');

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
        $user = $this->userRepository->findWithoutFail($id);

        if (empty($user)) {
            Flash::error('User not found');

            return redirect(route('users.index'));
        }

        return view('users.edit')->with('user', $user);
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
            Flash::error('User not found');

            return redirect(route('users.index'));
        }

        $user = $this->userRepository->update($request->all(), $id);

        Flash::success('User updated successfully.');

        return redirect(route('users.index'));
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
        $user = $this->userRepository->findWithoutFail($id);

        if (empty($user)) {
            Flash::error('User not found');

            return redirect(route('users.index'));
        }

        $this->userRepository->delete($id);

        Flash::success('User deleted successfully.');

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

       $this->userRepository->pushCriteria(new RequestCriteria($request));
       $users = $this->userRepository->makeModel()
       ->where([
        'user_type_id' => 3,
        ['last_payment', '<=', date('Y-m-d', strtotime(date('Y-m-d'). ' - 30 days'))
        ]])->get();

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
        $user = $this->userRepository->findWithoutFail($id);

        if (empty($user)) {
            Flash::error('Usuário não encontrado.');

            return redirect(route('users.paymentPanel'));
        }

        $user = $this->userRepository->update(['last_payment' => date('Y-m-d')],$id);

        if(empty($user)) {
            Flash::error('Não foi possível confirmar o pagamento do usuário <b>'.$user->username.'</b>. Por favor, tente novamente.');

            return redirect(route('users.paymentPanel'));
        }

        Flash::success('Pagamento do usuário <b>'.$user->username.'</b> confirmado!');

        return redirect(route('users.paymentPanel'));
    }
}
