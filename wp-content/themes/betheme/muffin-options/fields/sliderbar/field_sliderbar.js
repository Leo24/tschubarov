jQuery(document).ready(function(){
	
	jQuery('.sliderbar').each(function(){
		
		var el 		= jQuery(this);
		var input 	= jQuery(this).siblings('input');
		
		var value 	= input.attr('value');
		var min 	= el.attr('data-min') * 1;
		var max 	= el.attr('data-max') * 1;
		
//		console.log(min + ' ' + max);
		
		el.slider({ 
			range	: "min",
			min		: min,
			max		: max,
			value	: value,
			slide	: function(event, ui){
				input.attr('value',ui.value);
			}
		});
		
	});

});