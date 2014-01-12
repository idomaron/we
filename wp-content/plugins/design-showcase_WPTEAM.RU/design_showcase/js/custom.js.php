<?php
$templateurl = $_GET['tu'];
$toolimg = $_GET['tti'];
$tooltitle = $_GET['ttt'];
$smoothscrolling = $_GET['sb'];
$footer = $_GET['f'];
$tabs = $_GET['t'];

?>
function my_smothscroll(){
jQuery('a[href*=#]').click(function() {
    if (location.pathname.replace(/^\//,'') == this.pathname.replace(/^\//,'')
    && location.hostname == this.hostname) {
      var $target = jQuery(this.hash);
      $target = $target.length && $target
      || jQuery('[name=' + this.hash.slice(1) +']');
      if ($target.length) {
        var targetOffset = $target.offset().top;
        jQuery('html,body')
        .animate({scrollTop: targetOffset}, 700);
       return false;
      }
    }
  });
}


function kriesi_tab(wrapper, header, content){
    jQuery(".widget_block").removeClass("tablist");
	jQuery(".nowidget").addClass("tablist");
    
	var title = wrapper + " " + header;
	var container_to_hide = wrapper + " " + content;
	disable = false;
	

jQuery(title).css({display: "none"}).each(
					  function(i){
						 if (i == 0){
						jQuery(wrapper).prepend("<a href='/' class='widgettitle advanced_link active'>"+jQuery(this).html()+"</a>");
							}else{
						jQuery(".advanced_link:last").after("<a href='/'class='widgettitle advanced_link'>"+jQuery(this).html()+"</a>");
							}
						 }
					  );

jQuery(container_to_hide).each(
						 function(i){
						jQuery(this).addClass("tablist list_"+i); 
							if(i != 0){
								jQuery(this).css({display: "none"});
							}
						  }
					 );

jQuery(".advanced_link").each(
					  function(i){
						jQuery( this ).bind ("click",function(){
												if(jQuery(this).hasClass('active')){return false}
														 if(disable == false){disable = true;
														 jQuery(".advanced_link").removeClass("active");
														 jQuery(this).addClass("active");
														 jQuery(container_to_hide+":visible").slideUp(400,function(){
																	jQuery(".list_"+i).slideDown(400, function(){disable=false; });
																								   });
														 }
														 return false;

														 });
						  }
					  );
}



function kriesi_mainmenu(){
jQuery(" #nav ul ").css({display: "none"}); // Opera Fix
jQuery(" #nav li").hover(function(){
		jQuery(this).find('ul:first:hidden').css({visibility: "visible",display: "none"}).fadeIn(400);
		},function(){
		jQuery(this).find('ul:first').css({visibility: "hidden"});
		});
}

function kriesi_rss_hover(){
jQuery(".rssfeed a").append("<span></span>");
jQuery(".rssfeed a").hover(function(){
		jQuery(this).find('span:hidden').fadeIn(400);
		},function(){
		jQuery(this).find('span').fadeOut(400);
		});	
	
	}
	
function kriesi_search_fade(){

jQuery(".search_js a").click(function(){
		if ( jQuery(this).hasClass("activesearchbar"))	{
		jQuery(".headersearch").animate({bottom:"25px",
										 right:"20px",
										 opacity:0
										},400, "swing", function(){
											jQuery(".activesearchbar").removeClass("activesearchbar");
											});
		return false;	
			
			}	else {				  
		jQuery(".headersearch").animate({bottom:"55px",
										 right:"147px",
										 opacity:1
										},400, "swing", function(){
											jQuery(".search_js a:not(.activesearchbar)").addClass("activesearchbar");
											});
		return false;
		
			}
		});	
	
	}


function kriesi_noscript(){
	jQuery("#nav a").removeAttr('title');

	
	jQuery(".prev_image a").append("<span class='gloss'></span>");
    $content =jQuery(".widget_rss h3 a:eq(1)").html();
    jQuery(".widget_rss h3 a").remove();
    jQuery(".widget_rss h3").append($content);
	}
	
	

function kriesi_tooltip(selector, selectname, atrribute){
jQuery(selector).each(function(i){
			if (jQuery(this).attr(atrribute) != ""){
				
			jQuery("body").append("<div class='"+selectname+"' id='"+selectname+i+"'><div><img class='tooltipimg' src='"+jQuery(this).attr(atrribute)+"' alt='' /></div><span><img src='<?php echo $templateurl; ?>/images/tooltip-trans.png' alt='' /></span></div>");
			
			jQuery(this).removeAttr(atrribute).mouseover(function(e){
					jQuery("#"+selectname+i).css({display:"none", visibility:"visible"}).fadeIn(400);
			}).mousemove(function(e){
					jQuery("#"+selectname+i).css({left:e.pageX+35, top:e.pageY+35});
			}).mouseout(function(){
					jQuery("#"+selectname+i).css({display:"none", visibility:"hidden"});				  
			});
			
			
			}
		});
 	}
	
function kriesi_tooltip2(selector, selectname, atrribute){
jQuery(selector).each(function(i){
			if (jQuery(this).attr(atrribute) != ""){
			jQuery("body").append("<div class='"+selectname+"' id='"+selectname+i+"'>"+jQuery(this).attr(atrribute)+"</div>");
			
			jQuery(this).removeAttr(atrribute).mouseover(function(e){
					jQuery("#"+selectname+i).css({opacity:0.85, display:"none", visibility:"visible"}).animate({"padding": "9px"}, 800).fadeIn(800);
			}).mousemove(function(e){
					jQuery("#"+selectname+i).css({left:e.pageX+14, top:e.pageY+14});
			}).mouseout(function(){
					jQuery("#"+selectname+i).css({display:"none", visibility:"hidden"});				  
			});
			
			
			}
		});
 	}
	
function kriesi_footer(){
    jQuery(".headersearch").css({opacity:0});
    jQuery(".jshide").removeClass('jshide');
	var footer = jQuery(".footer").html();
	jQuery(".footer").remove();
	jQuery("#head").after("<div class='footer advanced_footer'><div class='footer_bg'>"+ footer +"</div></div>");
	
	jQuery('#submenu .options a').click(function(){
												  
	  jQuery(".advanced_footer").slideToggle("slow");
	  jQuery(this).toggleClass("active"); 
	  
	  return false;
	 
	});

	}

jQuery(document).ready(function(){
	kriesi_noscript();
	kriesi_rss_hover();
	kriesi_search_fade();
	kriesi_mainmenu();
    <?php if ($smoothscrolling) echo	"my_smothscroll();"; ?>
    <?php if ($toolimg) echo	"kriesi_tooltip('.prev_image a', 'tooltip_image', 'rel');"; ?>
    <?php if ($tooltitle) echo	"kriesi_tooltip2('a', 'tooltip_image2', 'title');"; ?>
    <?php if ($tabs) echo "kriesi_tab('.widget_block','.widgettitle','.widget');";?>
    <?php if ($footer) echo "kriesi_footer();";?>
});

