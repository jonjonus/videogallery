{{-- {{ dd(get_defined_vars()) }} --}}
@extends('layouts.app')

@section('content')
	<div class="container-fluid">
		<div class="row">
			<!-- Display Validation Errors -->
            @include('common.errors')
	  	</div> <!-- end row -->
		{!! Form::open([
			'class' => 'form-horizontal form-with-video-list',
			'action' => 'PlaylistsController@store' ]) !!}
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
		@include('playlists._videosList'){{-- Includes row --}}
	</div>
@endsection

@section('scripts')
	<script src="/js/formWithVideoList.js"></script>
@endsection