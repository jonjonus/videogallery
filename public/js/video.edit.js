$(document).ready(function() {
    $('.select2').select2({
        placeholder: 'Choose a Metatext...',
        tags: true,
        tokenSeparators: [',', ' '],
        data: optionsMetatexts
    });

    $('#video-produced_at').datepicker({
        minViewMode: 1,
        todayBtn: true
    });
});