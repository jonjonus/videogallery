@extends('layouts.app')

@section('content')
	<div class="container-fluid">
		<!-- Display Validation Errors -->
		<div class="row">
	        @include('common.errors')
		</div> <!-- end row -->
		{!! Form::model($playlist, [
				'class' 	=> 'form-horizontal',
				]) !!}
			<!-- Form -->
			<div class="row">
				@include('playlists._form', ['disabledFields' => 'disabled'])
			</div> <!-- end row -->
			<!-- Buttons -->
			<div class="row">
				<div class="col-sm-12">
					 <a class="btn btn-info" href="{{ action('PlaylistsController@index') }}" role="button">Close</a>
				</div>
			</div> <!-- end row -->
		{!! Form::close() !!}
  	</div>
@endsection