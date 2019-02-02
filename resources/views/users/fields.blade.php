<!-- Name Field -->
<div class="form-group col-sm-6">
    {!! Form::label('name', 'Nome:') !!}
    {!! Form::text('name', null, ['class' => 'form-control']) !!}
</div>

<!-- Email Field -->
<div class="form-group col-sm-6">
    {!! Form::label('email', 'Email:') !!}
    {!! Form::email('email', null, ['class' => 'form-control']) !!}
</div>

<!-- Celphone Field -->
<div class="form-group col-sm-6">
    {!! Form::label('celphone', 'Celular:') !!}
    {!! Form::number('celphone', null, ['class' => 'form-control']) !!}
</div>

<!-- Username Field -->
<div class="form-group col-sm-6">
    {!! Form::label('username', 'Usuário:') !!}
    {!! Form::text('username', null, ['class' => 'form-control', 'max-length' => 20]) !!}
</div>

<!-- Password Field -->
<div class="form-group col-sm-6">
    {!! Form::label('password', 'Senha:') !!}
    {!! Form::password('password', ['class' => 'form-control']) !!}
</div>

@if(1 == Auth::user()->user_type_id)
<!-- User Type Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('user_type_id', 'Tipo:') !!}
    {!! Form::select('user_type_id', $userTypes, null, ['class' => 'form-control']) !!}
</div>

<!-- Plan Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('general_status_id', 'Status:') !!}
    {!! Form::select('general_status_id', $generalStatuses, null, ['class' => 'form-control']) !!}
</div>
@endif

<!-- Plan Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('plan_id', 'Pacote:') !!}
    {!! Form::select('plan_id', $plans, null, ['class' => 'form-control']) !!}
</div>

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('Salvar', ['class' => 'btn btn-primary']) !!}
    <a href="{!! route('users.index') !!}" class="btn btn-default">Cancelar</a>
</div>
