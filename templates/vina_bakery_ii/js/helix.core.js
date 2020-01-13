/**
 * @package Helix Framework
 * @author JoomShaper http://www.joomshaper.com
 * @copyright Copyright (c) 2010 - 2013 JoomShaper
 * @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 or later
*/

spnoConflict(function($){
    $('.sp-totop').on('click', function() {
        $('html, body').animate({
            scrollTop: $("body").offset().top
        }, 500);
    });
    //tooltip
    $('.hasTip').tooltip({
        html: true
    })
});
jQuery(document).ready(function($){
	//menu-mobile
	$sidebaroffcanvas = $(".sidebar-offcanvas");
	$sidebaroffcanvas.height($(window).height());
	$('[data-toggle=offcanvas]').click(function () {
		$('.row-offcanvas').toggleClass('active')
	});
	
	$(window).load(function(){	
		$window        	= $(window),
		minHeight		= $window.height(),
		minWidth		= $window.width(),
		$head			= $("#sp-header-wrapper"),
		$header			= $("#sp-header-wrapper .container"),
		$mobilemenu		= $(".sp-mobile-menu.nav-collapse"),
		$mobilemenuUl	= $(".sp-mobile-menu.nav-collapse >ul"),
		$mainMenu		= $(".sp-main-menu-toggler"),
		
		$mobilemenu.css('z-index'		, 1000);
		$mobilemenuUl.css('width'		, $header.width());
		$mobilemenuUl.css('margin-left'	, 'auto');
		$mobilemenuUl.css('margin-right', 'auto');
		$mainMenu.attr("href", '#1');
		
		//fix mail to
		$(".sp-blocknumber a").parent("span").css({
			"position":"relative",
			"display":"inline-block",
			"margin-top":"-13px"
		});
	});
	
	$(window).resize(function(){
		$(this).load();
	});		
});