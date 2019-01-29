<!-- Id Field -->
<div class="form-group">
    {!! Form::label('id', 'Id:') !!}
    <p>{!! $plan->id !!}</p>
</div>

<!-- Hotspot Id Field -->
<div class="form-group">
    {!! Form::label('hotspot_id', 'Hotspot Id:') !!}
    <p>{!! $plan->hotspot_id !!}</p>
</div>

<!-- Name Field -->
<div class="form-group">
    {!! Form::label('name', 'Name:') !!}
    <p>{!! $plan->name !!}</p>
</div>

<!-- Price Field -->
<div class="form-group">
    {!! Form::label('price', 'Price:') !!}
    <p>{!! $plan->price !!}</p>
</div>

<!-- Shared Users Field -->
<div class="form-group">
    {!! Form::label('shared_users', 'Shared Users:') !!}
    <p>{!! $plan->shared_users !!}</p>
</div>

<!-- Updated At Field -->
<div class="form-group">
    {!! Form::label('updated_at', 'Updated At:') !!}
    <p>{!! $plan->updated_at !!}</p>
</div>

<!-- Created At Field -->
<div class="form-group">
    {!! Form::label('created_at', 'Created At:') !!}
    <p>{!! $plan->created_at !!}</p>
</div>

