$(document).ready(function() {
    $('.list-group-item').click(play);
});

function play() {
    //make all inactive
    $(this).parent().children().removeClass('active');
    //make this active
    $(this).addClass('active');

    $("iframe").replaceWith($(this).data('embed'));
    $('#video_title').html($('#'+$(this).attr('id')+'_title').text());
    $('#video_description').html($('#'+$(this).attr('id')+'_description').html());
    return false;
}