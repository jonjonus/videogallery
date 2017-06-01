<!-- Title -->
<div class="form-group">
	{{ Form::label('playlist-title', 'Title', ['class' => 'col-sm-1 control-label']) }}
	<div class="col-sm-10">
		{{ Form::input('text', 'title', null, ['id' => 'playlist-title', 'class' => 'form-control firstField', 'placeholder' => 'Title', $disabledFields] ) }}
	</div>
</div>

<!-- URL -->
<div class="form-group">
	{{ Form::label('playlist-url', 'URL', ['class' => 'col-sm-1 control-label']) }}
	<div class="col-sm-10">
		{{ Form::url('url', null, ['id' => 'playlist-url', 'class' => 'form-control', 'placeholder' => 'URL', 'disabled' => 'disabled'] ) }}
	</div>
</div>

<!-- Description -->
<div class="form-group">
	{{ Form::label('playlist-description', 'Description', ['class' => 'col-sm-1 control-label']) }}
	<div class="col-sm-10">
		{{ Form::textarea('description', null, ['class' => 'form-control', 'placeholder' => 'Please enter a description here...', 'size' => '50x10']) }}
	</div>
</div>

<!-- Password -->
<div class="form-group">
	{{ Form::label('playlist-password', 'Password', ['class' => 'col-sm-1 control-label']) }}
	<div class="col-sm-10">
		{{ Form::input('text', 'password', null, ['id' => 'playlist-password', 'class' => 'form-control firstField', 'placeholder' => 'Password', $disabledFields] ) }}
	</div>
</div>