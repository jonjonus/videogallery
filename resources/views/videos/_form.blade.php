<div class="row">
	<div class="form-group">
		<!-- Title -->
		{{ Form::label('video-title', 'Title', ['class' => 'col-sm-1 control-label']) }}
		<div class="col-sm-7">
			{{ Form::input('text', 'title', null, ['id' => 'video-title', 'class' => 'form-control firstField', 'placeholder' => 'Title', $disabledFields] ) }}
		</div>
		
		<!-- Produced At -->
		{{ Form::label('video-produced_at', 'Produced at', ['class' => 'col-sm-1 control-label']) }}
		<div class="col-sm-2">
			<div class="input-group">
				{{ Form::input('text', 'produced_at', null, ['id' => 'video-produced_at', 'class' => 'form-control', 'placeholder' => 'Select a date', $disabledFields] ) }}
				<div class="input-group-addon">
					<span class="glyphicon glyphicon-th"></span>
				</div>
			</div>
		</div>
	</div>

	<div class="form-group">
		<!-- Name -->
		{{ Form::label('video-name', 'Name', ['class' => 'col-sm-1 control-label']) }}
		<div class="col-sm-7">
			{{ Form::input('text', 'name', null, ['id' => 'video-name', 'class' => 'form-control firstField', 'placeholder' => 'Name', $disabledFields] ) }}
		</div>

		<!-- Client -->
		{{ Form::label('video-client_id', 'Client', ['class' => 'col-sm-1 control-label']) }}
		<div class="col-sm-2">
			{{ Form::select(
						'client_id',
						[null=>'Select...']+$clients,
					 	null,
					 	['id' => 'video-client_id', 'class' => 'form-control', $disabledFields]
			) }}
		</div>
	</div>

	<!-- Description -->
	<div class="form-group">
		{{ Form::label('video-description', 'Description', ['class' => 'col-sm-1 control-label']) }}
		<div class="col-sm-10">
			{{ Form::textarea('description', null, ['id' => 'video-description', 'class' => 'form-control', 'placeholder' => 'Description', 'rows' => '3', $disabledFields] ) }}
		</div>
	</div>

    <!-- Cloud Id -->
	<div class="form-group">
		{{ Form::label('video-cloud_id', 'Service Id', ['class' => 'col-sm-1 control-label']) }}
		<div class="col-sm-10">
			{{ Form::input('text', 'cloud_id', null, ['id' => 'video-cloud_id', 'class' => 'form-control', 'placeholder' => 'Service Id', $disabledFields] ) }}
		</div>
	</div>

    @if (substr(Route::currentRouteAction(), (strpos(Route::currentRouteAction(), '@') + 1) ) != 'editBulk')
	<!-- Service Id -->
	<div class="form-group">
		{{ Form::label('video-service_id', 'Service', ['class' => 'col-sm-1 control-label']) }}
		<div class="col-sm-2">
			{{ Form::select(
						'service_id',
						[null=>'Select...']+$services,
						null,
						['id' => 'video-service_id', 'class' => 'form-control', $disabledFields]
			) }}
		</div>
	</div>

	<!-- Embed -->
	<div class="form-group">
		{{ Form::label('video-embed', 'Embed Code', ['class' => 'col-sm-1 control-label']) }}
		<div class="col-sm-10">
			{{ Form::textarea('embed', null, ['id' => 'video-embed', 'class' => 'form-control', 'placeholder' => 'Embed Code', 'rows' => '3', $disabledFields] ) }}
		</div>
	</div>
    @endif

	<!-- Thumbnail -->
	<div class="form-group">
		{{ Form::label('video-thumbnail', 'Thumbnail', ['class' => 'col-sm-1 control-label']) }}
		<div class="col-sm-10">
			{{ Form::input('text', 'thumbnail', null, ['id' => 'video-thumbnail', 'class' => 'form-control', 'placeholder' => 'Thumbnail', $disabledFields] ) }}
		</div>
	</div>

	<!-- Thumbnail_sm -->
	<div class="form-group">
		{{ Form::label('video-thumbnail-sm', 'Thumbnail Small', ['class' => 'col-sm-1 control-label']) }}
		<div class="col-sm-10">
			{{ Form::input('text', 'thumbnail_sm', null, ['id' => 'video-thumbnail-sm', 'class' => 'form-control', 'placeholder' => 'Thumbnail Small', $disabledFields] ) }}
		</div>
	</div>
	<!-- Thumbnail_hq -->
	<div class="form-group">
		{{ Form::label('video-thumbnail-hq', 'Thumbnail High Quality', ['class' => 'col-sm-1 control-label']) }}
		<div class="col-sm-10">
			{{ Form::input('text', 'thumbnail_hq', null, ['id' => 'video-thumbnail-hq', 'class' => 'form-control', 'placeholder' => 'Thumbnail High Quality', $disabledFields] ) }}
		</div>
	</div>

	@if (substr(Route::currentRouteAction(), (strpos(Route::currentRouteAction(), '@') + 1) ) != 'editBulk')
	<!-- URL -->
	<div class="form-group">
		{{ Form::label('video-url', 'URL', ['class' => 'col-sm-1 control-label']) }}
		<div class="col-sm-10">
			{{ Form::url('url', null, ['id' => 'video-url', 'class' => 'form-control', 'placeholder' => 'URL', $disabledFields] ) }}
		</div>
	</div>
	@endif

	<!-- Ignore -->
	<div class="form-group">
		<div class="col-sm-offset-1 col-sm-10">
	      	<div class="checkbox">
	        	<label>
	        		<input type="checkbox" name="ignore" id="video-ignore" @if (old('ignore') == 'on' || (isset($video->ignore) && $video->ignore)) checked @endif {{ $disabledFields }}>Ignore
	        	</label>
	      	</div>
		</div>
		</div>

	<div class="form-group">
		<!-- Count Reposts-->
		{{ Form::label('video-count_reposts', 'Reposts', ['class' => 'col-sm-1 control-label']) }}
		<div class="col-sm-1">
			{{ Form::input('text', 'count_reposts', null, ['id' => 'video-count_reposts', 'class' => 'form-control', 'placeholder' => 'Reposts', $disabledFields] ) }}
		</div>

		<!-- Count Watch-->
		{{ Form::label('video-count_watch', 'Watched', ['class' => 'col-sm-1 control-label']) }}
		<div class="col-sm-1">
			{{ Form::input('text', 'count_watch', null, ['id' => 'video-count_watch', 'class' => 'form-control', 'placeholder' => 'Watched', $disabledFields] ) }}
		</div>

		<!-- Cloud Likes-->
		{{ Form::label('video-count_likes', 'Likes at', ['class' => 'col-sm-1 control-label']) }}
		<div class="col-sm-1">
			{{ Form::input('text', 'count_likes', null, ['id' => 'video-count_likes', 'class' => 'form-control', 'placeholder' => 'Likes', $disabledFields] ) }}
		</div>
	</div>

	@if (substr(Route::currentRouteAction(), (strpos(Route::currentRouteAction(), '@') + 1) ) != 'editBulk')
	<!-- Metatexts -->
	<div class="form-group">
		{{ Form::label('metatexts', 'Metatexts', ['class' => 'col-sm-1 control-label']) }}
		<div class="col-sm-10">
			{{ Form::select(
						'metatexts[]',
						$metatexts,
						(isset($video) ? $video->metatexts->lists('id')->toArray() : array()),
						['id' => 'metatexts', 'class' => 'form-control select2', 'multiple' => 'multiple', $disabledFields] ) }}
			<?php
			//TODO: new metatexts are not persisted if form validation fails
			?>
		</div>
	</div>
	@endif
</div> <!-- end row -->

@if (substr(Route::currentRouteAction(), (strpos(Route::currentRouteAction(), '@') + 1) ) != 'editBulk')
<!-- Tags -->
<div class="row">
	<div class="col-sm-10 col-sm-offset-1">
		<div class="panel panel-default">
			<div class="panel-heading">Tags</div>
			<div class="panel-body">
				@foreach ($tagtypes as $tagtype)
					<div class="form-group">
						{{ Form::label($tagtype->name.'_list', $tagtype->name, ['class' => 'col-sm-1 control-label']) }}
						<div class="col-sm-11">
							{{ Form::select($tagtype->name.'_list[]',
											$tagtype->tagList,
											(isset($video) ? $video->getTagsForType($tagtype) : array()),
											['id' => $tagtype->name.'_list', 'class' => 'form-control select2', 'multiple', $disabledFields] ) }}
						</div>
					</div>
				 @endforeach
			</div>
		</div>
	</div> <!-- end col -->
</div> <!-- end row -->
@endif