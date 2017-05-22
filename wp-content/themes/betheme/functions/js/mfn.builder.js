/* ---------------------------------------------------------------------------
 * UI Sortable init for items
 * --------------------------------------------------------------------------- */
function mfnSortableInit(item){
	item.find('.mfn-sortable').sortable({ 
		connectWith				: '.mfn-sortable',
		cursor					: 'move',
		forcePlaceholderSize	: true, 
		placeholder				: 'mfn-placeholder',
		items					: '.mfn-item',
		opacity					: 0.9,
		receive					: mfnSortableReceive
	});
	return item;
}


/* ---------------------------------------------------------------------------
 * UI Sortable receive callback
 * --------------------------------------------------------------------------- */
function mfnSortableReceive(event, ui){
	var targetSectionID = jQuery(this).siblings('.mfn-row-id').val(); 
	ui.item.find('.mfn-item-parent').val(targetSectionID);
}


/* ---------------------------------------------------------------------------
 * Muffin Builder 2.0
 * --------------------------------------------------------------------------- */
function mfnBuilder(){
		
	var desktop = jQuery('#mfn-desk');
	if( ! desktop.length ) return false;	// Exit if Builder HTML does not exist
	
	var sectionID = jQuery('#mfn-row-id');
	
	
	// sizes & classes ========================================
	
	
	// available items ----------------------------------------
	var items = {
		'accordion'			: [ '1/4', '1/3', '1/2', '2/3', '3/4', '1/1' ],
		'article_box'		: [ '1/3', '1/2' ],
		'blockquote'		: [ '1/6', '1/5', '1/4', '1/3', '1/2', '2/3', '3/4', '1/1' ],
		'blog'				: [ '1/1' ],
		'blog_news'			: [ '1/4', '1/3', '1/2' ],
		'blog_slider'		: [ '1/4', '1/3', '1/2', '2/3', '3/4', '1/1' ],
		'call_to_action'	: [ '1/1' ],
		'chart'				: [ '1/4', '1/3', '1/2' ],
		'clients'			: [ '1/1' ],
		'clients_slider'	: [ '1/1' ],
		'code'				: [ '1/6', '1/5', '1/4', '1/3', '1/2', '2/3', '3/4', '1/1' ],
		'column'			: [ '1/6', '1/5', '1/4', '1/3', '1/2', '2/3', '3/4', '1/1' ],
		'contact_box'		: [ '1/5', '1/4', '1/3', '1/2', '2/3', '3/4', '1/1' ],
		'content'			: [ '1/6', '1/5', '1/4', '1/3', '1/2', '2/3', '3/4', '1/1' ],
		'countdown'			: [ '1/1' ],
		'counter'			: [ '1/6', '1/5', '1/4', '1/3', '1/2' ],	
		'divider'			: [ '1/1' ],
		'fancy_divider'		: [ '1/1' ],
		'fancy_heading'		: [ '1/4', '1/3', '1/2', '2/3', '3/4', '1/1' ],
		'feature_list'		: [ '1/1' ],
		'faq'				: [ '1/4', '1/3', '1/2', '2/3', '3/4', '1/1' ],
		'flat_box'			: [ '1/4', '1/3', '1/2' ],
		'hover_box'			: [ '1/6', '1/5', '1/4', '1/3', '1/2', '2/3', '3/4', '1/1' ],
		'hover_color'		: [ '1/6', '1/5', '1/4', '1/3', '1/2', '2/3', '3/4', '1/1' ],
		'how_it_works'		: [ '1/4', '1/3' ],
		'icon_box'			: [ '1/5', '1/4', '1/3', '1/2' ],
		'image'				: [ '1/6', '1/5', '1/4', '1/3', '1/2', '2/3', '3/4', '1/1' ],
		'info_box'			: [ '1/5', '1/4', '1/3', '1/2', '2/3', '3/4', '1/1' ],
		'list'				: [ '1/6', '1/5', '1/4', '1/3', '1/2' ],
		'map'				: [ '1/6', '1/5', '1/4', '1/3', '1/2', '2/3', '3/4', '1/1' ],
		'offer'				: [ '1/1' ],
		'offer_thumb'		: [ '1/1' ],
		'opening_hours'		: [ '1/5', '1/4', '1/3', '1/2', '2/3', '3/4', '1/1' ],
		'our_team'			: [ '1/6', '1/5', '1/4', '1/3', '1/2' ],
		'our_team_list'		: [ '1/1' ],
		'photo_box'			: [ '1/6', '1/5', '1/4', '1/3', '1/2' ],
		'placeholder'		: [ '1/6', '1/5', '1/4', '1/3', '1/2', '2/3', '3/4', '1/1' ],
		'portfolio'			: [ '1/1' ],
		'portfolio_grid'	: [ '1/4', '1/3', '1/2', '2/3', '3/4', '1/1' ],
		'portfolio_photo'	: [ '1/1' ],
		'portfolio_slider'	: [ '1/1' ],
		'pricing_item'		: [ '1/6', '1/5', '1/4', '1/3', '1/2', '2/3', '3/4', '1/1' ],
		'progress_bars'		: [ '1/6', '1/5', '1/4', '1/3', '1/2', '2/3', '3/4', '1/1' ],
		'promo_box'			: [ '1/2' ],
		'quick_fact'		: [ '1/6', '1/5', '1/4', '1/3', '1/2', '2/3', '3/4', '1/1' ],
		'shop_slider'		: [ '1/4', '1/3', '1/2', '2/3', '3/4', '1/1' ],
		'sidebar_widget'	: [ '1/4', '1/3' ],
		'slider'			: [ '1/2', '2/3', '3/4', '1/1' ],
		'slider_plugin'		: [ '1/4', '1/3', '1/2', '2/3', '3/4', '1/1' ],
		'sliding_box'		: [ '1/6', '1/5', '1/4', '1/3', '1/2' ],
		'story_box'			: [ '1/4', '1/3', '1/2' ],
		'tabs'				: [ '1/4', '1/3', '1/2', '2/3', '3/4', '1/1' ],
		'testimonials'		: [ '1/4', '1/3', '1/2', '2/3', '3/4', '1/1' ],
		'testimonials_list'	: [ '1/1' ],
		'trailer_box'		: [ '1/6', '1/5', '1/4', '1/3', '1/2' ],
		'timeline'			: [ '1/1' ],
		'video'				: [ '1/6', '1/5', '1/4', '1/3', '1/2', '2/3', '3/4', '1/1' ],
		'visual'			: [ '1/6', '1/5', '1/4', '1/3', '1/2', '2/3', '3/4', '1/1' ],
		'zoom_box'			: [ '1/4', '1/3', '1/2' ]
	};	
	
	
	// available classes ------------------------------------------
	var classes = {
		'1/6' : 'mfn-item-1-6',
		'1/5' : 'mfn-item-1-5',
		'1/4' : 'mfn-item-1-4',
		'1/3' : 'mfn-item-1-3',
		'1/2' : 'mfn-item-1-2',
		'2/3' : 'mfn-item-2-3',
		'3/4' : 'mfn-item-3-4',
		'1/1' : 'mfn-item-1-1'
	};
	
	
	// available textarea shortcodes ------------------------------
	var shortcodes = {
		'alert' 			: '[alert style="warning"]Insert your content here[/alert]',
		'blockquote' 		: '[blockquote author="" link="" target="_blank"]Insert your content here[/blockquote]',
		'button' 			: '[button title="" icon="" icon_position="" link="" target="_blank" color="" font_color="" large="0" class="" download="" onclick=""]',
		'code' 				: '[code]Insert your content here[/code]',
		'content_link'		: '[content_link title="" icon="icon-lamp" link="" target="_blank" class="" download=""]',
		'dropcap'			: '[dropcap background="" color="" circle="0"]I[/dropcap]nsert your content here',
		'fancy_link'		: '[fancy_link title="" link="" target="" style="1" class="" download=""]',
		'google_font'		: '[google_font font="Open Sans" size="25" weight="400" italic="0" color="#626262" subset=""]Insert your content here[/google_font]',
		'highlight'			: '[highlight background="" color=""]Insert your content here[/highlight]',
		'hr'				: '[hr height="30" style="default" line="default" themecolor="1"]',
		'icon'				: '[icon type="icon-lamp"]',
		'icon_bar'			: '[icon_bar icon="icon-lamp" link="" target="_blank" size="" social=""]',
		'icon_block'		: '[icon_block icon="icon-lamp" align="" color="" size="25"]',
		'idea'				: '[idea]Insert your content here[/idea]',
		'image'				: '[image src="" align="" caption="" link="" link_image="" target="" alt="" border="0" greyscale="0" animate=""]',
		'popup'				: '[popup title="Title" padding="0" button="0"]Insert your popup content here[/popup]',
		'progress_icons'	: '[progress_icons icon="icon-heart-line" count="5" active="3" background=""]',
		'share_box'			: '[share_box]',
		'table'				: '<table><thead><tr><th>Column 1 heading</th><th>Column 2 heading</th><th>Column 3 heading</th></tr></thead><tbody><tr><td>Row 1 col 1 content</td><td>Row 1 col 2 content</td><td>Row 1 col 3 content</td></tr><tr><td>Row 2 col 1 content</td><td>Row 2 col 2 content</td><td>Row 2 col 3 content</td></tr></tbody></table>',
		'tooltip'			: '[tooltip hint="Insert your hint here"]Insert your content here[/tooltip]',
		'tooltip_image'		: '[tooltip_image hint="Insert your hint here" image=""]Insert your content here[/tooltip_image]',
	};

	
	// jquery.ui =================================================

	
	desktop.sortable({ 
		cursor					: 'move',
		forcePlaceholderSize	: true, 
		placeholder				: 'mfn-placeholder',
		items					: '.mfn-row',
		opacity					: 0.9		
	});
	
	desktop.find('.mfn-sortable').sortable({ 
		connectWith				: '.mfn-sortable',
		cursor					: 'move',
		forcePlaceholderSize	: true, 
		placeholder				: 'mfn-placeholder',
		items					: '.mfn-item',
		opacity					: 0.9,
		receive					: mfnSortableReceive
	});

	
	// section ===================================================
	
	
	// add section -----------------------------------------------
	jQuery('.mfn-row-add-btn').click(function(){
		var clone = jQuery('#mfn-rows .mfn-row').clone(true);

		clone.find('.mfn-sortable').sortable({ 
			connectWith				: '.mfn-sortable',
			cursor					: 'move',
			forcePlaceholderSize	: true, 
			placeholder				: 'mfn-placeholder',
			items					: '.mfn-item',
			opacity					: 0.9,
			receive					: mfnSortableReceive
		});
		
		clone.hide()
			.find('.mfn-element-content > input').each(function() {
				jQuery(this).attr('name',jQuery(this).attr('class')+'[]');
			});
		
		sectionID.val(sectionID.val()*1+1);
		clone
			.find('.mfn-row-id').val(sectionID.val());
		
		desktop.append(clone).find(".mfn-row").fadeIn(500);
	});
	
	
	// clone section ---------------------------------------------
	jQuery('.mfn-row .mfn-row-clone').click(function(){
		var element = jQuery(this).closest('.mfn-element');

		// sortable destroy, clone & init for cloned element
		element.find('.mfn-sortable').sortable('destroy');
		var clone = element.clone(true);
		
		mfnSortableInit(element);
		mfnSortableInit(clone);
		
		sectionID.val(sectionID.val()*1+1);
		clone
			.find('.mfn-row-id, .mfn-item-parent').val(sectionID.val());
		
		element.after(clone);
	});
	
	
	// add item list toggle ---------------------------------------
	jQuery('.mfn-item-add-btn').click(function(){
		var parent = jQuery(this).parent();
		
		if( parent.hasClass('focus') ){
			parent.removeClass('focus');
		} else {
			jQuery('.mfn-item-add').removeClass('focus');
			parent.addClass('focus');
		}
	});
	
	
	// add item ---------------------------------------------------
	jQuery('.mfn-item-add-list a').click(function(){
		
		jQuery(this).closest('.mfn-item-add').removeClass('focus');
		
		var parentDesktop = jQuery(this).parents('.mfn-row').find('.mfn-droppable');
		var targetSectionID = jQuery(this).parents('.mfn-row').find('.mfn-row-id').val(); 
		
		var item = jQuery(this).attr('class');
		var clone = jQuery('#mfn-items').find('div.mfn-item-'+ item ).clone(true);

		clone
			.hide()
			.find('.mfn-element-content input').each(function() {
				jQuery(this).attr('name',jQuery(this).attr('class')+'[]');
			});
		
		clone.find('.mfn-item-parent').val(targetSectionID);
	
		parentDesktop.append(clone).find(".mfn-item").fadeIn(500);
	});
	
	
	// item =======================================================
	
	
	// increase item size --------------------------------------
	jQuery('.mfn-item-size-inc').click(function(){
		var item = jQuery(this).closest('.mfn-item');
		var item_type = item.find('.mfn-item-type').val();
		var item_sizes = items[item_type];
		
		for( var i = 0; i < item_sizes.length-1; i++ ){
		
			if( ! item.hasClass( classes[item_sizes[i]] ) ) continue;
			
			item
				.removeClass( classes[item_sizes[i]] )
				.addClass( classes[item_sizes[i+1]] )
				.find('.mfn-item-size').val( item_sizes[i+1] );
			
			item.find('.mfn-item-desc').text( item_sizes[i+1] );
	
			break;
		}	
	});
	
	
	// decrease size ----------------------------------------------
	jQuery('.mfn-item-size-dec').click(function(){
		var item = jQuery(this).closest('.mfn-item');
		var item_type = item.find('.mfn-item-type').val();
		var item_sizes = items[item_type];
		
		for( var i = 1; i < item_sizes.length; i++ ){
			
			if( ! item.hasClass( classes[item_sizes[i]] ) ) continue;
			
			item
				.removeClass( classes[item_sizes[i]] )
				.addClass( classes[item_sizes[i-1]] )
				.find('.mfn-item-size').val( item_sizes[i-1]);
			
			item.find('.mfn-item-desc').text( item_sizes[i-1] );
			
			break;
		}		
	});
	
	
	// clone item ---------------------------------------------
	jQuery('.mfn-item .mfn-item-clone').click(function(){
		var element = jQuery(this).closest('.mfn-element');
		var clone = element.clone(true);
		element.after(clone);
	});
	
	
	// element ===================================================

	
	// delete element --------------------------------------------
	jQuery('.mfn-element-delete').click(function(){
		var item = jQuery(this).closest('.mfn-element');
		
		if( confirm( "You are about to delete this element.\nIt can not be restored at a later time! Continue?" ) ){
			item.fadeOut(500,function(){jQuery(this).remove();});
	    } else {
	    	return false;
	    }
	});
	
	
	// helper - switch editor  ------------------------------------
	jQuery('#mfn-popup').on('click', '.mfn-switch-editor', function(e) {
		e.preventDefault();
		if( tinymce.get('mfn-editor') ) {
			var tinyHTML = tinymce.get('mfn-editor').getContent();		// Fix | HTML Tags 1/2
			tinymce.execCommand('mceRemoveEditor', false, 'mfn-editor');
			jQuery('#mfn-editor').val( tinyHTML );						// Fix | HTML Tags 2/2
		} else {
        	tinymce.execCommand('mceAddEditor', false, 'mfn-editor');
        }
	});

	
	var source_item = '';
	var source_top = '';

	// popup - edit -----------------------------------------------
	jQuery('.mfn-element-edit').click(function(){
		
		source_top = jQuery(this).offset().top;
		
		// hide Publish/Update button	
		jQuery('#publish').fadeOut(500); 
		jQuery('#vc_navbar').fadeOut(500);	
		
		jQuery('#mfn-content, .form-table').fadeOut(50);
		source_item = jQuery(this).closest('.mfn-element');
		var clone_meta = source_item.children('.mfn-element-meta').clone(true);
	
		jQuery('#mfn-popup')
			.append(clone_meta)
			.fadeIn(500);
		
		// FIX | Chrome 43.0.2357.65 (64-bit)
		jQuery('#mfn-popup textarea').each(function(){
			var chromeFix = jQuery(this).val();
			jQuery(this).html( chromeFix + ' ' );
			//jQuery(this).val( chromeFix );
		});

		// scroll
		if( jQuery('#mfn-wrapper').length > 0 ){
			var adjustment = 30;
			jQuery('html, body').animate({
				scrollTop: jQuery('#mfn-wrapper').offset().top - adjustment
			}, 500);
		}
		
		source_item.children('.mfn-element-meta').remove();
	
		
		// mce - editor ---------------

		jQuery('#mfn-popup textarea.editor').attr('id','mfn-editor');            

		try {
			jQuery('.wp-switch-editor.switch-html').click();
			jQuery('.wp-switch-editor.switch-tmce').click();
			tinymce.execCommand('mceAddEditor', true, 'mfn-editor');
		} catch (err) {
//			console.log(err);
		}
		
		jQuery('#mfn-popup .mce-tinymce .mce-i-wp_more, #mfn-popup .mce-tinymce .mce-i-dfw, #mfn-popup .mce-tinymce .mce_woocommerce_shortcodes_button, #mfn-popup .mce-tinymce .mce_revslider')
			.closest('.mce-btn').remove();

		// removed since Be 4.5, restored since Be 7.3
		jQuery('#mfn-popup .mce-tinymce').closest('td').prepend('<a href="#" class="mfn-switch-editor"">Visual / HTML<span>may remove some tags</span></a>');

		// end: mce - editor ----------
		        
	});

	
	// popup - close ----------------------------------------------
	jQuery('#mfn-popup .mfn-popup-close, #mfn-popup .mfn-popup-save').click(function(){

		// mce - editor ---------------

		try {
			if( tinymce.get('mfn-editor') ){
				jQuery('#mfn-editor').html( tinymce.get('mfn-editor').getContent() );
				tinymce.execCommand('mceRemoveEditor', false, 'mfn-editor');
			} else {
				jQuery('#mfn-editor').html( jQuery('#mfn-editor').val() );
			}
	    } catch (err) {
//	    	console.log(err);
	    }
	    
	    jQuery('.mfn-switch-editor').remove();
	    jQuery('#mfn-editor').removeAttr('id');	    
  
	    // end: mce - editor ----------
		
		
	    // destroy sortable for fields 'tabs'
		if( jQuery('#mfn-popup .tabs-ul.ui-sortable').length ){
			jQuery('#mfn-popup .tabs-ul.ui-sortable').sortable('destroy');
		}
		
		// hide Publish/Update button	
		jQuery('#publish').fadeIn(500); 
		jQuery('#vc_navbar').fadeIn(500);
		
		jQuery('#mfn-content, .form-table').fadeIn(500);
		var popup = jQuery('#mfn-popup');
		var clone = popup.find('.mfn-element-meta').clone(true);

		source_item.append(clone);
		
		popup.fadeOut(50);
	
		setTimeout(function(){
			popup.find('.mfn-element-meta').remove();
		},50);
		
		// scroll
		if( source_top ){
			var adjustment = 40;
			if( jQuery('.vc_subnav-fixed').length > 0 ) adjustment = 96;
			
			jQuery('html, body').animate({
				scrollTop: source_top - adjustment
			}, 500);
		}
		
	});	
	
	
	// go to top ===================================================
	
	jQuery('#mfn-go-to-top').click(function(){
		jQuery('html, body').animate({ 
			scrollTop: 0
		}, 500);
	});
	
	
	// post formats ================================================
	
	jQuery("#post-formats-select label.post-format-standard").text('Standard, Horizontal Image');
	jQuery("#post-formats-select label.post-format-image").text('Vertical Image');
	
	
	// migrate =========================================================
	
	// show/hide
	jQuery('#mfn-migrate .btn-exp').click(function(){
		alert('Please remember to Publish/Update your post before Export.');
		jQuery('.migrate-wrapper ').hide();
		jQuery('.export-wrapper').show();
		
	});

	jQuery('#mfn-migrate .btn-imp').click(function(){
		jQuery('.migrate-wrapper ').hide();
		jQuery('.import-wrapper').show();
	});
	
	jQuery('#mfn-migrate .btn-tem').click(function(){
		jQuery('.migrate-wrapper ').hide();
		jQuery('.templates-wrapper').show();
	});
	
	// copy to clipboard
	jQuery('#mfn-items-export').click(function(){
		jQuery(this).select();
	});
	
	// import
	jQuery('#mfn-migrate .btn-import').click(function(){
		var el = jQuery(this).siblings('#mfn-items-import');
		el.attr('name',el.attr('id'));
		jQuery('#publish').click();
	});
	
	// template
	jQuery('#mfn-migrate .btn-template').click(function(){
		var el = jQuery(this).siblings('#mfn-items-import-template');
		el.attr('name',el.attr('id'));
		jQuery('#publish').click();
	});
	
	
	// seo =========================================================
	
	jQuery('#wp-content-wrap .wp-editor-tabs').prepend('<a class="wp-switch-editor switch-seo" id="content-seo">Builder &raquo; SEO</a>');

	jQuery('#content-seo').click(function(){
		
		if( confirm( "This option is useful for plugins like Yoast SEO to analize post content when you use Muffin Builder.\nIt will collect content from Muffin Builder Elements and copy it into the WordPress Editor.\n\nCurrent Editor Content will be replaced.\nYou can hide the content if you turn \"Hide the content\" option ON.\n\nPlease remember to Publish/Update your post before & after use of this option.\nContinue?" ) ){
			
			var items_decoded = jQuery('#mfn-items-seo-data').val();
			console.log(items_decoded);
			jQuery('#content-html').click();
			jQuery('#content').val( items_decoded ).text( items_decoded );
			
	    } else {
	    	return false;
	    }

	});
	
	
	
	// Textarea | Shortcodes ========================================	
	
	
	// Helper | Wrap Selected Text OR Insert Into Carret ------------
	function wrapText(textArea, openTag, closeTag){
		var len 	= textArea.val().length;
		var start	= textArea[0].selectionStart;
		var end 	= textArea[0].selectionEnd;
		var selectedText 	= textArea.val().substring(start, end);
		var replacement 	= openTag + selectedText + closeTag;
		textArea.val(textArea.val().substring(0, start) + replacement + textArea.val().substring(end, len));
	}
	
	
	// Add Shortcode | Menu -----------------------------------------
	jQuery('.mfn-sc-add-btn').click(function(){
		var parent = jQuery(this).parent();
		
		if( parent.hasClass('focus') ){
			parent.removeClass('focus');
		} else {
			jQuery('.mfn-sc-add').removeClass('focus');
			parent.addClass('focus');
		}
	});
	
	
	// Insert Shortcode ------------------------------------------------
	jQuery('.mfn-sc-add-list a').click(function(){
		jQuery(this).closest('.mfn-sc-add').removeClass('focus');
		
		var sc = jQuery(this).attr('data-rel');
		if( sc ){
			var shortcode = shortcodes[sc];
			var textarea = jQuery(this).closest('td').find('textarea');
			wrapText( textarea, shortcode, '' );
		}
	});

	
	// Insert HTML Tag ------------------------------------------------
	jQuery('.mfn-sc-tools a').click(function(){
		
		var open 	= jQuery(this).attr('data-open');
		var close 	= jQuery(this).attr('data-close');
		
		var open 	= open.replace( /X/g, '"' );
		
		if( close ){
			open 	= '<'+ open + '>';
			close 	= '</'+ close + '>';
		} else {
			open	= '<'+ open + ' />';
			close 	= '';
		}

		var textarea = jQuery(this).closest('td').find('textarea');
			
		wrapText( textarea, open, close );

	});

}


/* ---------------------------------------------------------------------------
 * Clone fix (textarea, select)
 * --------------------------------------------------------------------------- */
(function (original) {
	jQuery.fn.clone = function(){
		var result = original.apply (this, arguments),
		my_textareas = this.find('textarea:not(.editor), select'),
		result_textareas = result.find('textarea:not(.editor), select');
		
		for (var i = 0, l = my_textareas.length; i < l; ++i){
			jQuery(result_textareas[i]).val( jQuery(my_textareas[i]).val() );
		}
		
		return result;
	};
})(jQuery.fn.clone);



/* ---------------------------------------------------------------------------
 * jQuery(document).ready
 * --------------------------------------------------------------------------- */
jQuery(document).ready(function(){
	mfnBuilder();
});



/* ---------------------------------------------------------------------------
 * jQuery(document).mouseup
 * --------------------------------------------------------------------------- */
jQuery(document).mouseup(function(e)
{
	if (jQuery(".mfn-item-add").has(e.target).length === 0){
		jQuery(".mfn-item-add").removeClass('focus');
	}
	if (jQuery(".mfn-sc-add").has(e.target).length === 0){
		jQuery(".mfn-sc-add").removeClass('focus');
	}
});
