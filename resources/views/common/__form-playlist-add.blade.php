{{ Form::open(['action' => [$action, $id]]) }}
    {{ csrf_field() }}
    {{ method_field('PUT') }}
    <button type="submit" class="btn btn-xs btn-success btn-playlist"><i class="fa fa-btn fa-plus"></i></button>
{{ Form::close() }}