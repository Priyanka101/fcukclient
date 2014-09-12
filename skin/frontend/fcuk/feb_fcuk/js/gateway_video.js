jQuery( document ).ready(function() {

// JW PLAYER
var video_hidden = 0;

jwplayer.key="dJvwQTHn9ZyAP4PZJu3bVhKZ5k09ohdFDwa7eHG1IrA=";
//$(function() {


jQuery(".watch-video-desktop").click(function(){
  playHPVideo();
});

function playHPVideo(){

  //if (Modernizr.mq('only screen and (min-width: 801px)')) {
  //if(!$('html').hasClass('touch')){

    var w_height = jQuery(window).height()-67;
    var w_width = jQuery(window).width();

    jwplayer("jw-video").setup({
      'playlist': [{
          sources: [
              { file: "http://cdn1.multichanneltv.com/french_connection/fre009/fre00902/videos/fre00902_992_600_2602.webm", label: "360p" },
              { file: "http://cdn1.multichanneltv.com/french_connection/fre009/fre00902/videos/fre00902_992_600_2602.ogv", label: "720p HD" },
              { file: "http://cdn1.multichanneltv.com/french_connection/fre009/fre00902/videos/fre00902_992_750_2602.f4v", label: "720p HD" },
              { file: "http://cdn1.multichanneltv.com/french_connection/fre009/fre00902/videos/fre00902_992_600_2602.mp4", label: "720p HD" }
          ]
          ,'image': 'http://www.frenchconnection.com/stormsites/fcuk/images/aw14/homepage/gateway/opening_still_2.jpg'
      }],
      height: w_height,
      width : "100%",
      //aspectratio: "16:9",
      stretching: "fill",
      'autostart': 'true',
      'controls': 'false',
      mute: true,
      events:{
        onComplete: function() {

            jQuery('.banner_awlaunch').removeClass("hidetrans");

            if( jwplayer().getState()=='PLAYING' ){
              jQuery('#video-controls .play').removeClass("btn-off");
               jwplayer().stop();
            };

            video_hidden=1;

            jQuery('.video_element').addClass("hidethis");

        },
        onPlay: function() {

            jQuery('#video-controls .play').toggleClass("btn-off");
            jQuery('.video_element').removeClass("hidethis");

            jQuery('.banner_awlaunch').addClass("hidetrans");
            //$('#homepage_wrapper').removeClass("pageload");


        },
        onPause: function() {
            jQuery('#video-controls .play').toggleClass("btn-off");
        },
        onMute: function() {
            jQuery('#video-controls .mute').toggleClass("btn-off");
        }
      }

    });

    jQuery(window).resize(function(e) {
        var new_w_height = jQuery(window).height()-67;
        var new_w_width = jQuery(window).width();
        var new_w_width = "100%";
        jwplayer("jw-video").resize(new_w_width, new_w_height);
    });

  //}

};


      jQuery(function() {

          jQuery('.skip').click(function(){

              jQuery('.banner_awlaunch').removeClass("hidetrans");

              if( jwplayer().getState()=='PLAYING' ){
                jQuery('#video-controls .play').removeClass("btn-off");
                 jwplayer().stop();
              };
              video_hidden=1;

              jQuery('.video_element').addClass("hidethis");

          });

      });

});