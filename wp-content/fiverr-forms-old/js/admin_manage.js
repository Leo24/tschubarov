if (!Date.now) {
    Date.now = function() { return new Date().getTime(); }
}

(function($, window, document) {
	$(function() {
		// The DOM is ready!
		var run_tl = function() {
  		$('.elapse-time').each(function() {
         var $this = $(this);
         
         var unix_timestamp = this.getAttribute('data-last-changed');
         
         $this.countdown(new Date(unix_timestamp*1000), {elapse: true}).on('update.countdown', function(event) {
            var $this = $(this);
            if (event.elapsed) {
              if(event.offset.totalDays > 0 ) {
                $this.html(event.strftime('%D days <span>%H:%M:%S</span>'));
              } else {
                $this.html(event.strftime('<span>%H:%M:%S</span>'));
              }
            } else {
               //$this.html(event.strftime('%D days To end: <span>%H:%M:%S</span>'));
            }
         });
      });  		
		}
		
    window.run_timelapser =  run_tl;
    
    var setStatuses = function() {
  		$('.td-order').each(function() {
        var $this = $(this);
         
        var unix_timestamp = this.getAttribute('data-last-changed');
        var now = Math.floor(Date.now() / 1000);
           
        hours = Math.ceil((now - parseInt(unix_timestamp,10))/60/60);
           
        if (hours > 2 ) {
          $this.attr({'class' : 'td td-order '+' td-important'});
        } else if (hours > 1) {
          $this.attr({'class' : 'td td-order '+' td-warning'});
        } else {
          $this.attr({'class' : 'td td-order '+' td-ok'});
        }        

      });      
    }
     
    setInterval(function(){
      //setStatuses();
    },5000);   
		
		
		run_timelapser();
		setStatuses();
		
		
		$('.stab').on('click', function(){
        var tab = this.getAttribute('data-tab');
        $('.tab').hide();
        $('.'+tab).show();
        $('.stab').attr({'class' : 'stab'});
        $(this).attr({'class' : 'stab active'});
    });
		
	});
}(window.jQuery, window, document));


String.prototype.toHHMMSS = function () {
    var sec_num = parseInt(this, 10); // don't forget the second param
    var hours   = Math.floor(sec_num / 3600);
    var minutes = Math.floor((sec_num - (hours * 3600)) / 60);
    var seconds = sec_num - (hours * 3600) - (minutes * 60);

    if (hours   < 10) {hours   = "0"+hours;}
    if (minutes < 10) {minutes = "0"+minutes;}
    if (seconds < 10) {seconds = "0"+seconds;}
    var time    = hours+':'+minutes+':'+seconds;
    return time;
}