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

    $('#myTabs a').click(function (e) {
        e.preventDefault()
        $(this).tab('show')
    })

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
		table: "#datatable",
        template: '#customForm',
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
		{ data: null, defaultContent: '', className: 'select-checkbox', orderable: false, },
		{ data: "thumbnail", orderable: false, className: "no-editor",
			render: function ( data, type, row ) {
				return '<img src="" data-source="'+data+'" class="myThumbnail" width="50px" height="38px"/> ' +
                    '<a href="videos/'+row.id+'/fullscreen" target="_blank"><span class="glyphicon glyphicon-new-window" aria-hidden="true"></span></a> ';
			}, },
        { data: "actions", orderable: false, className: "no-editor", },
		{ data: "title" },
		{ data: "duration", className: "no-editor", },
		{ data: "description",
			render: function ( data, type, row ) {
				return "<div class='ellipsis'>" + data + "</div>";
			},},
		{ data: "produced_at", },
		{ data: "client", className: "bubble-editor", editField: "client.id", render: "name", },
		{ data: "name", className: "no-editor", },
		{ data: "new", className: "no-editor dt-body-center",
			render: function ( data, type, row ) {
				if ( type === 'display' ) {
					return '<input type="checkbox" class="editor-new">';
				}
				return data;
			},},
		{ data: "ignore", className: "no-editor dt-body-center",
			render: function ( data, type, row ) {
				if ( type === 'display' ) {
					return '<input type="checkbox" class="editor-ignore">';
				}
				return data;
			},},
		{ data: "metatexts", editField: "metatexts[].id", render: "[, ].name", className: "bubble-editor", }
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
        scrollY: '50vh',
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
                    dt.rows().deselect();
                    dt.rows( { page: 'current' } ).select();
                }
            },
            {
                text: "Select filtered",
                action: function ( e, dt ) {
                    dt.rows().deselect();
                    dt.rows( {order:'index', search:'applied'} ).select();
                }
            },
            { extend: "edit",   editor: editor },
            {
				text: 'New',
				action: function ( e, dt, node, config ) {
					window.location.href = "/videos/create/"
				}
			},
			{ extend: 'colvis', postfixButtons: [ 'colvisRestore' ]
			},
            { extend: 'collection', text: 'Show New', autoClose: true,
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
                extend: 'collection', text: 'Show Ignored', autoClose: true,
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
                extend: 'collection', text: 'Show Selected', autoClose: true,
                buttons: [
                    {
                        text: 'Selected',
                        action: function ( e, dt, node, config ) {
                            $.fn.dataTable.ext.search.push(
                                function (settings, data, dataIndex){
                                    return ($(datatable.row(dataIndex).node()).hasClass('selected')) ? true : false;
                                }
                            );

                            datatable.draw();

                            $.fn.dataTable.ext.search.pop();
                        }
                    },
                    // {
                    //     text: 'Not Selected',
                    //     action: function ( e, dt, node, config ) {
                    //         $.fn.dataTable.ext.search.push(
                    //             function (settings, data, dataIndex){
                    //                 return ($(datatable.row(dataIndex).node()).hasClass('selected')) ? false : true;
                    //             }
                    //         );
                    //
                    //         datatable.draw();
                    //
                    //         $.fn.dataTable.ext.search.pop();
                    //     }
                    // },
                    {
                        text: 'All',
                        action: function ( e, dt, node, config ) {
                            datatable.draw();
                        }
                    }
                ]
            },
            {
                text: 'Clear',
                action: function ( e, dt, node, config ) {
                    datatable.columns().every( function (index) {
                        $('#datatable_wrapper .dataTables_scrollHeadInner thead tr:eq(1) td:eq(' + index + ') input').val('');
                    });
                    datatable.state.clear();
                    datatable.draw();
                }
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
		    handleRedirect(response);
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
		    if (jqXHR.status == 401)
                window.location.href = '/login';
			else if (textStatus == 'error'){
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
		    handleRedirect(response);
			console.log( response.result );
		})
		.fail(function( jqXHR, textStatus, errorThrown ) {
			console.log( errorThrown );
            if (jqXHR.status == 401)
                window.location.href = '/login';
            else
                alert("There was an error saving the videos order.")
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
    var state = datatable.state.loaded();

	datatable.columns().every( function (index) {
        var input = $('#datatable_wrapper .dataTables_scrollHeadInner thead tr:eq(1) td:eq(' + index + ') input');
        input.on('keyup change', function () {
			datatable.column($(this).parent().index() + ':visible')
				.search(this.value)
				.draw();
		});

        // restore saved filters
        if ( state ) {
            var colSearch = state.columns[index].search;

            if ( colSearch.search ) {
                input.val( colSearch.search );
            }
        }
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
            handleRedirect(response);
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
            console.log( errorThrown );
            if (jqXHR.status == 401)
                window.location.href = '/login';
            else if (textStatus == 'error'){
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

function imageOverlayShow(e) {
    $(".img-overlay").children('img').attr('src', $(this).attr('src'));
    $(".img-overlay").show();
}

function imageOverlayHide(e) {
	$(".img-overlay").hide();
}

function handleRedirect(data) {
    if (data.redirect) {
        // data.redirect contains the string URL to redirect to
        window.location.href = data.redirect;
    }
}