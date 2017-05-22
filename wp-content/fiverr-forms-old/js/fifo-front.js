(function($, window, document) {
	$(function() {
		// The DOM is ready!		
		
		$('#make-report').on('click', function(event) { 
		  event.preventDefault();
		  
		  $this = $(this);
		  
		  $('.dl_rep').attr('href', '').removeClass('active');
		  
		  this.setAttribute('disabled', 'disabled');
		  
		  $this.siblings('.spinner').addClass('is-active');
  		
      var post_data = {
          pid: this.getAttribute('data-pid'),
          action : 'make_report'
      };
      jQuery.ajax({
				type: "POST",
				url: ajaxConfig.ajaxurl,
				data: post_data,
				dataType: "json",
				success: function(response) {
                   if (response.state == 'ok'){
                      $this.siblings('.spinner').removeClass('is-active'); 
                      $this.removeAttr('disabled');
                      $('.dl_rep').attr('href', response.path).addClass('active');
                         
                   } else {
                      $this.siblings('.spinner').removeClass('is-active');
                      $this.removeAttr('disabled');
                      alert('Can\'t generate report.');
                   }
				},
        error: function(response) {
          $this.siblings('.spinner').removeClass('is-active');
          $this.removeAttr('disabled');
          alert('Can\'t generate report.');
        }
      }); 
  		
  		
		});
		
		
	});
}(window.jQuery, window, document));