@extends('layouts.app')

@section('content')
	<div class="container-fluid">
	  	<div class="row">
			{!! Form::open() !!}
				<!-- Name -->
				<div class="form-group">
					<label for="client-name" class="col-sm-1 control-label">Name</label>
					<div class="col-sm-9">
						<input type="text" name="name" id="client-name" class="form-control" value="{{ $metatext->name }}">
					</div>
				</div>
			{!! Form::close() !!}
	 	</div>
	</div>
@endsection