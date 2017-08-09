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
	<script src="/DataTables/jQuery-2.2.4/jquery-2.2.4.min.js"></script>
	<script src="/DataTables/Bootstrap-3.3.7/js/bootstrap.min.js"></script>
	<script src="/DataTables/Select2-4.0.1/js/select2.full.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.4/js/bootstrap-datepicker.min.js"></script>

	<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/js/bootstrap.min.js"></script>
	<script src="/js/video.edit.js"></script>
@endsection

@section(('stylesheets'))
	<link rel='stylesheet' type='text/css' href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.4/css/bootstrap-datepicker.min.css">
	<link rel='stylesheet' type='text/css' href="/DataTables/Select2-4.0.1/css/select2.min.css">
	<link rel='stylesheet' type='text/css' href="/DataTables/Bootstrap-3.3.7/css/bootstrap.min.css">
@endsection
