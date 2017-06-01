<div class="row row-panel"> {{-- FORM VIDEO LIST --}}
	<div class="col-sm-11">
		<div class="panel panel-default">
	  		<div class="panel-heading">Playlist</div>
		  	<div id="dragable-video-list" class="panel-body dragula-container">
				@foreach ($videos as $video)
					<div id="{{ $video->id }}" class="dragable-video-item">
						Video
						{{ Form::open(['action' => ['PlaylistsController@remove', $video->id]]) }}
						    {{ csrf_field() }}
						    {{ method_field('DELETE') }}
						    <button type="submit" class="btn btn-default btn-playlist">{{ $video->id }}</button>
						{{ Form::close() }}
					</div>
			    @endforeach
			</div>
		</div>
	</div>
	<div  class="col-sm-1">
		<div class="btn-group-vertical" role="group" aria-label="...">
			{{-- Empty --}}
			{{ Form::open(['action' => 'PlaylistsController@removeall']) }}
			    {{ csrf_field() }}
			    {{ method_field('POST') }}
			    <button type="submit" class="btn btn-danger btn-playlist">Empty</button>
			{{ Form::close() }}
		</div>
	</div>
</div>