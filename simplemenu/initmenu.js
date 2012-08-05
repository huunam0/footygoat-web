var timeoutID;
var showmenu=false;
$(function(){
	$('.dropdown').click(function(){
		var submenu = $(this).parent().next();
		if (!showmenu) {
			$('.sublinks').stop(false, true).hide();
			window.clearTimeout(timeoutID);
			

			submenu.css({
				position:'absolute',
				top: $(this).offset().top + $(this).parent().parent().parent().height() + 'px',
				left: $(this).offset().left +$(this).width()/2 -submenu.width()/2+ 'px',
				zIndex:1000
			});
			
			submenu.stop().slideDown(300);
			
			// submenu.mouseleave(function(){
				// $(this).delay(2000).slideUp(300);
			// });
			// submenu.mouseenter(function(){
				// window.clearTimeout(timeoutID);
			// });
			showmenu=true;
		} else {
			timeoutID = window.setTimeout(function() {$('.sublinks').stop(false, true).slideUp(300);}, 250);  // slide up
			showmenu=false;
			submenu.slideUp(300);
		}
		//showmenu=(showmenu?false:true);
	});
	$('.hidedrop').click(function(){
		showmenu=false;
		$(this).parent().slideUp(300);
	});
});