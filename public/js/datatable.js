// $('body').on('click', 'a.disabled', function(event) {
//     event.preventDefault();
// });

var datatable;
var videosSelected;

var column_ordering_start = 3;
var fix_columns = 3;

$(document).ready(function() {
	//bind function to add and remove videos in the playlist
	$("#row-playlist").on("click", ".btn-playlist-panel", playlistPanelToggle);
	//bind function to create, save and empty the playlist
	$("#row-playlist").on("click", ".btn-playlist-panel-control", playlistPanelToggle);
	//bind function to edit details
	$("#row-playlist").on("click", ".btn-playlist-panel-control-details", playlistPanelDetails);

	//bind function to pop up bigger image
	$("#row-playlist").on("mouseenter", ".myThumbnail", imageOverlayShow);
	$("#row-playlist").on("mouseleave", ".myThumbnail", imageOverlayHide);

    //bind function to play videos
    $("#datatable").on("click", ".myThumbnail", function () {
		var id = datatable.row( $(this).parent().get(0) ).data().id;
        playVideo(id);
	});

    // only let save the playlist if it's got a title
    $('#playlist-title').on('input',function () {
        var submit = $(this.form).find(':submit');
        if ($(this).val()){
            submit.prop("disabled", false);
        } else {
            submit.prop("disabled", true);
        }
    });

    //bind delete function
    $("#datatable").on("submit",".form-video-delete", deleteVideo);
    // Activate an inline edit on click of a table cell
    $('#datatable').on( 'click', 'tbody td:not(:first-child, .no-editor)', function (e) {
        console.log("Column Index: "+$(this).index());
        if ( $(this).hasClass("bubble-editor") ) {
            editor.bubble( this, {
                title: 'Enter values',
                submit: 'all',
                submitOnBlur: true
            });
        } else {
            editor.inline( this, {
                submit: 'all',
                submitOnBlur: true
            });
        }
    } );


	$(".dragable-video-list").on("click", ".myThumbnail", function () {
		var id = $(this).parent().data('id');
        playVideo(id);
	});

	//create datatable editor
	var editor_tag_columns = [];
    $.each(tagTypes, function (index,tagtype) {
        editor_tag_columns.push( {
            label: tagtype.name,
            name: "tags_"+tagtype.id+"[].id",
            type: "select2",
            opts: {
                "multiple":    true,
                "tags":        true,
                "allowClear":  true,
                "placeholder": {
                    "id": "",
                    "placeholder": "Leave blank to ..."
                },
                "tokenSeparators": [',', ' ']
            }
        });
    });

    var editor_columns = [
        {
            label: "Thumbnail",
            name: "thumbnail"
        },
        {
            label: "Title",
            name: "title"
        },
        {
            label: "Dur",
            name: "duration"
        },
        {
            label: "Description",
            name: "description"
        },
        {
            label: "Produced",
            name: "produced_at",
        },
        {
            label: "Client",
            name: "client.id",
            type: "select2",
            opts: {
                "multiple": false,
                "tags": true,
                "allowClear" : false,
            },
            placeholderDisabled: false,
            placeholder: "Select...",
            placeholderValue: null,
        },
        {
            label: "name",
            name: "name"
        },
        {
            type: "checkbox",
            label: "New",
            name: "new",
            separator: "|",
            ipOpts:    [
                { label: '', value: 1 }
            ]
        },
        {
            type: "checkbox",
            label: "Ignore",
            name: "ignore",
            separator: "|",
            ipOpts:    [
                { label: '', value: 1 }
            ]
        },
        {
            label: "Meta",
            name: "metatexts[].id",
            type: "select2",
            opts: {
                "multiple": true,
                "tags": true,
                "allowClear": true,
                "placeholder": {
                    "id": "",
                    "placeholder": "Leave blank to ..."
                },
                "tokenSeparators": [',', ' ']
            }
        }
    ];

	editor = new $.fn.dataTable.Editor( {
		// ajax: "/datatables_update",
		table: "#datatable",
        /*ajax: function ( method, url, data, success, error ) {
            // var modifier = editor.modifier();
            // if ( modifier ) {
            //     var data = datatable.row( modifier ).data();
            //     do something with `data`
            // }

            $.ajax( {
                type: 'POST',
                url:  '/datatables_update',
                data: data,
                dataType: "json",
                success: function (json) {
                    success( json );
                },
                error: function( jqXHR, textStatus, errorThrown ) {
                    swal("Oops...Something went wrong!", errorThrown, "error");
                    error( jqXHR, textStatus, errorThrown );
                    editor.close()
                }
            } );
        },*/
        ajax: '/datatables_update',
		idSrc: "id",
		fields: editor_columns.concat(editor_tag_columns),
        formOptions: {
            main: {
                submit: 'all'
            }
        }
	});

	editor.on( 'submitSuccess', function ( e, json, data ) {
		//TODO check when a type is added
		$.each(json.options, function (index,option) {
			editor.field(index).update(option);
		});
	});

    editor.on( 'submitError', function ( e, xhr, err, thrown, data  ) {
        swal("Oops...Something went wrong!", err+"("+thrown+")", "error");
        editor.close()
    } );



	//PREPARE COLUMNS FOR DATATABLE
	var columns = [
		{
			data: null,
			defaultContent: '',
			className: 'select-checkbox',
			orderable: false,
		},
		{
			data: "thumbnail",
			render: function ( data, type, row ) {
				return '<img src="" data-source="'+data+'" class="myThumbnail" width="50px" height="38px"/> ' +
                    '<a href="videos/'+row.id+'/fullscreen" target="_blank"><span class="glyphicon glyphicon-new-window" aria-hidden="true"></span></a> ';
			},
			orderable: false,
			className: "no-editor"
		},
        {
            data: "actions",
            // render: function ( data, type, row ) {
            //     return row['actions'];
            // },
            orderable: false,
            className: "no-editor",
        },
		{   data: "title" },
		{   data: "duration" },
		{
			data: "description",
			render: function ( data, type, row ) {
				return "<div class='ellipsis'>" + data + "</div>";
			}
		},
		{   data: "produced_at",
            // className: "bubble-editor datepicker"
        },
		{
			data: "client",
			editField: "client.id",
			render: "name",
			className: "bubble-editor",
		},
		{ 	data: "name",
            className: "no-editor",
        },
		{ 	data: "new",
			render: function ( data, type, row ) {
				if ( type === 'display' ) {
					return '<input type="checkbox" class="editor-new">';
				}
				return data;
			},
			className: "no-editor dt-body-center",
		},
		{ 	data: "ignore",
			render: function ( data, type, row ) {
				if ( type === 'display' ) {
					return '<input type="checkbox" class="editor-ignore">';
				}
				return data;
			},
			className: "no-editor dt-body-center",
		},
		{
			data: "metatexts",
			editField: "metatexts[].id",
			render: "[, ].name",
			className: "bubble-editor",
		}
	];

	$.each(tagTypes, function (index,tagtype) {
		columns.push({
			data:      "tags_"+tagtype.id,
			editField: "tags_"+tagtype.id+"[].id",
			render:    "[, ].value",
			className: "bubble-editor",
		});
	});

	//add actions column
	columns.push(
		{
			data: "service.name",
			editField: "service.id",
			defaultContent: "",
			className: "no-editor",
		});
	//END - PREPARE COLUMNS FOR DATATABLE

	datatable = $('#datatable').DataTable({
		ajax: '/datatables_load',
		idSrc: "id",
        rowId: "id",
		processing: true,
        deferRender: true,
		order: [[column_ordering_start, 'asc']],
		orderCellsTop: true,
        stateSave: true,
        stateDuration: 0,
		select: {
			style:    'multi',
			selector: 'td:first-child'
		},
		columns: columns,
        scrollX: true,
        fixedColumns: {
            leftColumns: fix_columns
        },
        // preDrawCallback: function ( settings ) {
        //     var api = new $.fn.dataTable.Api( settings );
        //
        //     console.log( api.rows( {page:'current'} ).data() );
        // },
		// drawCallback: function( settings ) {
		// 	console.log("Draw Callback");
		// },
		rowCallback: function ( row, data, index ) {
			// Set the checked state of the checkbox in the table
			$('input.editor-new',    row).prop( 'checked', data.new == 1 );
			$('input.editor-ignore', row).prop( 'checked', data.ignore == 1 );
		},
		initComplete: function(settings, json) {
		    //mark rows that were selected
            $.each(json.selection, function( index, value ) {
                datatable.row('#'+value).select();
            });
            console.log("Proccessing time: "+json.time+" seconds");
		},
		dom: 'lBfrtip',
		buttons: [
			'selectAll',
			'selectNone',
            {
                text: "Select visible",
                action: function ( e, dt ) {
                    dt.rows( { page: 'current' } ).select();
                }
            },
			{extend: 'selectedSingle',
				text: 'Edit',
				action: function ( e, dt, button, config ) {
					// console.log( dt.row( { selected: true } ).data() );
					window.location.href = "/videos/" + dt.row( { selected: true } ).data()['id'] + "/edit";
				}
			},
			{
				extend: 'selected',
				text: 'Bulk Edit',
                className: 'excelButton',
				action: function ( e, dt, button, config ) {
					// iterate row to get the IDs
                    var ids = $.map(dt.rows({ selected: true }).data(), function (item) {
                        return item['id']
                    });
                    // var ids = dt.rows({ selected: true }).data().pluck('id');
                    fncEditBulk(ids);
				}
			},
			{
				text: 'New',
				action: function ( e, dt, node, config ) {
					window.location.href = "/videos/create/"
				}
			},
			{
				extend: 'colvis',
				postfixButtons: [ 'colvisRestore' ]
			},
            {
                extend: 'collection',
                text: 'New',
                autoClose: true,
                buttons: [
                    {
                        text: 'New',
                        action: function ( e, dt, node, config ) {
                            dt.column( pos_new_column ).search(1).draw();
                        }
                    },
                    {
                        text: 'Not New',
                        action: function ( e, dt, node, config ) {
                            dt.column( pos_new_column ).search(0).draw();
                        }
                    },
                    {
                        text: 'All',
                        action: function ( e, dt, node, config ) {
                            dt.column( pos_new_column ).search("").draw();
                        }
                    }
                ]
            },
            {
                extend: 'collection',
                text: 'Ignored',
                autoClose: true,
                buttons: [
                    {
                        text: 'Ignored',
                        action: function ( e, dt, node, config ) {
                            dt.column( pos_ignore_column ).search(1).draw();
                        }
                    },
                    {
                        text: 'Not Ignored',
                        action: function ( e, dt, node, config ) {
                            dt.column( pos_ignore_column ).search(0).draw();
                        }
                    },
                    {
                        text: 'All',
                        action: function ( e, dt, node, config ) {
                            dt.column( pos_ignore_column ).search("").draw();
                        }
                    }
                ]
            },
            {
                extend: 'collection',
                text: 'Selected',
                autoClose: true,
                buttons: [
                    {
                        text: 'Selected',
                        action: function ( e, dt, node, config ) {
                            dt.column( pos_ignore_column ).search(1).draw();
                        }
                    },
                    {
                        text: 'Not Selected',
                        action: function ( e, dt, node, config ) {
                            dt.column( pos_ignore_column ).search(0).draw();
                        }
                    },
                    {
                        text: 'All',
                        action: function ( e, dt, node, config ) {
                            dt.column( pos_ignore_column ).search("").draw();
                        }
                    }
                ]
            }

        ],
		columnDefs: [
			{
				targets: -1,
				visible: false
			}
		],
		language: {
			buttons: {
				selectAll: "Select all",
				selectNone: "Select none",
			}
		}
	});

    //keep count of selected rows
    datatable.on( 'select', function ( e, dt, type, indexes ) {
        countVideos(dt, type);
    } );
    datatable.on( 'deselect', function ( e, dt, type, indexes ) {
        countVideos(dt, type);
    } );

    //load images when changing pages instead of table init
    $('#datatable').on( 'draw.dt', function () {
        console.log( 'Redraw occurred at: '+new Date().getTime() );
        $(".myThumbnail:visible").each(function () {
            $(this).attr('src',$(this).data('source'));
        });

    } );

    activate_columns_search();
	configure_columns_editor();

	/*
	 * DRAGABLE ELEMENTS
	 */
	var drake = dragula({
		isContainer: function (el) {
			return el.classList.contains('dragula-container');
		}
	}).on('drop', function(el, target, source, sibling){
		var parentEl = $(el).parent();
		var order = [];
		$(".dragable-video-list").find(".dragable-video-item" ).each(function( index ) {
			console.log("id: :"+$(this).attr('id')+" index: "+$(this).index() );
			// order.push({id: $(this).attr('id'), index: $(this).index()});
			order.push($(this).attr('id'));
		});
		playlistUpdateOrder(order);
		// var droppedElIndex = $(el).index();
		// var droppedElId = $(el).attr('id');
		// var siblingElId = $(sibling).attr('id');
	});

	/*** FUNCTIONS BINDING ***/



});

