{{ Form::open(['action' => [$action, $id]]) }}
    {{ csrf_field() }}
    {{ method_field('DELETE') }}
    <button type="submit" class="btn btn-xs btn-warning btn-playlist"><i class="fa fa-btn fa-minus"></i></button>
{{ Form::close() }}


