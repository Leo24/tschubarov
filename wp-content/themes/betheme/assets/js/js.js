$(document).ready(function(){

	$('.mycarousel_recommended').jcarousel({
		wrap: 'circular'
	});
	$('.block_mycarousel_recommended .carousel_arrow_left').click(function(){
		$('.mycarousel_recommended').jcarousel('scroll', '-=1');
	});
	$('.block_mycarousel_recommended .carousel_arrow_right').click(function(){
		$('.mycarousel_recommended').jcarousel('scroll', '+=1');
	});

	$('.mycarousel_extras').jcarousel({
		wrap: 'circular'
	});
	$('.block_mycarousel_extras .carousel_arrow_left').click(function(){
		$('.mycarousel_extras').jcarousel('scroll', '-=1');
	});
	$('.block_mycarousel_extras .carousel_arrow_right').click(function(){
		$('.mycarousel_extras').jcarousel('scroll', '+=1');
	});
	
	
	var waypoints = $('#block_download_cvs').waypoint(function(direction) {
    $('#coupon').addClass('show go');
  },{
    offset: 200 
  })
  
  $('.cclose', '#coupon').on('click', function() {
    $('#coupon').removeClass('show go'); 
  });
	

});

$(window).resize(function(){
});