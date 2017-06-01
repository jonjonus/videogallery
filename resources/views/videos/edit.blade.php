{{-- {{ dd(get_defined_vars()) }} --}}
@extends('layouts.app')

@section('content')
	<div class="container-fluid">
		<!-- Display Validation Errors -->
        {{--@include('common.errors')--}}
		{!! Form::model($video, [
			'class' 	=> 'form-horizontal',
			'method' 	=> 'PATCH',
			'action' 	=> [$action, $video->id]]) !!}
			{{-- 
			Regular Edit: action-> VideosController@update 
			Bulk Edit:  action-> VideosController@updateBulk 
			--}}
			@include('videos._form', ['disabledFields' => ''])
			<!-- Buttons -->
			<div class="row">
				<div class="col-sm-12">
					{!! Form::submit('Save', ['class' => 'btn btn-primary btn-submit' ]) !!}
					<a class="btn btn-warning"  href="{{ action('VideosController@index') }}" role="button">Cancel</a>
				</div>
			</div> <!-- end row -->
		{!! Form::close() !!}
  	</div>


@endsection

@section('variables')
	<script>
		var optionsMetatexts = {!!  json_encode($metatexts) !!};
	</script>
@endsection

@section('scripts')
	<script src="/js/video.edit.js"></script>
@endsection
