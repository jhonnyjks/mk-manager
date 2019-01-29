@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            Plan
        </h1>
   </section>
   <div class="content">
       @include('adminlte-templates::common.errors')
       <div class="box box-primary">
           <div class="box-body">
               <div class="row">
                   {!! Form::model($plan, ['route' => ['plans.update', $plan->id], 'method' => 'patch']) !!}

                        @include('plans.fields')

                   {!! Form::close() !!}
               </div>
           </div>
       </div>
   </div>
@endsection