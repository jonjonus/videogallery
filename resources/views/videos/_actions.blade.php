{{-- Add --}}
<form data-id="[[id]]"
      method="POST"
      action="[[action_add]]"
      accept-charset="UTF-8"
      class="form-add"[[add_hidden]]>
    <button type="submit" class="btn btn-xs btn-success btn-playlist-panel"><i class="fa fa-btn fa-plus"></i></button>
    {{ csrf_field() }}
    {{ method_field('PUT') }}
</form>

{{-- Remove --}}
<form data-id="[[id]]"
      method="POST"
      action="[[action_remove]]"
      accept-charset="UTF-8"
      class="form-remove"[[remove_hidden]]>
    <button type="submit" class="btn btn-xs btn-warning btn-playlist-panel"><i class="fa fa-btn fa-minus"></i></button>
    {{ csrf_field() }}
    {{ method_field('DELETE') }}
</form>