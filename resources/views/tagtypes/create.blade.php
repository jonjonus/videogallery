@extends('layouts.app')

@section('content')
	<div class="container-fluid">
		<div class="row">
			<!-- Display Validation Errors -->
            @include('common.errors')

			{!! Form::open([
				'class' => 'form-horizontal',
				'action' => 'TagtypesController@store' ]) !!}
				@include('tagtypes._form', ['submitButtonText' => 'Save'])
			{!! Form::close() !!}
	  	</div>
	</div>
@endsection