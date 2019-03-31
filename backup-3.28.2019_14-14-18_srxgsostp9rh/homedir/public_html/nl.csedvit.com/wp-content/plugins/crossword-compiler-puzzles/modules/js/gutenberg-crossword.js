( function( blocks, components, i18n, element ) {
	var el = element.createElement;
	var registerBlockType = wp.blocks.registerBlockType;
	var RichText = wp.blocks.RichText;
	var BlockControls = wp.blocks.BlockControls;
	var AlignmentToolbar = wp.blocks.AlignmentToolbar;
	var MediaUpload = wp.blocks.MediaUpload;
	var InspectorControls = wp.blocks.InspectorControls;
	var TextControl = wp.components.TextControl;
	var Fragment = wp.element.Fragment;
	var added_crossword = false;
  	
  	registerBlockType( 'crossword/crossword-block', { // The name of our block. Must be a string with prefix. Example: my-plugin/my-custom-block.
		title: 'Crossword', // The title of our block.
		icon: '', // Dashicon icon for our block. Custom icons can be added using inline SVGs.
		category: 'common', // The category of the block.
		edit: function(attributes) {
			if( attributes.isSelected ) {
				$.ajax({
		            url: ajax_object.ajax_url,
		            type: 'POST',
		            dataType: 'HTML',
		            data: {
		                action: 'ccpuz_get_crossword_mce_from',
		                post_id: ccpuz_post_id
		            }
		        }).done(function(response){
		            var e = $(response);
		            vex.dialog.open({
		            	message: '',
		            	input: [
		            		e.html()
		            	].join(''),
		            	afterOpen: function () {
		            		var e = $('.vex-dialog-input');
		            		e.find('#crossword_method').on('change', function(){
				                if( $(this).val() == 'url' ){
				                    e.find('.ccpuz_file_class').hide();
				                    e.find('.ccpuz_url_class').show();
				                }
				                if( $(this).val() == 'local' ){
				                    e.find('.ccpuz_url_class').hide();
				                    e.find('.ccpuz_file_class').show();
				                }
				            });
				            e.find('#crossword_method').change();
		            	},
		            	onSubmit: function(event) {
		            		var dialog = this;
		            		event.preventDefault();
		            		var e = $('.vex-dialog-input');
		            		$('.vex-dialog-button').attr('disabled', 'disabled');

		            		var formData = new FormData();
			                formData.append('crossword_method', e.find('#crossword_method').val());
			                formData.append('action', 'ccpuz_save_crossword_mce_from');
			                formData.append('post_id', ccpuz_post_id);
			                if( e.find('#crossword_method').val() == 'url' ) {
			                    formData.append( 'ccpuz_url_upload_field', e.find('#ccpuz_url_upload_field').val() )
			                } else if ( e.find('#crossword_method').val() == 'local' ) {
			                    formData.append('ccpuz_html_file', e.find('#ccpuz_html_file')[0].files[0]); 
			                    formData.append('ccpuz_js_file', e.find('#ccpuz_js_file')[0].files[0]); 
			                }
			                $.ajax({
			                    url: ccpuz_wpse72394_button_ajax_url,
			                    data: formData,
			                    type: 'POST',
			                    dataType: 'html',
			                    contentType: false,
			                    processData: false
			                }).done(function(response){
			                    if( response == 1 ) {
			                    	added_crossword = true;
			                    } else {
			                        alert(response);
			                    }
			                    dialog.close();
			                });
			                return false;
		            	}
		            });
		        });
		    }
	        return el( 'p', { }, '[crossword]' );
	    },

	    save: function() {
	        return el( 'p', { }, '[crossword]' );
	    },
	} );
 } )(
	window.wp.blocks,
	window.wp.components,
	window.wp.i18n,
	window.wp.element,
);