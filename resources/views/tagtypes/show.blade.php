{{-- {{ dd(get_defined_vars()) }} --}}
@extends('layouts.app')

@section('content')
	<div class="container-fluid">
		<div class="row">
			<!-- Display Validation Errors -->
            @include('common.errors')
			{!! Form::model($tagtype, [
				'class' 	=> 'form-horizontal',
				'method' 	=> 'PATCH',
				'action' 	=> ['TagtypesController@update', $tagtype->id]]) !!}
				@include('tagtypes._form', ['submitButtonText' => 'Save', 'disabledFields' => 'disabled'])
			{!! Form::close() !!}
	  	</div>
	</div>
@endsection

{{-- {{ $tagtype->produced_at->diffForHumans() }} --}}