jQuery(document).on('click',".carousel-button-right",function(){var carusel=jQuery(this).parents('.carousel');
right_carusel(carusel);return false;});
jQuery(document).on('click',".carousel-button-left",function(){var carusel=jQuery(this).parents('.carousel');
left_carusel(carusel);return false;});
function left_carusel(carusel){var block_width=jQuery(carusel).find('.carousel-block').outerWidth();
jQuery(carusel).find(".carousel-items .carousel-block").eq(-1).clone(true).prependTo(jQuery(carusel).find(".carousel-items"));
jQuery(carusel).find(".carousel-items").css({"left":"-"+block_width+"px"});
jQuery(carusel).find(".carousel-items .carousel-block").eq(-1).remove();
jQuery(carusel).find(".carousel-items").animate({left:"0px"},200);}
function right_carusel(carusel){var block_width=jQuery(carusel).find('.carousel-block').outerWidth();
jQuery(carusel).find(".carousel-items").animate({left:"-"+block_width+"px"},200,function(){jQuery(carusel).find(".carousel-items .carousel-block").eq(0).clone(true).appendTo(jQuery(carusel).find(".carousel-items"));
jQuery(carusel).find(".carousel-items .carousel-block").eq(0).remove();
jQuery(carusel).find(".carousel-items").css({"left":"0px"});});}
jQuery(function(){})
function auto_right(carusel){setInterval(function(){if(!jQuery(carusel).is('.hover'))right_carusel(carusel);},1000)}
jQuery(document).on('mouseenter','.carousel',function(){jQuery(this).addClass('hover')})
jQuery(document).on('mouseleave','.carousel',function(){jQuery(this).removeClass('hover')})
jQuery(window).on('load',function(){
	setTimeout(function(){
		jQuery(window).trigger('scroll');
	});
	console.log('triggered');
},1000);