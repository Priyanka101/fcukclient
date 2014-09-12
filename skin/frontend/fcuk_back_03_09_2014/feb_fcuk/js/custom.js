function rotate(i,max){
  jQuery(".hp_slide").not("#hp_slide_" + i).fadeOut(800);
  jQuery("#hp_slide_" + i).fadeIn(1500,function(){
    if(i==max){
      setTimeout(function() {
        rotate(1,max);
      }, 3000);
    }else{
      i++;
      rotate(i,max);
    }
  });
}

function rotate_imagbox(i,max){
  jQuery(".image_box").not("#image_box_" + i).fadeOut(800);
  jQuery("#image_box_" + i).fadeIn(1500,function(){
    if(i==max){
      rotate_imagbox(1,max);
    }else{
      i++;
      rotate_imagbox(i,max);
    }
  });
}

// jQuery(document).ready(function(){    
//   //alert("hello");
//   jQuery(".right-slider-wrapper").css({"height":"200px","float":"right"});
//   jQuery(".wp-custom-menu-popup").css("display","none");

//   // Hover Effects on Home and Subscribe link Starts
//   jQuery(".home-link > div").css("display", "none");
//   jQuery(".home-link").hover(function(){
//     jQuery(".home-link > div").stop(true,true).fadeToggle(500);
//   });

//   jQuery(".subscribe-link > div").css("display", "none");
//   jQuery(".subscribe-link").hover(function(){
//     jQuery(".subscribe-link > div").stop(true,true).fadeToggle(500);
//   });
//   // Hover Effects on Home and Subscribe link Ends
// })

jQuery(document).ready(function($){ 
  

  

  /*function goToByScroll(id){
    // Remove "link" from the ID
  id = id.replace("link", "");
    // Scroll
  $('html,body').animate({
    scrollTop: $("#"+id).offset().top},
    'slow');
  }*/

  /*$(".section > div").click(function(e) { 
    // Prevent a page reload when a link is pressed
  e.preventDefault(); 
    // Call the scroll function
  goToByScroll($(this).attr("id"));           
  });*/
  // $("#section1").click(function(e){
  //  alert("enter");
  //  $("#fancybox").fancybox();
  //  e.preventDefault();
  // });
  
    $("a.fancybox").fancybox({
      "padding":0,
      "overlayColor": "#000",
    "overlayOpacity": 0.7,
    "hideOnOverlayClick": true,
    "width": 800,
    "height": 500,
    "autoResize": true 
    }); 
  
    $(".col-left").hide();
    if ($('body').hasClass("cms-page-view") || $('body').hasClass("customer-account-index") || $('body').hasClass("customer-account-edit") || $('body').hasClass("customer-address-index") || $('body').hasClass("customer-address-form") || $('body').hasClass("sales-order-history") || $('body').hasClass("sales-billing-agreement-index") || $('body').hasClass("sales-recurring-profile-index") || $('body').hasClass("review-customer-index") || $('body').hasClass("tag-customer-index") || $('body').hasClass("wishlist-index-index") || $('body').hasClass("oauth-customer-token-index") || $('body').hasClass("newsletter-manage-index") || $('body').hasClass("downloadable-customer-products") || $('body').hasClass("giftcards-customer-balance")) {
      $(".col-left").show();
    }
     var minusImg = true;
    //$(".col-left").hide();
    $("#faceted_search_container").click(function(){
        if(minusImg) {
            $("#faceted_search_menuToggle").addClass('activeDiv');
            minusImg = false;
        } else {
            $("#faceted_search_menuToggle").removeClass('activeDiv');
            minusImg = true;
        }
        $(".col-left").stop(true, true).slideToggle('fast');
    
    });
    var find_block = $(".main").find(".category-description").html();
    if(!find_block)
    {
        $(".catalog-category-view .sidebar .block-layered-nav").addClass("marg-top");
    }




});

jQuery(document).ready(function($){
    

    $(".products-grid li.item").live({
        mouseenter: function (e) {
            //stuff to do on mouse enter
            e.stopImmediatePropagation();
            $(this).find('.stock-container').fadeIn('fast');
            $(this).find('.commingsoon-list').fadeIn('fast');   
            $(this).find('.quick_view3 a').fadeIn('fast');
            $(this).find('.quick-btn a').fadeIn('fast');
            $(this).find('.actions').fadeIn('fast');
            $(this).find('.category_product_rollover_container').fadeIn('fast');
        },
        mouseleave: function (e) {
            //stuff to do on mouse leave
            e.stopImmediatePropagation();
            $(this).find('.stock-container').fadeOut('fast');
            $(this).find('.commingsoon-list').fadeOut('fast');      
            $(this).find('.quick_view3 a').fadeOut('fast');
            $(this).find('.quick-btn a').fadeOut('fast');
            $(this).find('.actions').fadeOut('fast');
            $(this).find('.category_product_rollover_container').fadeOut('fast');
        }
    });

    /*$(document).on('mouseout','.products-grid li.item',function(e){
        
    });*/
});


