@extends('layouts.app')

@section('content')
	<div class="container-fluid">
		<div class="row">
			<!-- Display Validation Errors -->
            @include('common.errors')

			{!! Form::model($metatext, [
				'class' 	=> 'form-horizontal',
				'method' 	=> 'PATCH',
				'action' 	=> ['MetatextsController@update', $client->id]]) !!}
				@include('metatexts._form', ['submitButtonText' => 'Save'])
			{!! Form::close() !!}
	  	</div>
	</div>
@endsection