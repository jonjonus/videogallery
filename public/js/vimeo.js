$(document).ready(function() {
    $(".vimeo-load").on("click", youtubeUpdate);
});

function youtubeUpdate() {
    var form       = $(this).parent('form');
    var url        = form.attr('action');
    var CSRF_TOKEN = form.find('input[name="_token"]').val();
    var METHOD     = form.find('input[name="_method"]').val();
    var button     = $(this);

    button.button('loading');

    $.ajax({
        method: "GET"
        ,url: url
        ,data: { _token: CSRF_TOKEN, _method: METHOD }
    })
        .done(function( response ) {
            if (response.hasOwnProperty('result')){
                if (response.result == 'ok'){
                    var tbl_body = document.createElement("tbody");
                    var odd_even = false;
                    $.each(JSON.parse(response.list), function() {
                        $("#videos").prepend('<li>'+this.video.position
                            +' - '+this.video.produced_at
                            +' - '+this.video.title.substring(0,30)
                            +' - '+this.video.thumbnail
                            + (this.new ? ' <span style="color:blue;">New!</span>':'')+'</li>');
                    })
                    $("#total").html(response.total);
                    $("#page").html(response.page_num);
					// $("#videos").prepend("<li>"+response.count+" - "+response.page+"</li>");
                } else if (response.result == 'job') {
                    alert('started')

                } else if (response.result == 'authorize_access') {
                    window.location.href = response.status;
                }

            }
        })
        .fail(function( jqXHR, textStatus, errorThrown ) {
            console.log( errorThrown );
        })
        .always(function(){
            button.button('reset');
        });
    return false; //e.preventDefault and e.stopPropagation
}