jQuery(document).ready(function($){

    $(this).find('.commingsoon-list').hide();
    $(this).find('.quick_view3 a').hide();
    $(this).find('.quick-btn a').hide();
    $(this).find('.category_product_rollover_container').hide();
    // load modified css file if category image and description exist
    var perform_category_check_img = $('.current_cat_img').val();
    var perform_category_check_desc = $('.current_cat_desc').val();
    var mod_css_path = '<?php echo $this->getSkinUrl(); ?>' + 'css/detailed_category.css';
    
    if (perform_category_check_img == 1) {
        if (document.createStyleSheet){
            document.createStyleSheet(mod_css_path);
        }
        else {
            $("head").append($("<link rel='stylesheet' href='" + mod_css_path + "' type='text/css' media='all' />"));
        }
    }
        
    // load category description
    function cat_desc_reposition() {
        if($('.category-image').offset()) {
            var cat_image_offset = $('.category-image').offset();
            var cat_desc_offset_left = cat_image_offset.left + 665;
            var cat_desc_height = $('.category-description').height();
            var cat_image_height = $('.category-image').height(); 
            var cat_desc_offset_top = cat_image_offset.top + (cat_image_height - cat_desc_height) * 0.5 - 16;
            
            $('.category-description').css({
                left : cat_desc_offset_left,
                top : cat_desc_offset_top
            });
            
            $('.category-description').show();
        
        }
    }
    var delay_desc = setTimeout(function() {
        cat_desc_reposition();
    }, 3000);
    
    
    $(window).resize(cat_desc_reposition);
    
    
    /*$('.products-grid li.item').hover(function(e){
        e.stopImmediatePropagation();
        $(this).find('.stock-container').fadeIn('fast');
        console.log($(this).find('.stock-container'));
        $(this).find('.commingsoon-list').fadeIn('fast');       
        $(this).find('.quick_view3 a').fadeIn('fast');
        $(this).find('.quick-btn a').fadeIn('fast');
        $(this).find('.category_product_rollover_container').fadeIn('fast');
        //$(this).find('.quick-btn a').stop().animate({
        // left:'0px'
        // },'fast')
    },function(e){
        e.stopImmediatePropagation();
        $(this).find('.stock-container').fadeOut('fast');
        $(this).find('.commingsoon-list').fadeOut('fast');      
        $(this).find('.quick_view3 a').fadeOut('fast');
        $(this).find('.quick-btn a').fadeOut('fast');
        $(this).find('.category_product_rollover_container').fadeOut('fast');
        // $(this).find('.quick-btn a').stop().animate({
        // left:'-175px'
        // },'fast')

        });*/
        
    // $('.quick_view').fancybox({
    //     'height': 550,
    //     'width': 900,
    //     'type': 'iframe',
    //     onComplete: function() { 
    //         $.fancybox.showActivity();
    //         $('#fancybox-frame').unbind('load');
    //         $('#fancybox-frame').bind('load', function() {
    //                 $.fancybox.hideActivity();
    //         });
    //     }
    // });

    jQuery('.quick_view').live('click', function(event) {
        jQuery.fancybox( {href : $(this).attr('href'), 'height': 500,
                'width': 900,
                'type'  : 'iframe'} );
        event.preventDefault();
    });
    
    
    /*
    $('.quick_view2').fancybox({
        'frameWidth': 0,
        'type'              : 'iframe',
        onComplete: function() { 
            $.fancybox.showActivity();
            //var ac=$('.request-product').val();
            //alert(ac);
            $('#fancybox-frame').unbind('load');
            $('#fancybox-frame').bind('load', function() {
                    $.fancybox.hideActivity();
            });
        }
    });*/
    
    jQuery('.request-product').live('click', function(event) {
        jQuery.fancybox( {href : $(this).attr('href'), 'height': 400,
                'width': 620,
                'type'  : 'iframe'} );
        event.preventDefault();
    });
    
    //  $('.request-product').fancybox({
    //             'height': 400,
    //             'width': 620,
    //             'type'  : 'iframe',

    //     onComplete: function() { 
    //     //alert("i m here");
    //         $.fancybox.showActivity();
    //         $('#fancybox-frame').unbind('load');
    //         $('#fancybox-frame').bind('load', 
    //         function() {
    //                 $.fancybox.hideActivity();
    //         });
    //     }
    // }); 
    
});
    function showOverlay(obj, sku){
      var abc=jQuery('.productid').val();
      }
    function newpopup(data){
        jQuery('.popup_final_slider').html(data);
    }

