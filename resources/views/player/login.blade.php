@extends('player.layout')

{{--@section('content')--}}
	{{--<form role="form" method="POST">--}}
	    {{--<div class="form-group">--}}
	      {{--<label for="pwd">Please enter playlist password:</label>--}}
	      {{--<input type="hidden" class="form-control" id="id" name="id" value ="2">--}}
	      {{--<input type="password" class="form-control" id="password" name="password" style="max-width: 300px;">--}}
	    {{--</div>--}}
	    {{--<button type="submit" class="btn btn-default">Enter</button>--}}
	{{--</form>--}}
{{--@endsection--}}


@section('content')
	<div class="container-fluid">
		<!-- Display Validation Errors -->
		@include('common.errors')
		{!! Form::open([
					'action' => $action,
					'method' => 'GET']) !!}
			<div class="form-group">
				{{ Form::label('password', 'Password', ['class' => 'col-sm-1 control-label']) }}
				{{ Form::input('text', 'password', null, ['id' => 'password', 'class' => 'form-control firstField'] ) }}
			</div>
			{!! Form::submit('Enter', ['class' => 'btn btn-primary btn-submit' ]) !!}
		{!! Form::close() !!}
	</div>


@endsection