function add_row_to_selection(id) {
	$.ajax({
		method: "POST"
		,url: '/videos/'+id+'/selection_one'
		,data: { _token: CSRF_TOKEN, _method: 'PUT' }
	})
		.done(function( response ) {
			console.log( response.result );
		})
		.fail(function( jqXHR, textStatus, errorThrown ) {
			alert("There was an error adding the video to the selection.")
			console.log( errorThrown );
		});
}

function  fncEditBulk(ids) {
    $.ajax({
        method: "POST"
        ,url: '/videos_selection'
        ,data: { _token: CSRF_TOKEN, _method: 'PUT', ids: ids }
    })
        .done(function( response ) {
            console.log( response.result );
            window.location.href = "/videos_edit_bulk";
        })
        .fail(function( jqXHR, textStatus, errorThrown ) {
            swal("Oops...Something went wrong!", errorThrown, "error");
        });
}

function playlistPanelToggle(e) {
	var form       = $(this).parent('form');
	var url        = form.attr('action');
	var CSRF_TOKEN = form.find('input[name="_token"]').val();
	var METHOD     = form.find('input[name="_method"]').val();

	var id = form.data("id");
	if (id){
		//toggle = hide/display
		$(".form-add[data-id="+id+"]").toggle();
		$(".form-remove[data-id="+id+"]").toggle();
	}
	$('.btn-playlist-panel').prop('disabled', true);

	//build form data
	var fd = new FormData();
	var data = form.serializeArray();
	$.each(data,function(key,input){
		fd.append(input.name,input.value);
	});
	// fd.append('ids[]',1);
	// fd.append('ids[]',2);


	//if it is save
	if (form.hasClass('form-with-video-list')){
		$(".dragable-video-item").each(function() {
			fd.append('ids[]',this.id);
		});
	}
	//
	// else {
	// 	//if we're add/removing videos
	// 	var data = form.serializeArray();
	// 	$.each(data,function(key,input){
	// 		fd.append(input.name,input.value);
	// 	});
	// }

	$.ajax({
		method: "POST"
		,url: url
		,data: fd
		,processData: false
		,contentType: false
	})
		.done(function( response ) {
			if (!response.hasOwnProperty('result')){
                swal("Oops...Something went wrong!", "Error talking with the server.", "error");

			} else if(response.result == 'error'){
                swal("Oops...Something went wrong!", response.message, "error");
			}
			console.log( id+" - Result: "+response.result+" - Action: "+response.action );

			switch(response.action) {
				case 'removeall':
					datatable.ajax.reload(reloadDatatable(),false);
					//toggle = hide/display
					$(".form-add").show();
					$(".form-remove").hide();
					break;
				case 'create':
					datatable.ajax.reload(reloadDatatable(),false);
					showPlaylistInfo(response.content);
					break;
			}
			reloadPanel(response.panel);
			$('.btn-playlist-panel').prop('disabled', false);
		})
		.fail(function( jqXHR, textStatus, errorThrown ) {
			if (textStatus == 'error'){
				var errors = $.parseJSON(jqXHR.responseText);
				var error_message = '';
				$.each(errors, function(key,value){
					error_message += 'The field '+key+' has the following errors:\n';
					$.each(value, function (i,error) {
						error_message += ' - '+i+'.'+error+'\n';
					})
				});
				alert(error_message);
			}
		})
		.always(function () {
			//must re bind the elements
			$('#playlist-title').on('input',function () {
				var submit = $(this.form).find(':submit');
				if ($(this).val()){
					submit.prop("disabled", false);
				} else {
					submit.prop("disabled", true);
				}
			});
		});
	return false; //e.preventDefault and e.stopPropagation
}

