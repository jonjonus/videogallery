<!-- Name -->
<div class="form-group">
	{{ Form::label('tag-value', 'Value', ['class' => 'col-sm-1 control-label']) }}
	<div class="col-sm-10">
		{{ Form::input('text', 'value', null, ['id' => 'tag-value', 'class' => 'form-control firstField', 'placeholder' => 'Name', $disabledFields] ) }}
	</div>
</div>				

<!-- Type -->
<div class="form-group">
	{{ Form::label('tag-type_id', 'Type', ['class' => 'col-sm-1 control-label']) }}
	<div class="col-sm-10">
		{{ Form::select('tagtype_id',[null=>'Select...'] + $tagtypes, null, ['id' => 'tag-type_id', 'class' => 'form-control', $disabledFields] ) }}
	</div>
</div>

<!-- Buttons -->
<div class="form-group">
	<div class="col-sm-12">
		{!! Form::submit($submitButtonText, ['class' => 'btn btn-primary' ]) !!}
	</div>
</div>