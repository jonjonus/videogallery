		{{-- {{ dd(get_defined_vars()) }} --}}
@extends('layouts.app')

@section('content')
	<div class="container-fluid">
		<div class="row">
			<!-- Display Validation Errors -->
            @include('common.errors')

			{!! Form::open([
				'class' => 'form-horizontal',
				'action' => 'VideosController@store' ]) !!}
				@include('videos._form', ['disabledFields' => ''])
				<!-- Buttons -->
				<div class="row">
						<div class="col-sm-12">
							{!! Form::submit('Save', ['class' => 'btn btn-primary btn-submit' ]) !!}
						</div>
				</div> <!-- end row -->
			{!! Form::close() !!}
	  	</div>
	</div>
@endsection

@section('scripts')
	<script src="/js/app_video.js"></script>
@endsection