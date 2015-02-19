// BPS jQuery Accordian
jQuery(document).ready(function($){
    
	$( "#bps-accordion-1" ).accordion({
		collapsible: true,
		autoHeight: false,
		clearStyle: true,
		heightStyle: "content"
    });
    
	// not displayed open by default - slower/smoother animation
	$( "#bps-accordion-2" ).accordion({
		active: false,
		animate: 1500,
		collapsible: true,
		autoHeight: false,
		clearStyle: true,
		heightStyle: "content"
    });

    // displayed open by default - slower/smoother animation
	$( "#bps-accordion-3" ).accordion({
		animate: 1400,
		collapsible: true,
		autoHeight: false,
		clearStyle: true,
		heightStyle: "content"
    });

});