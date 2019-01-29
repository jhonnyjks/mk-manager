<!-- Name Field -->
<div class="form-group col-sm-6">
    {!! Form::label('name', 'Name:') !!}
    {!! Form::text('name', null, ['class' => 'form-control']) !!}
</div>

<!-- Email Field -->
<div class="form-group col-sm-6">
    {!! Form::label('email', 'Email:') !!}
    {!! Form::email('email', null, ['class' => 'form-control']) !!}
</div>

<!-- Username Field -->
<div class="form-group col-sm-6">
    {!! Form::label('username', 'Username:') !!}
    {!! Form::text('username', null, ['class' => 'form-control']) !!}
</div>

<!-- Password Field -->
<div class="form-group col-sm-6">
    {!! Form::label('password', 'Password:') !!}
    {!! Form::password('password', ['class' => 'form-control']) !!}
</div>

<!-- Email Verified At Field -->
<div class="form-group col-sm-6">
    {!! Form::label('email_verified_at', 'Email Verified At:') !!}
    {!! Form::date('email_verified_at', null, ['class' => 'form-control']) !!}
</div>

<!-- Phone Field -->
<div class="form-group col-sm-6">
    {!! Form::label('phone', 'Phone:') !!}
    {!! Form::number('phone', null, ['class' => 'form-control']) !!}
</div>

<!-- Celphone Field -->
<div class="form-group col-sm-6">
    {!! Form::label('celphone', 'Celphone:') !!}
    {!! Form::number('celphone', null, ['class' => 'form-control']) !!}
</div>

<!-- Cpf Cnpj Field -->
<div class="form-group col-sm-6">
    {!! Form::label('cpf_cnpj', 'Cpf Cnpj:') !!}
    {!! Form::number('cpf_cnpj', null, ['class' => 'form-control']) !!}
</div>

<!-- User Type Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('user_type_id', 'User Type Id:') !!}
    {!! Form::number('user_type_id', null, ['class' => 'form-control']) !!}
</div>

<!-- Plan Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('plan_id', 'Plan Id:') !!}
    {!! Form::number('plan_id', null, ['class' => 'form-control']) !!}
</div>

<!-- Last Payment Field -->
<div class="form-group col-sm-6">
    {!! Form::label('last_payment', 'Last Payment:') !!}
    {!! Form::date('last_payment', null, ['class' => 'form-control']) !!}
</div>

<!-- Remember Token Field -->
<div class="form-group col-sm-6">
    {!! Form::label('remember_token', 'Remember Token:') !!}
    {!! Form::text('remember_token', null, ['class' => 'form-control']) !!}
</div>

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
    <a href="{!! route('users.index') !!}" class="btn btn-default">Cancel</a>
</div>
