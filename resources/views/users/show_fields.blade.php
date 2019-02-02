<!-- Name Field -->
<div class="form-group">
    {!! Form::label('name', 'Nome:') !!}
    <p>{!! $user->name !!}</p>
</div>

<!-- Email Field -->
<div class="form-group">
    {!! Form::label('email', 'Email:') !!}
    <p>{!! $user->email !!}</p>
</div>

<!-- Username Field -->
<div class="form-group">
    {!! Form::label('username', 'Usuário:') !!}
    <p>{!! $user->username !!}</p>
</div>

<!-- Phone Field -->
<div class="form-group">
    {!! Form::label('phone', 'Telefone:') !!}
    <p>{!! $user->phone !!}</p>
</div>

<!-- Celphone Field -->
<div class="form-group">
    {!! Form::label('celphone', 'Celular:') !!}
    <p>{!! $user->celphone !!}</p>
</div>

<!-- Cpf Cnpj Field -->
<div class="form-group">
    {!! Form::label('cpf_cnpj', 'Cpf/Cnpj:') !!}
    <p>{!! $user->cpf_cnpj !!}</p>
</div>

<!-- User Type Id Field -->
<div class="form-group">
    {!! Form::label('user_type_id', 'Tipo:') !!}
    <p>{!! $user->userType->name !!}</p>
</div>

<!-- Plan Id Field -->
<div class="form-group">
    {!! Form::label('plan_id', 'Pacote:') !!}
    <p>{!! !empty($user->plan_id) ? $user->plan->name : '--'!!}</p>
</div>

<!-- Last Payment Field -->
<div class="form-group">
    {!! Form::label('last_payment', 'Último pagamento:') !!}
    <p>{!! $user->last_payment !!}</p>
</div>

<!-- Created At Field -->
<div class="form-group">
    {!! Form::label('created_at', 'Criado em:') !!}
    <p>{!! date("d-m-Y", strtotime($user->created_at)) !!}</p>
</div>

