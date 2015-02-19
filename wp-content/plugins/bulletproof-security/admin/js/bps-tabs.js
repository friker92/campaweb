// BPS jQuery Tabs Menus with Toggle/Opacity
jQuery(document).ready(function($){
	
	$( '#bps-tabs' ).tabs({ 
		show: { 
			opacity: "toggle", 
			duration: 400 
			} 
	});

	// toggle causes undesirable effects/results for inpage tabs
	$('#bps-edittabs').tabs();
});