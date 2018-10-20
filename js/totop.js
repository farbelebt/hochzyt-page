		$(document).ready(function(){
		// --------------------------------------------------
		// Start jQuery (Wenn die Seite zu Ende geladen wurde)
		// --------------------------------------------------
			$("#totop").click(function(){
					
					$("html, body").animate({scrollTop:0},1000);
				});
			
			$(window).scroll(function(){
				var scrollposition = $(window).scrollTop();
				if(scrollposition>150){
					$("#totop").fadeIn(1000);
				}else{
					$("#totop").hide();
				}
				
			});
		// --------------------------------------------------
		// ENDE jQuery
		// --------------------------------------------------
		});// JavaScript Document