function playlistPanelDetails(e) {
	showPlaylistInfo(response.content);
}

function playlistUpdateOrder(order) {
	$.ajax({
		method: "POST"
		,url: 'playlist_updateOrder'
		,data: { _token: CSRF_TOKEN, _method: 'POST', order: order}
	})
		.done(function( response ) {
			console.log( response.result );
		})
		.fail(function( jqXHR, textStatus, errorThrown ) {
			alert("There was an error saving the videos order.")
			console.log( errorThrown );
		});
}

function reloadDatatable() {
	console.log("Reloading datatble"+moment().format("SSS"))
}

function reloadPanel($html) {
	console.log("Reloading panel"+moment().format("SSS"));
	$('#panel-container').html($html);
}

function showPlaylistInfo(content) {
	$('.modal-content','#playlist-modal').html(content);
	$('.modal-dialog').addClass('modal-lg');
	$('#playlist-modal').modal('show');
}

function activate_columns_search() {
	datatable.columns().every( function (index) {
        $('#datatable_wrapper .dataTables_scrollHeadInner thead tr:eq(1) td:eq(' + index + ') input').on('keyup change', function () {
			datatable.column($(this).parent().index() + ':visible')
				.search(this.value)
				.draw();
		});
	});
}

/*
* make checkbox columns (new and ignore) to submit a boolean
*/
function configure_columns_editor() {
	$('#datatable')
		.on( 'change', 'input.editor-new', function () {
			editor
				.edit( $(this).closest('tr'), false )
				.set( 'new', $(this).prop( 'checked' ) ? 1 : 0 )
				.submit();
		})
		.on( 'change', 'input.editor-ignore', function () {
			editor
				.edit( $(this).closest('tr'), false )
				.set( 'ignore', $(this).prop( 'checked' ) ? 1 : 0 )
				.submit();
		});
}

