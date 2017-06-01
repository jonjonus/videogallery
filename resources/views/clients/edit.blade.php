@extends('layouts.app')

@section('content')
	<div class="container-fluid">
		<div class="row">
			<!-- Display Validation Errors -->
            @include('common.errors')

			{!! Form::model($client, [
				'class' 	=> 'form-horizontal',
				'method' 	=> 'PATCH',
				'action' 	=> ['ClientsController@update', $client->id]]) !!}
				@include('clients._form', ['submitButtonText' => 'Save'])
			{!! Form::close() !!}
	  	</div>
	</div>
@endsection