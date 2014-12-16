/**
 * Plumrocket Inc.
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the End-user License Agreement
 * that is available through the world-wide-web at this URL:
 * http://wiki.plumrocket.net/wiki/EULA
 * If you are unable to obtain it through the world-wide-web, please
 * send an email to support@plumrocket.com so we can send you a copy immediately.
 *
 * @package     Plumrocket_SocialLogin
 * @copyright   Copyright (c) 2014 Plumrocket Inc. (http://www.plumrocket.com)
 * @license     http://wiki.plumrocket.net/wiki/EULA  End-user License Agreement
 */

pjQuery_1_10_2(document).ready(function() {

	// Set Required fields.
	// pjQuery_1_10_2('').addClass('validate-alphanum');

	// Redirect to.
	pjQuery_1_10_2('#pslogin_general_redirect_for_login, #pslogin_general_redirect_for_register').on('change', function() {
		var $list = pjQuery_1_10_2(this);
		if($list.val() == '__custom__') {
			pjQuery_1_10_2('#row_'+ $list.attr('id') +'_link').show();
		}else{
			pjQuery_1_10_2('#row_'+ $list.attr('id') +'_link').hide();
		}
	})
	.find('option[value=__none__]').prop('disabled', true)
	.change();
	
	// Sortable.
	pjQuery_1_10_2('ul#sortable-visible, ul#sortable-hidden').sortable({
      	connectWith: "ul",
      	receive: function(event, ui) {
      		ui.item.attr('id', ui.item.attr('id').replace(ui.sender.data('list'), pjQuery_1_10_2(this).data('list')));
      	},
      	update: function(event, ui) {
      		var sortable = [
      			pjQuery_1_10_2('#sortable-visible').sortable('serialize'),
      			pjQuery_1_10_2('#sortable-hidden').sortable('serialize')
      		];

      		pjQuery_1_10_2('#pslogin_general_sortable').val( sortable.join('&') );
      	},
      	stop: function(event, ui) {
      		if(this.id == 'sortable-visible' && pjQuery_1_10_2('#'+ this.id +' li').length < 1) {
      			alert('Sorry, "Visible Buttons" list can not be empty');
      			// return false;
      			pjQuery_1_10_2(this).sortable('cancel');
      		}
      	}
    })
    .disableSelection();
    

	if(pjQuery_1_10_2('#pslogin_general_sortable_drag_and_drop').css('display') != 'none') {
		if(pjQuery_1_10_2('#pslogin_general_sortable_inherit').length) {
			pjQuery_1_10_2('#pslogin_general_sortable_inherit').on('change', function() {
				var $sortLists = pjQuery_1_10_2('ul#sortable-visible, ul#sortable-hidden');
				if(pjQuery_1_10_2(this).is(':checked')) {
					$sortLists.sortable({ disabled: true });
				}else{
					$sortLists.sortable({ disabled: false });
				}
			}).change();
		}
	}else{
		pjQuery_1_10_2('#row_pslogin_general_sortable').hide();
	}

    /*pjQuery_1_10_2('select').on('change', function() {
    	var $list = pjQuery_1_10_2(this);
    	pjQuery_1_10_2('ul#sortable-visible, ul#sortable-hidden').find('li[data-enable='+ $list.attr('id') +']').toggle( $list.val() );
    });*/

    // Share Url.
    pjQuery_1_10_2('#pslogin_share_page').on('change', function() {
		var $list = pjQuery_1_10_2(this);
		if($list.val() == '__custom__') {
			pjQuery_1_10_2('#row_'+ $list.attr('id') +'_link').show();
		}else{
			pjQuery_1_10_2('#row_'+ $list.attr('id') +'_link').hide();
		}
	})
	.find('option[value=__invitationsoff__], option[value=__none__]').prop('disabled', true)
	.change();

	// Alert "Not installed".
	pjQuery_1_10_2('.pslogin-notinstalled').parents('fieldset.config').each(function() {
		var $section = pjQuery_1_10_2('#'+ this.id +'-head').parents('div.entry-edit-head');
		$section.addClass('pslogin-notinstalled-section');
		$section.find('a').append('<span class="pslogin-notinstalled-title">(Not installed)</span>');
	});

});