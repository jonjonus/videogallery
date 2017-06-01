@extends('layouts.app')

@section('content')
	<div class="container-fluid">
		<!-- Display Validation Errors -->
		<div class="row">
	        @include('common.errors')
		</div> <!-- end row -->
		{!! Form::model($playlist, [
			'class' 	=> 'form-horizontal form-with-video-list',
			'method' 	=> 'PATCH',
			'action' 	=> ['PlaylistsController@update', $playlist->id]]) !!}
			<!-- Form -->
			<div class="row">
				@include('playlists._form', ['disabledFields' => ''])
			</div> <!-- end row -->
			<!-- Buttons -->
			<div class="row">
				<div class="col-sm-12">
					{!! Form::submit('Save', ['class' => 'btn btn-primary' ]) !!}
				</div>
			</div> <!-- end row -->
		{!! Form::close() !!}
  	</div>
@endsection
