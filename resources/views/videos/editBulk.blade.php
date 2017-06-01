{{-- {{ dd(get_defined_vars()) }} --}}
@extends('layouts.app')

@section('content')
	<div class="container-fluid">
			<!-- Display Validation Errors -->
            @include('common.errors')
			{!! Form::open([
				'class' => 'form-horizontal form-with-video-list',
				'action' => 'VideosController@updateBulk' ]) !!}
				{{-- 
				Regular Edit: action-> VideosController@update 
				Bulk Edit:  action-> VideosController@updateBulk 
				--}}
				@include('videos._form', ['disabledFields' => ''])
				<!-- Buttons -->
				<div class="row">
					<div class="col-sm-12">
						{!! Form::submit('Save Bulk', ['class' => 'btn btn-primary btn-submit' ]) !!}
						<a class="btn btn-warning"  href="{{ action('VideosController@index') }}" role="button">Cancel</a>
					</div>
				</div> <!-- end row -->
			{!! Form::close() !!}

		<div class="row row-panel"> {{-- EDIT BULK FORM VIDEO LIST --}}
			<div class="col-sm-11">
				<div class="panel panel-default">
			  		<div class="panel-heading">Videos Bulk Edit - {!! count($videos) !!}</div>
				  	<div class="panel-body">
						<ul>
						@foreach ($videos as $video)
						<li>{{ $video->title }}</li>
					    @endforeach
						</ul>
					</div>
				</div>
			</div>
		</div>
	</div> <!-- container-fluid -->

@endsection
@section('scripts')
	<script src="/js/formWithVideoList.js"></script>
@endsection