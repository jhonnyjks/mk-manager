@if(!Auth::guest())
@if(Auth::user()->user_type_id > 2)
<li class="{{ Request::is('users.account') ? 'active' : '' }}">
	<a href="{!! route('users.account') !!}"><i class="fa fa-user"></i><span>Minha Conta</span></a>
</li>

<li class="{{ Request::is('users.edit') ? 'active' : '' }}">
	<a href="{!! route('users.edit', [Auth::user()->id]) !!}"><i class="fa fa-edit"></i><span>Alterar Dados</span></a>
</li>

<li class="{{ Request::is('users.resetSessions') ? 'active' : '' }}">
	<a href="{!! route('users.resetSessions', [Auth::user()->id]) !!}"><i class="fa fa-close"></i><span>Fechar Sessões</span></a>
</li>
@else
<li class="{{ Request::is('users*') ? 'active' : '' }}">
	<a href="{!! route('users.index') !!}"><i class="fa fa-edit"></i><span>Usuários</span></a>
</li>

<li class="{{ Request::is('plans*') ? 'active' : '' }}">
	<a href="{!! route('plans.index') !!}"><i class="fa fa-edit"></i><span>Pacotes</span></a>
</li>

<li class="{{ Request::is('plans*') ? 'active' : '' }}">
	<a href="{!! route('users.paymentPanel') !!}"><i class="fa fa-edit"></i><span>Painel Caixa</span></a>
</li>
@endif
@endif