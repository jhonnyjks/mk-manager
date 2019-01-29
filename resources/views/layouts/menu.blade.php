<li class="{{ Request::is('users*') ? 'active' : '' }}">
    <a href="{!! route('users.index') !!}"><i class="fa fa-edit"></i><span>Users</span></a>
</li><li class="{{ Request::is('plans*') ? 'active' : '' }}">
    <a href="{!! route('plans.index') !!}"><i class="fa fa-edit"></i><span>Plans</span></a>
</li>

<li class="{{ Request::is('plans*') ? 'active' : '' }}">
    <a href="{!! route('plans.index') !!}"><i class="fa fa-edit"></i><span>Plans</span></a>
</li>