function playVideo(id) {
	console.log('Play video '+id);
    $(".img-overlay").hide();
    $.ajax({ method: "GET", url: '/videos/'+id+'/embed'})
        .done(function( response ) {
            if (response.result == 'ok') {
            	//set title
            	if (response.title){
                    $('.modal-title', '#playlist-modal').html(response.title);
                } else {
                    $('.modal-title', '#playlist-modal').remove();
                }
                //set buttons
                if (response.buttons){
                    $('.modal-footer', '#playlist-modal').html(response.buttons);
                } else {
                    $('.modal-footer', '#playlist-modal').remove();
                }
                //set content
                $('.modal-body', '#playlist-modal').html(response.embed);
                $('#playlist-modal').modal('show');
            } else {
                alert(response.errors);
            }
        })
        .fail(function( jqXHR, textStatus, errorThrown ) {
            if (textStatus == 'error'){
                alert(errorThrown);
            }
        })
}

function deleteVideo(e){
    e.preventDefault();
    var form = this;

    swal({
            title: "Are you sure?",
            text: "this video will be marked as deleted!",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Yes, delete it!",
            closeOnConfirm: false
        },
        function(){
            form.submit();
        });
}

function countVideos(dt, type) {
    if ( type === 'row' ) {
        // count selected rows
        $('#videos-count').html(datatable.rows( { selected: true } ).count());
    };
}

function imageOverlayShow(e) {
    $(".img-overlay").children('img').attr('src', $(this).attr('src'));
    $(".img-overlay").show();
}

function imageOverlayHide(e) {
	$(".img-overlay").hide();
}