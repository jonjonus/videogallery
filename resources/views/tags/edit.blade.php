@extends('layouts.app')

@section('content')
	<div class="container-fluid">
		<div class="row">
			<!-- Display Validation Errors -->
            @include('common.errors')

			{!! Form::model($tag, [
				'class' 	=> 'form-horizontal',
				'method' 	=> 'PATCH',
				'action' 	=> ['TagsController@update', $tag->id]]) !!}
				@include('tags._form', ['submitButtonText' => 'Save', 'disabledFields' => ''])
			{!! Form::close() !!}
	  	</div>
	</div>
@endsection