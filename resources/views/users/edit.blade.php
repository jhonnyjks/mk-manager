@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            Editar usuário {!! !empty($user->username) ? $user->username : $user->name !!}
        </h1>
   </section>
   <div class="content">
       @include('adminlte-templates::common.errors')
       @include('flash::message')
       <div class="box box-primary">
        <p class="bg-warning" style="padding: 5px;">Por favor, mantenha o email e celular atualizados.</p>
           <div class="box-body">
               <div class="row">
                   {!! Form::model($user, ['route' => ['users.update', $user->id], 'method' => 'patch']) !!}

                        @include('users.fields')

                   {!! Form::close() !!}
               </div>
           </div>
       </div>
   </div>
@endsection