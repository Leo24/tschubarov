(function($, window, document) {
  $(function() {  
  
    function runTableSorter() {
  
      $('.fiverr-orders').DataTable({
        "responsive": true,
        "paging": false,
        "searching": false,
        "order": [1, 'desc'],
        "columns": [
          { "orderable": false },
          { "orderable": false },
          null,
          null,
          null,
          { "orderable": true },
          { "orderable": false },
          null,
          null
        ]
        
      });
    
    }
    
    runTableSorter();
  
		$('.assigntome').on('click', function(event) { 

		  event.preventDefault();
		  
		  $this = $(this);
		  
		  $this.siblings('.spinner').addClass('is-active');
  		
      var post_data = {
          pid: this.getAttribute('data-pid'),
          action : 'assign-to-me',
          fifo_nonce : ajaxConfig.fifo_nonce
      };
      jQuery.ajax({
				type: "POST",
				url: ajaxurl,
				data: post_data,
				dataType: "json",
				success: function(response) {
                   if (response.state == 'ok'){
                      $this.parent().children('.assigned-user').html(response.display_name);
                      $this.closest('tr').children('.d-status').html(response.status);
                      $this.siblings('.spinner').removeClass('is-active'); 
                      showDeadlines();  
                      $this.toggle();                              
                   } else {
                      $this.siblings('.spinner').removeClass('is-active');
                      alert('Can\'t save user assigment.');
                   }
				},
        error: function(response) {
          $this.siblings('.spinner').removeClass('is-active');
          alert('Can\'t save user assigment.');
        }
      }); 
    		
    		
		});

			$('.assignedto').on('change', function(event) { 
			  //event.preventDefault();
			  
			  $this = $(this);
			  
			  $this.siblings('.spinner').addClass('is-active');
			  
        var post_data = {
            pid: this.getAttribute('data-pid'),
            action : 'assign-by-admin',
            fifo_nonce : ajaxConfig.fifo_nonce,
            user_id : this.value
        };
        jQuery.ajax({
  				type: "POST",
  				url: ajaxurl,
  				data: post_data,
  				dataType: "json",
  				success: function(response) {
                     if (response.state == 'ok'){
                       $this.parent().children('.assigned-user').html(response.display_name);
                       $this.closest('tr').children('.d-status').html(response.status);
                       $this.siblings('.spinner').removeClass('is-active'); 
                       showDeadlines();
                       $this.toggle();                               
                     } else {
                       $this.siblings('.spinner').removeClass('is-active');
                       $this.toggle();
                       alert('Can\'t save user assigment.');
                     }
  				},
          error: function(response) {
            $this.siblings('.spinner').removeClass('is-active');
            $this.toggle();
            alert('Can\'t save user assigment.');
          }
        }); 
    		
    		
			});	// End	
			
			
		  $('.assign_to').on('click', function(e){
  		  //only show-hide author selector
        e.preventDefault();
        
        $(this).siblings('select').toggle();
        
      });
      

			$('.fiverr-orders').on('focus','.order_status', function () {
        // Store the current value on focus and on change
        window.fifo_previous = this.value;
      }).on('change','.order_status', function(event) { 
			  //event.preventDefault();
			  
			  $this = $(this);			  
			  
        var post_data = {
            pid: this.getAttribute('data-pid'),
            action : 'change-status',
            fifo_nonce : ajaxConfig.fifo_nonce,
            status : this.value
        };
        
        if (this.value !== 'Urgent') {
			    
			    $this.siblings('.spinner').addClass('is-active');
        
          jQuery.ajax({
    				type: "POST",
    				url: ajaxurl,
    				data: post_data,
    				dataType: "json",
    				success: function(response) {
                       if (response.state == 'ok'){
                         $this.closest('td').children('.fifo-status').html(response.status);
                         $this.closest('td').children('.status-icon').attr('class', 'status-icon '+response.status_class);
                         $this.closest('tr').attr('class', 'tr-'+response.status_class);
                         $this.siblings('.spinner').removeClass('is-active');  
                         
                         if (response.status === 'Completed') {
                           $this.closest('td').children('.deadline').remove();
                         } else showDeadlines();
                                                    
                       } else {
                         $this.siblings('.spinner').removeClass('is-active');
                         alert('Can\'t save order status.');
                       }
    				},
            error: function(response) {
              $this.siblings('.spinner').removeClass('is-active');
              alert('Can\'t save order status.');
            }
          }); 
        
        } else {
          //Show warning window
          $('.fifo-popup-single').show();
          $('.fifo-shadow').show();
          window.fifo_order = { pid : post_data.pid, action: 'change-single-to-urgent', fifo_nonce : ajaxConfig.fifo_nonce, status : 'Urgent'};
          window.fifo_obj = $this;
          //
        }
    		
    		
			});	// End of change
			
			$('.fifo-popup-single').on('click','.yes', function(event) { 
  			// accept and set Urgent Status
			  event.preventDefault();
			  
			  $this = window.fifo_obj;
			  
			  $this.siblings('.spinner').addClass('is-active');
        
          jQuery.ajax({
    				type: "POST",
    				url: ajaxurl,
    				data: window.fifo_order,
    				dataType: "json",
    				success: function(response) {
                       if (response.state == 'ok'){
                         $this.closest('td').children('.fifo-status').html(response.status);
                         $this.closest('td').children('.status-icon').attr('class', 'status-icon '+response.status_class);
                         $this.closest('tr').attr('class', 'tr-'+response.status_class);
                         $this.siblings('.spinner').removeClass('is-active'); 
                         
                         $this.closest('tr').children('.d-status').html(response.html_status); 
                         
                         showDeadlines();
                                                    
                       } else {
                         $this.siblings('.spinner').removeClass('is-active');
                         alert('Can\'t save order status.');
                       }
    				},
            error: function(response) {
              $this.siblings('.spinner').removeClass('is-active');
              alert('Can\'t save order status.');
            }
          }); 
          
          $('.fifo-popup-single').hide();
          $('.fifo-shadow').hide();    		
    		
			});	// End of click		
			
			$('.fifo-popup-single').on('click','.no', function(event) { 
  			$this = window.fifo_obj;
  			$this.siblings('.spinner').removeClass('is-active');
  			$('.fifo-popup-single').hide();
        $('.fifo-shadow').hide();
        $this.val(window.fifo_previous);
			});	
			
			
			function showDeadlines() {
  			$('.deadline').each(function(){
    			var unix_timestamp = this.getAttribute('data-deadline');
    			
    			var $this = $(this);
    			
          $this.countdown(new Date(unix_timestamp*1000), function(event) {
            var format = '%H:%M:%S';
              if(event.offset.days > 0) {
                 format = '%-d day%!d ' + format;
               }          
            $this.html(event.strftime(format));
          });
          
  			});  			
			}	  
			
			showDeadlines();  
			
			
			$('#bulk-submit').on('click', function(e){
        if ($('#bulk-status').val()==='Urgent') {
          e.preventDefault();
          $('.fifo-shadow').show();
          $('.fifo-popup-bulk').show();
        }
      });

      $('.fifo-popup-bulk').on('click','.yes', function(event) { 
        $('<input />').attr('type', 'hidden')
            .attr('name', "bulk_action")
            .attr('value', "Apply to Selected")
            .appendTo('#fifo_orders');
        $('#fifo_orders').submit();
			});
      
      $('.fifo-popup-bulk').on('click','.no', function(event) { 
  			$('.fifo-popup-bulk').hide();
        $('.fifo-shadow').hide();
			});
			
			
			//ajax bulk orders search
  		$('#fifo_search_orders').on('click', function(event) { 
  
  		  event.preventDefault();
  		  
  		  $this = $(this);
  		  
  		  $this.siblings('.spinner').addClass('is-active');
    		
        var post_data = {
            action : 'search-orders',
            pids : $('#forders').val(),
            fifo_nonce : ajaxConfig.fifo_nonce
        };
        
        jQuery.ajax({
  				type: "POST",
  				url: ajaxurl,
  				data: post_data,
  				dataType: "json",
  				success: function(response) {
                      if (response.state == 'ok'){
                        $this.siblings('.spinner').removeClass('is-active');   
                        $('#found_fiverrs').text(response.found_header);                         
                        $('#not_found_fiverrs').text(response.not_found_header);                         
                        $('#found_fiverrs_results').html(response.found_keys);                         
                        $('#not_found_fiverrs_results').html(response.not_found);                         
                      } else {
                        $this.siblings('.spinner').removeClass('is-active');
                        alert('Can\'t complete request. Response Answer is Error');
                      }
  				},
          error: function(response) {
            $this.siblings('.spinner').removeClass('is-active');
            alert('Can\'t complete request.');
          }
        }); 
      		
      		
  		});			
  		
  		
  		$('.bl_view_more').on('click', function() {
    		console.log('@@@test: ');
    		$(this).hide().parent('.blinks-view').addClass('all');
  		});
  		
  		$('.bl_close').on('click', function() {
    		$(this).siblings('.bl_view_more').show().parent('.blinks-view').removeClass('all');
  		});
  		
  		if (window.Dropzone) {
  		
    		Dropzone.options.backlinksFiles = {
      		autoProcessQueue: false,
          acceptedFiles : '.txt',
          uploadMultiple: true,
          parallelUploads: 99,
          init: function() {
            var submitButton = document.querySelector("#submit-all"),
                myDropzone = this; // closure  
            submitButton.addEventListener("click", function() {
              myDropzone.processQueue(); // Tell Dropzone to process all queued files.              
            });
        
            // You might want to show the submit button only when 
            // files are dropped here:
            this.on("addedfile", function() {
              // Show submit button here and/or inform user to click it.
              $('#submit-all').removeClass('disabled');
            });
        
          },
          success: function() {
          },
          complete: function() {
            this.removeAllFiles();
            location.reload();
          },
          maxfilesreached: function() {
            alert('You can upload only 99 files at once. Please remove some files to fill in this limit.<br /> You can add those files to the next task.');
          }
          
        };
      
      }

      function load_comments (callback) {
          if (typeof callback !== 'function') {
              callback = function () {
              }
          }

          jQuery.post(
              ajaxurl,
              {
                  'action': 'get_comments',
                  'pid':   comments_dialog.data('pid')
              },
              function(response){
                  var response = $.parseJSON(response);
                  $('#the-comment-list').empty();
                  if (response.length) {
                      var comments = wp.template("comments");
                      for (i in response) {
                          if (typeof response[i] === 'object') {
                              var comment = wp.template("comment");

                              $('#the-comment-list').append(comment(response[i]));
                          }
                      }

                  } else {
                      var template = wp.template("no-comments");
                      $('#the-comment-list').html(template);
                  }

                  callback();
              }
          );
      }

      comments_dialog = $( "#comments-dialog" ).dialog({
          autoOpen: false,
          height: 600,
          width: 800,
          modal: true,
          open: function () {
              load_comments();
          },
          buttons: {
              "New comment": function () {
                  insert_comment_dialog.data('pid',comments_dialog.data('pid'));
                  insert_comment_dialog.dialog("open");
              },
              "Close": function() {
                  comments_dialog.dialog("close");
              }
          }
      });

      insert_comment_dialog = $( "#insert-comment-dialog" ).dialog({
          autoOpen: false,
          height: 400,
          width: 600,
          modal: true,
          open: function () {
              insert_comment_dialog.find('[name=comment_content]').val('')
          },
          buttons: {
              "Add comment": function () {
                  jQuery.post(
                      ajaxurl,
                      {
                          'action': 'insert_comment',
                          'pid': insert_comment_dialog.data('pid'),
                          'content': insert_comment_dialog.find('[name=comment_content]').val()
                      },
                      function(response){
                          if(response) {
                              insert_comment_dialog.dialog("close");
                              load_comments (function () {
                                    var comments_count = comments_dialog.find('tr.comment').size();
                                  $('#fifo_orders a.comments-dialog-open[data-pid='+insert_comment_dialog.data('pid')+']').text('View Comments ('+comments_count+')');
                              });

                          }
                      }
                  );
              },
              "Cancel": function() {
                  insert_comment_dialog.dialog("close");
              }
          }
      });

      $('.comments-dialog-open').click(function(e){
          e.preventDefault();
          comments_dialog.data('pid',$(this).data('pid'));
          comments_dialog.dialog("open");
      })


			
  });
}(window.jQuery, window, document));
