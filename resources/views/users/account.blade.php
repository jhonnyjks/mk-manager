@extends('layouts.app')

@section('content')

	<section class="content-header">
		<h1>
			Olá, {!! !empty(Auth::user()->name) ? Auth::user()->name : Auth::user()->username !!}!
		</h1>
	</section>
	<div class="content">
		@include('flash::message')
       <div class="box box-primary">
       	@if(empty(Auth::user()->celphone) || empty(Auth::user()->email))
       		<p class="bg-warning" style="padding: 5px;">Por favor, mantenha o email e celular atualizados para receber notificações importantes!</p>
		@endif
          	<div class="box-body">
              	<div class="row">
               		<div class="col-xs-12 col-sm-6 col-lg-4 {{ Auth::user()->general_status_id == 2 ? 'text-danger' : 'text-success' }}">
				    	{!! Form::label('name', 'STATUS: '.strtoupper(Auth::user()->generalStatus->name)) !!}
					</div>

					@if(date('Ymd', strtotime(Auth::user()->last_payment)) < date("Ymd", strtotime(date('Y-m-d'). ' - 30 days')))
               		<div class="col-xs-12 col-sm-6 col-lg-4 text-danger">
           				{!! Form::label('name', 'PAGAMENTO: PENDENTE') !!}
				    	@if(Auth::user()->general_status_id == 2)
					    	@if(Auth::user()->payment_promise < 2)
			                <a class="btn btn-{!! Auth::user()->payment_promise < 1 ? 'warning' : 'danger' !!}" style="font-size: 0.8em;" href="{!! route('users.promisePayment', [Auth::user()->id]) !!}" onclick="return confirm('Confirmar PROMESSA DE PAGAMENTO do usuário {!! Auth::user()->username !!}?')">PROMESSA</a>
			                @else
			                <small>(Pagamento adiado 2x)</small>
			                @endif
				    	@endif
					</div>
					@else
					<div class="col-xs-12 col-sm-6 col-lg-4 text-success">
				    	{!! Form::label('name', 'PAGAMENTO: EM DIAS') !!}
				    </div>
				    @endif

				    <div class="col-xs-12 col-sm-6 col-lg-4">
				    	{!! Form::label('name', 'VENCIMENTO: '.date("d/m/Y", strtotime(Auth::user()->last_payment. ' + 30 days'))) !!}
					</div>
               </div>
           </div>
       </div>
	</div>
@endsection
