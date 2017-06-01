{{ Form::open(['action' => 'PlaylistsController@load']) }}
{{ csrf_field() }}
{{ method_field('POST') }}
<input type="hidden" value="yes" name="confirm" id="confirm">
<input type="hidden" value="{{ $playlist_id }}" name="playlist_id" id="playlist_id">
<button type="submit" class="btn btn-sm btn-danger">Contiue</button>
{{ Form::close() }}
