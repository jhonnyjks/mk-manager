<li class="{{ Request::is('users*') ? 'active' : '' }}">
    <a href="{!! route('users.index') !!}"><i class="fa fa-edit"></i><span>Usuários</span></a>
</li>
<li class="{{ Request::is('plans*') ? 'active' : '' }}">
    <a href="{!! route('plans.index') !!}"><i class="fa fa-edit"></i><span>Pacotes</span></a>
</li>
<li class="{{ Request::is('plans*') ? 'active' : '' }}">
    <a href="{!! route('users.paymentPanel') !!}"><i class="fa fa-edit"></i><span>Painel Caixa</span></a>
</li>
