<table class="table table-responsive" id="users-table">
    <thead>
        <tr>
            <th>Nome</th>
            <th>Email</th>
            <th>Usuário</th>
            <th>Celular</th>
            <th>Cpf/Cnpj</th>
            <th>Tipo</th>
            <th>Pacote</th>
            <th>Último Pagamento</th>
            <th colspan="3">Ações</th>
        </tr>
    </thead>
    <tbody>
        @foreach($users as $user)
        <tr>
            <td>{!! $user->name !!}</td>
            <td>{!! $user->email !!}</td>
            <td>{!! $user->username !!}</td>
            <td>{!! $user->celphone !!}</td>
            <td>{!! $user->cpf_cnpj !!}</td>
            <td>{!! $user->userType->name !!}</td>
            <td>{!! !empty($user->plan_id) ? $user->plan->name : '--' !!}</td>
            <td>{!! date("d-m-Y", strtotime($user->last_payment)) !!}</td>
            <td>
                {!! Form::open(['route' => ['users.destroy', $user->id], 'method' => 'delete']) !!}
                <div class='btn-group'>
                    <a href="{!! route('users.show', [$user->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-eye-open"></i></a>
                    <a href="{!! route('users.edit', [$user->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>
                    {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}
                </div>
                {!! Form::close() !!}
            </td>
        </tr>
        @endforeach
    </tbody>
</table>