$( document ).ready(function() {
		"use strict";
		var distance = $('.header-nav').offset().top,
		$window = $(window);
		var windowWidth = $( window ).width();
		var resDist = $('.responsive-nav').offset().top;
		if(windowWidth>700){
			$window.scroll(function() {
				if ( $window.scrollTop() >= distance) {
					$('.header-nav').css({"position":"Fixed","margin-top":"-103px"});
					$('.strapline').css("margin-top","74px");
				} else {
					$('.header-nav').css({"position":"static","margin-top":"0"});
					$('.strapline').css("margin-top","0px");
				}
			});
		} else {
			$window.scroll(function() {
				if ( $window.scrollTop() >= resDist-10) {
					$('.responsive-nav').css({"position":"Fixed","margin-top":"-93px","right":"0px"});
					$('#res-nav-bar').css({"position":"Fixed","top":"0px","height":"100%"});
				} else {
					$('.responsive-nav').css({"position":"absolute","margin-top":"0","right":"0px"});
					$('#res-nav-bar').css({"position":"absolute","top":"auto","height":"calc(100% - 103px)"});
				}
			});		
		}
		$('.img-overlay').mouseenter(function(){
			$(this).parent().animate({ opacity: 0.6}, 300, function() {
  				$(this).toggleClass(""+$(this).attr('Class')+" "+$(this).attr('Class')+"hov").animate({opacity: 1},200);
			});
			$(this).animate({fontSize:'56px'},700);	
		});	
		
		$('.img-overlay').mouseleave(function(){
			$(this).parent().animate({ opacity: 0.6}, 300, function() {
  				$(this).toggleClass(""+$(this).attr('Class')+" "+$(this).attr('Class').replace('hov','')+"").animate({opacity: 1},200);
			});			
			$(this).animate({fontSize:'36px'},700);
		});	
		
		$("#nav-contact-us").click(function(){
			$('body').css('overflow-y','hidden');
			$('.modal-shadow').fadeIn('fast');	
			$('#contact-modal-choose').slideDown();	
			//$('.contact-modal').slideDown();	
		});		
		
		$('.modal-shadow').click(function(){
			$('body').css('overflow-y','auto');
			$(this).fadeOut('fast');
			$('.contact-modal').hide();
		});
		$('.contact-modal').click(function(){
			event.stopPropagation();
		});	
		$('#public-contact').click(function(){
			$('#contact-modal-choose').fadeOut('fast',function(){
				$('#get-quote-modal').slideDown('slow');	
			});
		});
	});
	jQuery.fn.rotate = function(degrees) {
		"use strict";
		$(this).css({'transform' : 'rotate('+ degrees +'deg)','transition':'transform 0.25s linear'});
		return $(this);
	};	
	var rotation = 0;
	$('#nav-icon').click(function() {
		"use strict";
		rotation += 90;
		$(this).rotate(rotation);
		$(this).children().toggleClass("fa fa-bars fa fa-close");
		$('#res-nav-bar').toggle({"display":"block"},{"display":"none"});
	});

/*********Danny dodgy code**********/
$( document ).ready(function() {
	"use strict";
	$('#helpmeBtn').click(function() {
		//$( "#helpmeToggle" ).toggle( "slide", {direction:'left'} );
		var location = $( "#helpMeDiv" ).css('left');
		if(location==='0px'){
			if ($(window).width() < 960) { 
				$( "#helpMeDiv" ).animate({left:'70%'});
				$( "#helpmeToggle" ).animate({ width:'70%'});				
			} else {
				$( "#helpMeDiv" ).animate({left:'40%'});
				$( "#helpmeToggle" ).animate({ width:'40%'});
			}
		} else {
			$( "#helpMeDiv" ).animate({left:'0px'});
			$( "#helpmeToggle" ).animate({ width:'0px'});
		}

		$("#helpmeToggle").load('ajax/loadHelpMe.php?page=home');
	});
});