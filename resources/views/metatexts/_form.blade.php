<!-- Name -->
<div class="form-group">
	{{ Form::label('client-name', 'Name', ['class' => 'col-sm-1 control-label']) }}
	<div class="col-sm-10">
		{{ Form::input('text', 'name', null, ['id' => 'client-name', 'class' => 'form-control firstField', 'placeholder' => 'Name'] ) }}
	</div>
</div>
{{-- TODO esta bien ese client-name en la linea 5???--}}

<!-- Buttons -->
<div class="form-group">
	<div class="col-sm-12">
		{!! Form::submit($submitButtonText, ['class' => 'btn btn-primary' ]) !!}
	</div>
</div>