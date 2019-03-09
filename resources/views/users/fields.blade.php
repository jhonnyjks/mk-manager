<!-- Name Field -->
<div class="form-group col-sm-6 {{ $errors->has('name') ? 'has-error' : '' }}">
    {!! Form::label('name', 'Nome do titular:') !!}
    {!! Form::text('name', null, ['class' => 'form-control']) !!}

    @if ($errors->has('name'))
    <span class="help-block">
        {{ $errors->first('name') }}
    </span>
    @endif
</div>

<!-- Email Field -->
<div class="form-group col-sm-6 {{ $errors->has('email') ? 'has-error' : '' }}">
    {!! Form::label('email', 'Email:') !!}
    {!! Form::email('email', null, ['class' => 'form-control']) !!}

    @if ($errors->has('email'))
    <span class="help-block">
        {{ $errors->first('email') }}
    </span>
    @endif
</div>

<!-- Celphone Field -->
<div class="form-group col-sm-6 {{ $errors->has('celphone') ? 'has-error' : '' }}">
    {!! Form::label('celphone', 'Celular:') !!}
    {!! Form::number('celphone', null, ['class' => 'form-control']) !!}

    @if ($errors->has('celphone'))
    <span class="help-block">
        {{ $errors->first('celphone') }}
    </span>
    @endif
</div>

@if(3 > Auth::user()->user_type_id)
<!-- Plan Id Field -->
<div class="form-group col-sm-6 {{ $errors->has('plan_id') ? 'has-error' : '' }}">
    {!! Form::label('plan_id', 'Pacote:') !!}
    {!! Form::select('plan_id', $plans, !empty($user) ? $user->plan_id : 0, ['class' => 'form-control']) !!}

    @if ($errors->has('plan_id'))
    <span class="help-block">
        {{ $errors->first('plan_id') }}
    </span>
    @endif
</div>
@endif

<!-- Username Field -->
<div class="form-group col-sm-6 {{ $errors->has('username') ? 'has-error' : '' }}">
    {!! Form::label('username', 'Usuário:') !!}
    {!! Form::text('username', null, ['class' => 'form-control', 'max-length' => 20]) !!}

    @if ($errors->has('username'))
    <span class="help-block">
        {{ $errors->first('username') }}
    </span>
    @endif
</div>

<!-- Password Field -->
<div class="form-group col-sm-6 {{ $errors->has('password') ? 'has-error' : '' }}">
    {!! Form::label('password', 'Nova senha:') !!}
    {!! Form::password('password', ['class' => 'form-control', 'placeholder' => 'Preencha para mudar de senha']) !!}

    @if ($errors->has('password'))
    <span class="help-block">
        {{ $errors->first('password') }}
    </span>
    @endif
</div>

@if(1 == Auth::user()->user_type_id)
<!-- User Type Id Field -->
<div class="form-group col-sm-6 {{ $errors->has('user_type_id') ? 'has-error' : '' }}">
    {!! Form::label('user_type_id', 'Tipo:') !!}
    {!! Form::select('user_type_id', $userTypes, null, ['class' => 'form-control']) !!}

    @if ($errors->has('user_type_id'))
    <span class="help-block">
        {{ $errors->first('user_type_id') }}
    </span>
    @endif
</div>

<!-- Plan Id Field -->
<div class="form-group col-sm-6 {{ $errors->has('general_status_id') ? 'has-error' : '' }}">
    {!! Form::label('general_status_id', 'Status:') !!}
    {!! Form::select('general_status_id', $generalStatuses, null, ['class' => 'form-control']) !!}

    @if ($errors->has('general_status_id'))
    <span class="help-block">
        {{ $errors->first('general_status_id') }}
    </span>
    @endif
</div>
@endif

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('Salvar Alterações', ['class' => 'btn btn-primary']) !!}
    <a href="{!! route('users.index') !!}" class="btn btn-default">Cancelar</a>
</div>
