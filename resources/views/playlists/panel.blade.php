<div class="playlist-view sidebar-nav-fixed pull-right affix" style="margin-right: 10px;">
	@if ($playlist_obj)
	<div class="panel panel-success">
		<div class="panel-heading">
				{{ $playlist_obj->title }}
	@else
	<div class="panel panel-warning">
		<div class="panel-heading">
				New Playlist
	@endif
	</div>
	<div class="panel-body" style="max-width: 100%;">
		<div class="dragula-container dragable-video-list">
			@foreach ($playlist_videos as $video)
					<div id="{{ $video->id }}" class="dragable-video-item" style="max-width: 100%;">
						<div class="ellipsis">{{ $video->title }}</div>
						<div>
							<form data-id="{{ $video->id }}"
								  method="POST"
								  action="{{ action('PlaylistsController@remove', [$video->id]) }}"
								  accept-charset="UTF-8"
								  class="form-remove-{{ $video->id }} btn-group">
								<button type="submit" class="btn btn-xs btn-warning btn-playlist-panel"><i class="fa fa-btn fa-minus"></i></button>
								{{ csrf_field() }}
								{{ method_field('DELETE') }}
								<img style="width: 50px;" class="myThumbnail" src="{{ $video->thumbnail }}">
							</form>
						</div>
					</div>
				@endforeach
		</div>
		{{-- buttons --}}
		@if ($playlist_obj)
		<div class="btn-group-vertical" role="group" aria-label="...">
			{{-- Update --}}
			{!! Form::model($playlist_obj, [
			'class' 	=> 'form-horizontal form-with-video-list',
			'method' 	=> 'PATCH',
			'action' 	=> ['PlaylistsController@update', $playlist_obj->id]]) !!}
				{{ Form::input('hidden', 'title', null, ['id' => 'title', 'name' => 'title', 'class' => 'form-control firstField'] ) }}
				{!! Form::submit('Save', ['class' => 'btn btn-primary btn-playlist-panel-control' ]) !!}
			{{ Form::close() }}

			{{-- Close --}}
			{{ Form::open(['action' => 'PlaylistsController@removeall']) }}
				{{ csrf_field() }}
				{{ method_field('POST') }}
				<button type="submit" class="btn btn-danger btn-playlist-panel-control">Close</button>
			{{ Form::close() }}

			{{-- Details --}}
			<a class="btn btn-success" target="_blank" href="{{ action('PlaylistsController@edit', [$playlist_obj->id]) }}" role="button">Details</a>

		@elseif(count($playlist_videos))

		<div class="btn-group-vertical" role="group" aria-label="...">
			{{-- Open --}}
			{{ Form::open(['action' => 'PlaylistsController@store'])}}
				{{ csrf_field() }}
				{{ method_field('POST') }}
				<!-- Title -->
				<div class="form-group">
					{{ Form::label('playlist-title', 'Title', ['class' => 'col-sm-1 control-label']) }}
						{{ Form::input('text', 'title', null, ['id' => 'playlist-title', 'class' => 'form-control'] ) }}
				</div>
				<!-- Description -->
				<div class="form-group">
					{{ Form::label('playlist-description', 'Description', ['class' => 'col-sm-1 control-label']) }}
						{{ Form::textarea('description', null, ['class' => 'form-control', 'size' => '10x5']) }}
				</div>
				<!-- Password -->
				<div class="form-group">
					{{ Form::label('playlist-password', 'Password', ['class' => 'col-sm-1 control-label']) }}
						{{ Form::input('text', 'password', null, ['id' => 'playlist-password', 'class' => 'form-control'] ) }}
				</div>

				{{-- <a class="btn btn-primary" href="{{ action('PlaylistsController@create') }}" role="button">Create</a> --}}
				<button type="submit" class="btn btn-primary btn-playlist-panel-control" disabled>Create</button>
			{{ Form::close() }}


			{{-- Empty --}}
			{{ Form::open(['action' => 'PlaylistsController@removeall', 'data-function' => 'hook_empty']) }}
				{{ csrf_field() }}
				{{ method_field('POST') }}
				<button type="submit" class="btn btn-danger btn-playlist-panel-control">Empty</button>
			{{ Form::close() }}
		</div>

		@else

		Playlist is empty

		@endif
	</div>
	</div>
</div>
