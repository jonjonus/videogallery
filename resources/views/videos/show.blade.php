{{-- {{ dd(get_defined_vars()) }} --}}
@extends('layouts.app')

@section('content')
	<div class="container-fluid">
		<div class="row">
			<!-- Display Validation Errors -->
            @include('common.errors')
		</div> <!-- end row -->
		{!! Form::model($video, [
			'class' 	=> 'form-horizontal',
			'method' 	=> 'PATCH',
			'action' 	=> ['VideosController@update', $video->id]]) !!}
			<!-- Form -->
			<div class="row">
				@include('videos._form', ['disabledFields' => 'disabled'])
			</div> <!-- end row -->
			<!-- Buttons -->
			<div class="row">
				<div class="col-sm-12">
					<a class="btn btn-info" href="{{ action('VideosController@index') }}" role="button">Close</a>
				</div>
			</div> <!-- end row -->
		{!! Form::close() !!}
	  	</div>
	</div>
@endsection

{{-- {{ $video->produced_at->diffForHumans() }} --}}