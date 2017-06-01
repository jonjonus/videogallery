{{ Form::open(['action' => [$action]]) }}
{{ csrf_field() }}
{{ method_field('POST') }}
<input type="hidden" value="no" name="confirm" id="confirm">
<input type="hidden" value="{{ $id }}" name="playlist_id" id="playlist_id">
<button type="submit" class="btn btn-xs btn-success"><i class="fa fa-btn fa-upload"></i></button>
{{ Form::close() }}
