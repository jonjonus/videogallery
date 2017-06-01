{{ Form::open(['action' => [$action, $id]]) }}
    {{ csrf_field() }}
    {{ method_field('DELETE') }}
    <button type="submit" class="btn btn-xs btn-danger"><i class="fa fa-btn fa-trash"></i></button>
{{ Form::close() }}