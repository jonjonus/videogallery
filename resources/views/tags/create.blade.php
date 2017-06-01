@extends('layouts.app')

@section('content')
	<div class="container-fluid">
		<div class="row">
			<!-- Display Validation Errors -->
            @include('common.errors')

			{!! Form::open([
				'class' => 'form-horizontal',
				'action' => 'TagsController@store' ]) !!}
				@include('tags._form', ['submitButtonText' => 'Save', 'disabledFields' => ''])
			{!! Form::close() !!}
	  	</div>
	</div>
@endsection