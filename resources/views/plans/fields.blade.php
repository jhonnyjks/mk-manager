<!-- Hotspot Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('hotspot_id', 'Hotspot Id:') !!}
    {!! Form::text('hotspot_id', null, ['class' => 'form-control']) !!}
</div>

<!-- Name Field -->
<div class="form-group col-sm-6">
    {!! Form::label('name', 'Name:') !!}
    {!! Form::text('name', null, ['class' => 'form-control']) !!}
</div>

<!-- Price Field -->
<div class="form-group col-sm-6">
    {!! Form::label('price', 'Price:') !!}
    {!! Form::number('price', null, ['class' => 'form-control']) !!}
</div>

<!-- Shared Users Field -->
<div class="form-group col-sm-6">
    {!! Form::label('shared_users', 'Shared Users:') !!}
    {!! Form::number('shared_users', null, ['class' => 'form-control']) !!}
</div>

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
    <a href="{!! route('plans.index') !!}" class="btn btn-default">Cancel</a>
</div>
