<!-- Name -->
<div class="form-group">
	{{ Form::label('tagtype-name', 'Name', ['class' => 'col-sm-1 control-label']) }}
	<div class="col-sm-10">
		{{ Form::input('text', 'name', null, ['id' => 'tagtype-name', 'class' => 'form-control firstField', 'placeholder' => 'Name'] ) }}
	</div>
</div>				

<!-- Buttons -->
<div class="form-group">
	<div class="col-sm-12">
		{!! Form::submit($submitButtonText, ['class' => 'btn btn-primary' ]) !!}
	</div>
</div>