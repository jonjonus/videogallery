<!-- Modal -->
<div class="modal fade" id="playlist-modal" tabindex="-1" role="dialog" aria-labelledby="playlist-modalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Modal title</h4>
            </div>
            <div class="modal-body">
                ...
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Save changes</button>
            </div>
        </div>
    </div>
</div>

<script>
    $("#playlist-modal").on('hidden.bs.modal', function (e) {
        $('.modal-dialog').removeClass('modal-lg');
        $('.modal-dialog').removeClass('modal-sm');
        $("#playlist-modal iframe").attr("src", $("#playlist-modal iframe").attr("src"));
    });
</script>