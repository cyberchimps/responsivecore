// JavaScript Document
jQuery(document).ready(function ($) {
    

	$(".rwd-container").hide();

	$("h3.rwd-toggle").click(function () {
		$(this).toggleClass("active").next().slideToggle("fast");
		return false; //Prevent the browser jump to the link anchor
	});

});
jQuery(document).ready(function ($) {
	setTimeout(function () {
		$(".fade").fadeOut("slow", function () {
			$(".fade").remove();
		});

	}, 2000);
});
// Image Full width template
jQuery(document).ready(function ($) {
    $selected_layout = $(".responsive_layouts").val();
    if($selected_layout === 'full-width-image')
    {
    $('.home_banner').show();
    $('.home_banner_field').show();
    $('.res_featured_content_area').hide();
    $('.featured_content_field').hide();
    }
    else
    {
    $('.home_banner').hide();
    $('.home_banner_field').hide();
     $('.res_featured_content_area').show();
    $('.featured_content_field').show();
    }
    
    $( ".responsive_layouts" ).change(function() {
       
    $current_layout = $(this).val();
     
     if($current_layout === 'full-width-image')
     {
         $('.res_featured_content_area').hide();
         $('.featured_content_field').hide();
         $('.home_banner').show();
         $('.home_banner_field').show();
     }
     else
     {
          $('.res_featured_content_area').show();
         $('.featured_content_field').show();
         $('.home_banner').hide();
         $('.home_banner_field').hide();
     }
     });
 });