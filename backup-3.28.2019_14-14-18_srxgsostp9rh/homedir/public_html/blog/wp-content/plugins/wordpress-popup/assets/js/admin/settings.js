(function ($, doc){
	"use strict";
	if( pagenow !== 'hustle_page_hustle_settings' ) return;

	// E_News is not used anymore here. It can be removed. 
	// Services doesn't seem to be doing anything either.
	var //E_News = Hustle.get("Settings.E_News"),
		Modules_Activity = Hustle.get("Settings.Modules_Activity"),
		Mail_Settings = Hustle.get( 'Settings.Mail_Settings' ),
		Unsubscribe_Settings = Hustle.get( 'Settings.Unsubscribe_Settings' );
		//Services = Hustle.get("Settings.Services");

//	var e_new = new E_News();
	var m_activity = new Modules_Activity(),
		mail = new Mail_Settings(),
		unsubscribe = new Unsubscribe_Settings();
	//var service = new Services();

	// Accordion functionality.
	$(".wpmudev-box .wpmudev-box-head").on('click', function(e) {
		var $this = $(e.target),
			$body = $this.closest('.wpmudev-box').children(".wpmudev-box-body"),
			$head = $this.closest('.wpmudev-box').children(".wpmudev-box-head")
		;
			
		$body.slideToggle( 'fast', function(){
			$head.toggleClass('wpmudev-collapsed');
			$body.toggleClass('wpmudev-hidden');
		} );
	});

	$( "#wpmudev-settings-widget-unsubscribe .toggle-checkbox" ).on( 'change', function(e) {
		var $this = $(e.target),
			$box = $this.closest('.wpmudev-switch-labeled').next('.wpmudev-box-gray'),
			$form = $this.closest('form'),
			form_id = $form.attr( 'id' ),
			action = 'wpmudev-settings-unsubscribe-messages' === form_id ? 'hustle_toggle_unsubscribe_messages_settings' : 'hustle_toggle_unsubscribe_email_settings' ;

		if ( $this.prop('checked') ) {
			$box.removeClass( 'wpmudev-hidden' );
		} else {
			$box.addClass( 'wpmudev-hidden' );
		}

		$.ajax( {
			url: ajaxurl,
			type: "POST",
			data:  {
				action: action,
				enabled: $this.prop('checked'),
				_ajax_nonce: $form.data('nonce')
			},
			success: function(){
				
			}

		});


	});

}(jQuery, document));
