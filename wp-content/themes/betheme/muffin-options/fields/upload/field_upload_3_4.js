function MfnUpload(){
	(function($) {
		
		var header_clicked = false;
		var item_clicked = '';
		 
		jQuery("img[src='']").attr("src", mfn_upload.url);
		
		jQuery('.mfn-opts-upload').click(function() {
			item_clicked = jQuery(this);
			header_clicked = true;
			formfield = jQuery(this).attr('rel-id');
			preview = jQuery(this).prev('img');
			tb_show('', 'media-upload.php?type=image&amp;post_id=0&amp;TB_iframe=true');
			return false;
		});
		
		// Store original function
		window.original_send_to_editor = window.send_to_editor;
		
		window.send_to_editor = function(html) {
			if (header_clicked) {
				imgurl = jQuery('img',html).attr('src');
				jQuery(item_clicked).siblings('input').val(imgurl);
				jQuery(item_clicked).siblings('.mfn-opts-upload-remove').fadeIn('slow');
				jQuery(item_clicked).hide();
				jQuery(preview).attr('src' , imgurl).fadeIn('slow');;
				tb_remove();
				header_clicked = false;
			} else {
				window.original_send_to_editor(html);
			}
		}
		
		jQuery('.mfn-opts-upload-remove').click(function(){
			jQuery(this).siblings('input').val('');
			jQuery(this).prev().fadeIn('slow');
			jQuery(this).prev().prev().fadeOut('slow', function(){jQuery(this).attr("src", mfn_upload.url);});
			jQuery(this).fadeOut('slow');
		});
	
	})(jQuery);
}
	
jQuery(document).ready(function($){
	var mfn_upload = new MfnUpload();
});