<?php
/**
 * Graphy functions and definitions
 *
 * @package Graphy
 */

/**
 * Set the content width based on the theme's design and stylesheet.
 */
if ( ! isset( $content_width ) ) {
  $content_width = 700; /* pixels */
}

if ( ! function_exists( 'graphy_setup' ) ) :
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function graphy_setup() {

  /*
   * Make theme available for translation.
   * Translations can be filed in the /languages/ directory.
   * If you're building a theme based on Graphy, use a find and replace
   * to change 'graphy' to the name of your theme in all the template files
   */
  load_theme_textdomain( 'graphy', get_template_directory() . '/languages' );

  // Add default posts and comments RSS feed links to head.
  add_theme_support( 'automatic-feed-links' );

  /*
   * Switches default core markup for search form, comment form,
   * and comments to output valid HTML5.
   */
  add_theme_support( 'html5', array( 'search-form', 'comment-form', 'comment-list' ) );

  /*
   * Enable support for Post Thumbnails on posts and pages.
   *
   * @link http://codex.wordpress.org/Function_Reference/add_theme_support#Post_Thumbnails
   */
  add_theme_support( 'post-thumbnails' );
  set_post_thumbnail_size( 800 );
  add_image_size( 'graphy-page-thumbnail', 1500, 530, true );

  // This theme uses wp_nav_menu() in one location.
  register_nav_menus( array(
    'primary' => __( 'Primary Menu', 'graphy' ),
  ) );

  // Enable support for Post Formats.
  add_theme_support( 'post-formats', array( 'aside', 'audio', 'chat', 'gallery', 'image', 'link', 'quote', 'status', 'video' ) );

  // Setup the WordPress core custom header feature.
  add_theme_support( 'custom-header', apply_filters( 'graphy_custom_header_args', array(
    'default-image' => '',
    'width'         => 1500,
    'height'        => 530,
    'flex-height'   => false,
    'header-text'   => false,
  ) ) );

  // This theme styles the visual editor to resemble the theme style.
  add_editor_style( array( 'css/editor-style.css', graphy_fonts_url() ) );

  // This theme uses its own gallery styles.
  add_filter( 'use_default_gallery_style', '__return_false' );
}
endif; // graphy_setup
add_action( 'after_setup_theme', 'graphy_setup' );

//[myjavascript]
function myjavascript_func( $atts ){
 return "<script>
      var element = document.createElement('div');
      element.className = 'container-hover-img';
      element.style.textAlign = 'center';
      element.style.verticalAlign = 'middle';
      document.body.appendChild(element);
      jQuery('.entry-content img').hover(function() {
        element.innerHTML = '<div style=\"margin-top:70%;color:black;text-decoration:underline;font-style:italic;font-size:30px\"><a href=\"'+jQuery(this).parent().attr(\"href\")+'\"> '+jQuery(this).attr('alt')+'</a></div>';
        jQuery('.container-hover-img').css('top',jQuery(this).position().top);
        jQuery('.container-hover-img').css('left',jQuery(this).position().left);
        jQuery('.container-hover-img').css('width',jQuery(this).width());
        jQuery('.container-hover-img').css('height',jQuery(this).height());
        jQuery('.container-hover-img').stop().css('display', 'block');

        jQuery('.container-hover-img').click(function(){
          window.location.replace(jQuery('.container-hover-img a').prop('href'));
        });
      });


    </script>";
}
add_shortcode( 'myjavascript', 'myjavascript_func' );


function faqScript_func( $atts ){
 return "<script>
      jQuery('.underlineFaq').click(function() {
          jQuery('.underlineFaq').removeClass('underline');
          jQuery(this).addClass('underline');
      });

    </script>";
}
add_shortcode( 'faqsScript', 'faqScript_func' );

//[myjavascript2]

/*Community dsnv start*/

function myjavascript2_func( $atts ){
  
 return "<script>

      var idGallery = $('.vimeography-bugsauce').prop('id').split('vimeography-gallery-')[1];
      var gallery = $('#vimeography-gallery-'+idGallery);
      var element = document.createElement('div');
      element.className = 'container-hover-img';
      element.style.textAlign = 'center';
      element.style.verticalAlign = 'middle';
      element.innerHTML = '<div class=\"subcontainer-hover\"></div>';
      document.body.appendChild(element);

      jQuery('.divLeft').hover(function() {
        element.dataset.link=jQuery(this).data('link');
        element.dataset.description=jQuery(this).data('description');
        element.dataset.name=jQuery(this).data('name');

        element.innerHTML = '<div class=\"subcontainer-hover\"  style=\"position: relative;top: 50%;transform: translateY(-50%);color:black;text-decoration:underline;font-style:italic;font-size:30px\">'+jQuery(this).data('name')+'</div>';
        jQuery('.container-hover-img').css('top',jQuery(this).position().top+$('.vimeography-thumbnails').position().top);
        jQuery('.container-hover-img').css('left',jQuery(this).position().left+$('.vimeography-thumbnails').position().left);
        jQuery('.container-hover-img').css('width',jQuery(this).width());
        jQuery('.container-hover-img').css('height',jQuery(this).height());
        jQuery('.container-hover-img').stop().css('display', 'block');
      

      });
    
      
    jQuery('.container-hover-img').on('click', '.subcontainer-hover',  function(e) {

            var parent = $('.subcontainer-hover').parent();
            if ($(parent).data('name') != undefined){
              
               
                gallery.find('.vimeography-main').spin('custom');
                var link = $(parent).data('link');
                var description = $(parent).data('description');
                var name = $(parent).data('name');
                $('.vimeography-bugsauce-active-slide').removeClass('vimeography-bugsauce-active-slide');
                $(parent).addClass('vimeography-bugsauce-active-slide');
                
                 gallery.find('.vimeography-player').animate({'opacity':0}, 300, 'linear', function(){

                  var promise = vimeography.utilities.get_video( link );

                  promise.done(function (video) {
                    // This needs to be done so that the Vimeo API can interact with the player
                    video.html = vimeography.utilities.set_video_id(video.html);
                  gallery.find('.vimeography-player').html(video.html).fitVids().animate({'opacity':1}, 300);
                  $('.vimeography-description').html('<h1 class=\"uppercase\">'+name+'</h1><p>'+description+'</p>');

                    gallery.find('.vimeography-main').spin(false);
                    gallery.trigger('vimeography/video/ready');
                  });

                });
                $( 'body' ).scrollTop( 300 );
                jQuery('.container-hover-img').css('top',1000000000);
                e.preventDefault();
            }
          });  
  

     jQuery('.container-hover-img').click(function(e) {
            if (e.target.dataset.name != undefined){
               $( 'body' ).scrollTop( 300 );
                gallery.find('.vimeography-main').spin('custom');
                var link = e.target.dataset.link;
                var description = e.target.dataset.description;
                var name = e.target.dataset.name;
                $('.vimeography-bugsauce-active-slide').removeClass('vimeography-bugsauce-active-slide');
                $(this).addClass('vimeography-bugsauce-active-slide');
                
                 gallery.find('.vimeography-player').animate({'opacity':0}, 300, 'linear', function(){

                  var promise = vimeography.utilities.get_video( link );

                  promise.done(function (video) {
                    // This needs to be done so that the Vimeo API can interact with the player
                    video.html = vimeography.utilities.set_video_id(video.html);
                  gallery.find('.vimeography-player').html(video.html).fitVids().animate({'opacity':1}, 300);
                  $('.vimeography-description').html('<h1 class=\"uppercase\">'+name+'</h1><p>'+description+'</p>');

                    gallery.find('.vimeography-main').spin(false);
                    gallery.trigger('vimeography/video/ready');
                  });

                });

                jQuery('.container-hover-img').css('top',1000000000);
                e.preventDefault();
            }
          });
      
     
    </script>";
}
add_shortcode( 'myjavascript2', 'myjavascript2_func' );


function communityScript_func( $atts ){
 return "<script>
      jQuery('.changeFrameSelect').change(function(){
          jQuery('.frame').addClass('hide');
          jQuery('.frame_'+jQuery(this).val()).removeClass('hide');
      });

      jQuery('.btnViewAll').click(function(){
          jQuery('.frame').removeClass('hide');
      });

      jQuery('.chooseFrameSelect').hover(function(){
          var auxTop  = jQuery('.chooseFrameSelect').position().top + 30;
          var auxLeft = jQuery('.chooseFrameSelect').position().left - 21;
          jQuery('.select290').css('left', auxLeft);
          jQuery('.select290').css('top', auxTop);
      }, function() {
        jQuery('.select290').css('left', '-9999px');
          
      });

      jQuery('.select290').hover(function(){
          var auxTop  = jQuery('.chooseFrameSelect').position().top + 30;
          var auxLeft = jQuery('.chooseFrameSelect').position().left-21;
          jQuery('.select290').css('left', auxLeft);
          jQuery('.select290').css('top', auxTop);
      }, function() {
        jQuery('.select290').css('left', '-9999px');
          
      });

      jQuery('.chooseColorSelect').hover(function(){
          var auxTop  = jQuery('.chooseColorSelect').position().top + 30;
          var auxLeft = jQuery('.chooseColorSelect').position().left - 21;
          jQuery('.color290').css('left', auxLeft);
          jQuery('.color290').css('top', auxTop);
      }, function() {
        jQuery('.color290').css('left', '-9999px');
          
      });

      jQuery('.color290').hover(function(){
          var auxTop  = jQuery('.chooseColorSelect').position().top + 30;
          var auxLeft = jQuery('.chooseColorSelect').position().left-21;
          jQuery('.color290').css('left', auxLeft);
          jQuery('.color290').css('top', auxTop);
      }, function() {
        jQuery('.color290').css('left', '-9999px');
          
      });
    
    </script>";
}
add_shortcode( 'communityScript', 'communityScript_func' );


function communityDNVFunction() {
  ob_start();
    $args = array( 'post_type' => 'communityDNV', 'posts_per_page' => 10 );
    $loop = new WP_Query( $args );
    
    echo '<ul class="packSelect290"><li><a class="chooseFrameSelect" href="javascript:;">Choose Frame</a><ul class="select290 changeFrameSelect"></li>';
    echo '<li><a>KUALA LUMPUR</a></li><li><a>MONTECARLO</a></li><li><a>DETROIT</a></li><li><a>HOUSTON</a></li>';
    echo '<li><a>BARCELONA</a></li><li><a>TOKYO</a></li><li><a>EDINBURGH</a></li><li><a>SEOUL</a></li>';
    echo '<li><a>COPENHAGEN</a></li><li><a>STUTTGART</a></li><li><a>VERONA</a></li></ul></li>';

    echo '<li><a class="chooseColorSelect" href="javascript:;">Choose Color</a><ul class="color290">';
    echo '<li><a>REGULAR COLOR 2015</a></li><li><a>CUSTOM COLOR</a></li>';
    echo '<li><div>';
    echo '<div id="colorPicker_palette-0" class="colorPicker-palette" style="display: block; top: 631px; left: 311px;"><div class="colorPicker-swatch"';
    echo 'style="background-color: rgb(190, 189, 127);">&nbsp;</div><div class="colorPicker-swatch" style="background-color: rgb(194, 176, 120);">&nbsp;</div>';
    echo '<div class="colorPicker-swatch" style="background-color: rgb(198, 166, 100);">&nbsp;</div><div class="colorPicker-swatch" style="background-color: rgb(229, 190, 1);">&nbsp;</div>';
    echo '<div class="colorPicker-swatch" style="background-color: rgb(205, 164, 52);">&nbsp;</div><div class="colorPicker-swatch" style="background-color: rgb(169, 131, 7);">&nbsp;</div>';
    echo '<div class="colorPicker-swatch" style="border-color: rgb(0, 0, 0); background-color: rgb(228, 160, 16);">&nbsp;</div><div class="colorPicker-swatch" style="background-color: rgb(220, 157, 0);">';
    echo '&nbsp;</div><div class="colorPicker-swatch" style="background-color: rgb(138, 102, 66);">&nbsp;</div><div class="colorPicker-swatch" style="background-color: rgb(199, 180, 70);">&nbsp;</div>';
    echo '<div class="colorPicker-swatch" style="background-color: rgb(234, 230, 202);">&nbsp;</div><div class="colorPicker-swatch" style="background-color: rgb(225, 204, 79);">&nbsp;</div><div class="colorPicker-swatch" style="background-color: rgb(230, 214, 144);">&nbsp;</div><div class="colorPicker-swatch" style="background-color: rgb(237, 255, 33);">&nbsp;</div><div class="colorPicker-swatch" style="background-color: rgb(245, 208, 51);">&nbsp;</div><div class="colorPicker-swatch" style="background-color: rgb(248, 243, 43);">&nbsp;</div><div class="colorPicker-swatch" style="background-color: rgb(158, 151, 100);">&nbsp;</div><div class="colorPicker-swatch" style="background-color: rgb(153, 153, 80);">&nbsp;</div><div class="colorPicker-swatch" style="background-color: rgb(243, 218, 11);">&nbsp;</div><div class="colorPicker-swatch" style="background-color: rgb(250, 210, 1);">&nbsp;</div><div class="colorPicker-swatch" style="background-color: rgb(174, 160, 75);">&nbsp;</div><div class="colorPicker-swatch" style="background-color: rgb(255, 255, 0);">&nbsp;</div><div class="colorPicker-swatch" style="background-color: rgb(157, 145, 1);">&nbsp;</div><div class="colorPicker-swatch" style="border-color: rgb(0, 0, 0); background-color: rgb(244, 169, 0);">&nbsp;</div><div class="colorPicker-swatch" style="background-color: rgb(214, 174, 1);">&nbsp;</div><div class="colorPicker-swatch" style="background-color: rgb(243, 165, 5);">&nbsp;</div><div class="colorPicker-swatch" style="background-color: rgb(239, 169, 74);">&nbsp;</div><div class="colorPicker-swatch" style="background-color: rgb(106, 93, 77);">&nbsp;</div><div class="colorPicker-swatch" style="background-color: rgb(112, 83, 53);">&nbsp;</div><div class="colorPicker-swatch" style="background-color: rgb(243, 159, 24);">&nbsp;</div><div class="colorPicker-swatch" style="background-color: rgb(201, 60, 32);">&nbsp;</div><div class="colorPicker-swatch" style="background-color: rgb(203, 40, 33);">&nbsp;</div><div class="colorPicker-swatch" style="background-color: rgb(255, 117, 20);">&nbsp;</div><div class="colorPicker-swatch" style="background-color: rgb(244, 70, 17);">&nbsp;</div><div class="colorPicker-swatch" style="border-color: rgb(0, 0, 0); background-color: rgb(255, 35, 1);">&nbsp;</div><div class="colorPicker-swatch" style="background-color: rgb(255, 164, 32);">&nbsp;</div><div class="colorPicker-swatch" style="background-color: rgb(247, 94, 37);">&nbsp;</div><div class="colorPicker-swatch" style="background-color: rgb(245, 64, 33);">&nbsp;</div><div class="colorPicker-swatch" style="background-color: rgb(216, 75, 32);">&nbsp;</div><div class="colorPicker-swatch" style="background-color: rgb(236, 124, 38);">&nbsp;</div><div class="colorPicker-swatch" style="border-color: rgb(0, 0, 0); background-color: rgb(229, 81, 55);">&nbsp;</div><div class="colorPicker-swatch" style="background-color: rgb(195, 88, 49);">&nbsp;</div><div class="colorPicker-swatch" style="background-color: rgb(165, 32, 25);">&nbsp;</div><div class="colorPicker-swatch" style="background-color: rgb(162, 35, 29);">&nbsp;</div><div class="colorPicker-swatch" style="background-color: rgb(155, 17, 30);">&nbsp;</div><div class="colorPicker-swatch" style="background-color: rgb(117, 21, 30);">&nbsp;</div><div class="colorPicker-swatch" style="background-color: rgb(94, 33, 41);">&nbsp;</div><div class="colorPicker-swatch" style="background-color: rgb(65, 34, 39);">&nbsp;</div><div class="colorPicker-swatch" style="background-color: rgb(100, 36, 36);">&nbsp;</div><div class="colorPicker-swatch" style="background-color: rgb(120, 31, 25);">&nbsp;</div><div class="colorPicker-swatch" style="border-color: rgb(0, 0, 0); background-color: rgb(193, 135, 107);">&nbsp;</div><div class="colorPicker-swatch" style="background-color: rgb(161, 35, 18);">&nbsp;</div><div class="colorPicker-swatch" style="background-color: rgb(211, 110, 112);">&nbsp;</div><div class="colorPicker-swatch" style="background-color: rgb(234, 137, 154);">&nbsp;</div><div class="colorPicker-swatch" style="background-color: rgb(179, 40, 33);">&nbsp;</div><div class="colorPicker-swatch" style="background-color: rgb(230, 50, 68);">&nbsp;</div><div class="colorPicker-swatch" style="background-color: rgb(213, 48, 50);">&nbsp;</div><div class="colorPicker-swatch" style="border-color: rgb(0, 0, 0); background-color: rgb(204, 6, 5);">&nbsp;</div><div class="colorPicker-swatch" style="background-color: rgb(217, 80, 48);">&nbsp;</div><div class="colorPicker-swatch" style="background-color: rgb(248, 0, 0);">&nbsp;</div><div class="colorPicker-swatch" style="background-color: rgb(197, 29, 52);">&nbsp;</div><div class="colorPicker-swatch" style="background-color: rgb(203, 50, 52);">&nbsp;</div><div class="colorPicker-swatch" style="background-color: rgb(179, 36, 40);">&nbsp;</div><div class="colorPicker-swatch" style="background-color: rgb(146, 43, 62);">&nbsp;</div><div class="colorPicker-swatch" style="background-color: rgb(222, 76, 138);">&nbsp;</div><div class="colorPicker-swatch" style="background-color: rgb(100, 28, 52);">&nbsp;</div><div class="colorPicker-swatch" style="background-color: rgb(108, 70, 117);">&nbsp;</div><div class="colorPicker-swatch" style="background-color: rgb(160, 52, 114);">&nbsp;</div><div class="colorPicker-swatch" style="background-color: rgb(74, 25, 44);">&nbsp;</div><div class="colorPicker-swatch" style="background-color: rgb(146, 78, 125);">&nbsp;</div><div class="colorPicker-swatch" style="background-color: rgb(161, 133, 148);">&nbsp;</div><div class="colorPicker-swatch" style="background-color: rgb(207, 52, 118);">&nbsp;</div><div class="colorPicker-swatch" style="background-color: rgb(31, 52, 56);">&nbsp;</div><div class="colorPicker-swatch" style="background-color: rgb(32, 33, 79);">&nbsp;</div><div class="colorPicker-swatch" style="border-color: rgb(0, 0, 0); background-color: rgb(29, 30, 51);">&nbsp;</div><div class="colorPicker-swatch" style="border-color: rgb(0, 0, 0); background-color: rgb(24, 23, 28);">&nbsp;</div><div class="colorPicker-swatch" style="background-color: rgb(30, 36, 96);">&nbsp;</div><div class="colorPicker-swatch" style="background-color: rgb(62, 95, 138);">&nbsp;</div><div class="colorPicker-swatch" style="background-color: rgb(38, 37, 45);">&nbsp;</div><div class="colorPicker-swatch" style="background-color: rgb(2, 86, 105);">&nbsp;</div><div class="colorPicker-swatch" style="background-color: rgb(14, 41, 75);">&nbsp;</div><div class="colorPicker-swatch" style="background-color: rgb(35, 26, 36);">&nbsp;</div><div class="colorPicker-swatch" style="background-color: rgb(59, 131, 189);">&nbsp;</div><div class="colorPicker-swatch" style="background-color: rgb(30, 33, 61);">&nbsp;</div><div class="colorPicker-swatch" style="background-color: rgb(96, 110, 140);">&nbsp;</div><div class="colorPicker-swatch" style="background-color: rgb(34, 113, 179);">&nbsp;</div><div class="colorPicker-swatch" style="background-color: rgb(6, 57, 113);">&nbsp;</div><div class="colorPicker-swatch" style="background-color: rgb(63, 136, 143);">&nbsp;</div><div class="colorPicker-swatch" style="background-color: rgb(27, 85, 131);">&nbsp;</div><div class="colorPicker-swatch" style="background-color: rgb(29, 51, 74);">&nbsp;</div><div class="colorPicker-swatch" style="background-color: rgb(37, 109, 123);">&nbsp;</div><div class="colorPicker-swatch" style="background-color: rgb(37, 40, 80);">&nbsp;</div><div class="colorPicker-swatch" style="border-color: rgb(0, 0, 0); background-color: rgb(73, 103, 141);">&nbsp;</div><div class="colorPicker-swatch" style="background-color: rgb(93, 155, 155);">&nbsp;</div><div class="colorPicker-swatch" style="background-color: rgb(42, 100, 120);">&nbsp;</div><div class="colorPicker-swatch" style="background-color: rgb(40, 114, 51);">&nbsp;</div><div class="colorPicker-swatch" style="background-color: rgb(45, 87, 44);">&nbsp;</div><div class="colorPicker-swatch" style="background-color: rgb(66, 70, 50);">&nbsp;</div><div class="colorPicker-swatch" style="background-color: rgb(31, 58, 61);">&nbsp;</div><div class="colorPicker-swatch" style="background-color: rgb(47, 69, 56);">&nbsp;</div><div class="colorPicker-swatch" style="background-color: rgb(62, 59, 50);">&nbsp;</div><div class="colorPicker-swatch" style="background-color: rgb(52, 59, 41);">&nbsp;</div><div class="colorPicker-swatch" style="background-color: rgb(57, 53, 42);">&nbsp;</div><div class="colorPicker-swatch" style="background-color: rgb(49, 55, 43);">&nbsp;</div><div class="colorPicker-swatch" style="background-color: rgb(53, 104, 45);">&nbsp;</div><div class="colorPicker-swatch" style="background-color: rgb(88, 114, 70);">&nbsp;</div><div class="colorPicker-swatch" style="background-color: rgb(52, 62, 64);">&nbsp;</div><div class="colorPicker-swatch" style="background-color: rgb(108, 113, 86);">&nbsp;</div><div class="colorPicker-swatch" style="background-color: rgb(71, 64, 46);">&nbsp;</div><div class="colorPicker-swatch" style="border-color: rgb(0, 0, 0); background-color: rgb(59, 60, 54);">&nbsp;</div><div class="colorPicker-swatch" style="background-color: rgb(30, 89, 69);">&nbsp;</div><div class="colorPicker-swatch" style="background-color: rgb(76, 145, 65);">&nbsp;</div><div class="colorPicker-swatch" style="background-color: rgb(87, 166, 57);">&nbsp;</div><div class="colorPicker-swatch" style="background-color: rgb(189, 236, 182);">&nbsp;</div><div class="colorPicker-swatch" style="background-color: rgb(137, 172, 118);">&nbsp;</div><div class="colorPicker-swatch" style="background-color: rgb(37, 34, 27);">&nbsp;</div><div class="colorPicker-swatch" style="background-color: rgb(48, 132, 70);">&nbsp;</div><div class="colorPicker-swatch" style="background-color: rgb(61, 100, 45);">&nbsp;</div><div class="colorPicker-swatch" style="background-color: rgb(1, 93, 82);">&nbsp;</div><div class="colorPicker-swatch" style="background-color: rgb(132, 195, 190);">&nbsp;</div><div class="colorPicker-swatch" style="background-color: rgb(44, 85, 69);">&nbsp;</div><div class="colorPicker-swatch" style="background-color: rgb(32, 96, 61);">&nbsp;</div><div class="colorPicker-swatch" style="background-color: rgb(49, 127, 67);">&nbsp;</div><div class="colorPicker-swatch" style="background-color: rgb(73, 126, 118);">&nbsp;</div><div class="colorPicker-swatch" style="background-color: rgb(127, 181, 181);">&nbsp;</div><div class="colorPicker-swatch" style="background-color: rgb(0, 143, 57);">&nbsp;</div><div class="colorPicker-swatch" style="border-color: rgb(0, 0, 0); background-color: rgb(0, 187, 45);">&nbsp;</div><div class="colorPicker-swatch" style="background-color: rgb(138, 149, 151);">&nbsp;</div><div class="colorPicker-swatch" style="background-color: rgb(126, 123, 82);">&nbsp;</div><div class="colorPicker-swatch" style="background-color: rgb(108, 112, 89);">&nbsp;</div><div class="colorPicker-swatch" style="background-color: rgb(150, 153, 146);">&nbsp;</div><div class="colorPicker-swatch" style="background-color: rgb(100, 107, 99);">&nbsp;</div><div class="colorPicker-swatch" style="background-color: rgb(109, 101, 82);">&nbsp;</div><div class="colorPicker-swatch" style="background-color: rgb(106, 95, 49);">&nbsp;</div><div class="colorPicker-swatch" style="background-color: rgb(77, 86, 69);">&nbsp;</div><div class="colorPicker-swatch" style="background-color: rgb(76, 81, 74);">&nbsp;</div><div class="colorPicker-swatch" style="background-color: rgb(67, 75, 77);">&nbsp;</div><div class="colorPicker-swatch" style="background-color: rgb(78, 87, 84);">&nbsp;</div><div class="colorPicker-swatch" style="background-color: rgb(70, 69, 49);">&nbsp;</div><div class="colorPicker-swatch" style="background-color: rgb(67, 71, 80);">&nbsp;</div><div class="colorPicker-swatch" style="background-color: rgb(41, 49, 51);">&nbsp;</div><div class="colorPicker-swatch" style="background-color: rgb(35, 40, 43);">&nbsp;</div><div class="colorPicker-swatch" style="background-color: rgb(51, 47, 44);">&nbsp;</div><div class="colorPicker-swatch" style="border-color: rgb(0, 0, 0); background-color: rgb(104, 108, 94);">&nbsp;</div><div class="colorPicker-swatch" style="background-color: rgb(71, 74, 81);">&nbsp;</div><div class="colorPicker-swatch" style="background-color: rgb(47, 53, 59);">&nbsp;</div><div class="colorPicker-swatch" style="background-color: rgb(139, 140, 122);">&nbsp;</div><div class="colorPicker-swatch" style="background-color: rgb(71, 75, 78);">&nbsp;</div><div class="colorPicker-swatch" style="background-color: rgb(184, 183, 153);">&nbsp;</div><div class="colorPicker-swatch" style="background-color: rgb(125, 132, 113);">&nbsp;</div><div class="colorPicker-swatch" style="background-color: rgb(143, 139, 102);">&nbsp;</div><div class="colorPicker-swatch" style="background-color: rgb(215, 215, 215);">&nbsp;</div><div class="colorPicker-swatch" style="background-color: rgb(127, 118, 121);">&nbsp;</div><div class="colorPicker-swatch" style="background-color: rgb(125, 127, 125);">&nbsp;</div><div class="colorPicker-swatch" style="background-color: rgb(181, 184, 177);">&nbsp;</div><div class="colorPicker-swatch" style="background-color: rgb(108, 105, 96);">&nbsp;</div><div class="colorPicker-swatch" style="background-color: rgb(157, 161, 170);">&nbsp;</div><div class="colorPicker-swatch" style="background-color: rgb(141, 148, 141);">&nbsp;</div><div class="colorPicker-swatch" style="background-color: rgb(78, 84, 82);">&nbsp;</div><div class="colorPicker-swatch" style="border-color: rgb(0, 0, 0); background-color: rgb(202, 196, 176);">&nbsp;</div><div class="colorPicker-swatch" style="background-color: rgb(144, 144, 144);">&nbsp;</div><div class="colorPicker-swatch" style="background-color: rgb(130, 137, 143);">&nbsp;</div><div class="colorPicker-swatch" style="background-color: rgb(208, 208, 208);">&nbsp;</div><div class="colorPicker-swatch" style="background-color: rgb(149, 95, 32);">&nbsp;</div><div class="colorPicker-swatch" style="background-color: rgb(108, 59, 42);">&nbsp;</div><div class="colorPicker-swatch" style="background-color: rgb(115, 66, 34);">&nbsp;</div><div class="colorPicker-swatch" style="background-color: rgb(89, 53, 31);">&nbsp;</div><div class="colorPicker-swatch" style="background-color: rgb(111, 79, 40);">&nbsp;</div><div class="colorPicker-swatch" style="background-color: rgb(91, 58, 41);">&nbsp;</div><div class="colorPicker-swatch" style="background-color: rgb(89, 35, 33);">&nbsp;</div><div class="colorPicker-swatch" style="background-color: rgb(56, 44, 30);">&nbsp;</div><div class="colorPicker-swatch" style="background-color: rgb(99, 58, 52);">&nbsp;</div><div class="colorPicker-swatch" style="background-color: rgb(76, 47, 39);">&nbsp;</div><div class="colorPicker-swatch" style="background-color: rgb(64, 58, 58);">&nbsp;</div><div class="colorPicker-swatch" style="background-color: rgb(33, 33, 33);">&nbsp;</div><div class="colorPicker-swatch" style="border-color: rgb(0, 0, 0); background-color: rgb(166, 94, 46);">&nbsp;</div><div class="colorPicker-swatch" style="background-color: rgb(121, 85, 61);">&nbsp;</div><div class="colorPicker-swatch" style="background-color: rgb(117, 92, 72);">&nbsp;</div><div class="colorPicker-swatch" style="background-color: rgb(78, 59, 49);">&nbsp;</div><div class="colorPicker-swatch" style="background-color: rgb(118, 60, 40);">&nbsp;</div><div class="colorPicker-swatch" style="background-color: rgb(231, 235, 218);">&nbsp;</div><div class="colorPicker-swatch" style="background-color: rgb(244, 244, 244);">&nbsp;</div><div class="colorPicker-swatch" style="background-color: rgb(40, 40, 40);">&nbsp;</div><div class="colorPicker-swatch" style="background-color: rgb(10, 10, 10);">&nbsp;</div><div class="colorPicker-swatch" style="background-color: rgb(143, 143, 143);">&nbsp;</div><div class="colorPicker-swatch" style="background-color: rgb(255, 255, 255);">&nbsp;</div><div class="colorPicker-swatch" style="background-color: rgb(28, 28, 28);">&nbsp;</div><div class="colorPicker-swatch" style="background-color: rgb(246, 246, 246);">&nbsp;</div><div class="colorPicker-swatch" style="background-color: rgb(215, 215, 215);">&nbsp;</div><div class="colorPicker_hexWrap"><p class="labelRal"><label  for="colorPicker_hex-0">RAL</label><input type="text" id="colorPicker_hex-0" value="4006"></p></div></div>';
    echo '</div></li></ul></li>';
    echo '<li><button class="btn290 btnViewAll">VIEW ALL</button></li></ul>';
    echo '<div class="gallery-template"><ul class="bikes">';
    $count = 1;
    while ( $loop->have_posts() ) : $loop->the_post();
      $imageBike  = get_field("bikeimage"); 
      $frameBike  = get_field("frame"); 
      $driveBike  = get_field("drive"); 
      $cogBike    = get_field("cog"); 
      $chainBike  = get_field("chain"); 
      $pedalsBike = get_field("pedals"); 
      $rearBike   = get_field("rear_wheel"); 
      $frontBike  = get_field("front_wheel"); 
      $barsBike   = get_field("bars"); 
      $headsetBike= get_field("headset"); 
      $stemBike   = get_field("stem"); 
      $seatBike   = get_field("seat"); 
      

      echo '<li id="bike-item" class="frame frame_'.$frameBike.'  black fsa vittoria nitto charge"><div class="overlay"><div class="overlay-links">';
      echo '<a class="view-build" href="#" title="View Build">View Build</a><a class="zoom-in" rel="lightbox[uniqueID|filename]"  href="'.$imageBike["url"].'" title="View Full Size">Zoom In</a>';
      echo '</div></div><ul class="bike-parts"><h2 class="center black">Ramas Alu Track</h2>';
      if ($frameBike != "") echo '<li><span>Frame: </span>'.$frameBike.'</li>';
      if ($driveBike != "") echo '<li><span>Drive: </span>'.$driveBike.'</li>';
      if ($cogBike != "") echo '<li><span>Cog: </span>'.$cogBike.'</li>';
      if ($chainBike != "") echo '<li><span>Chain: </span>'.$chainBike.'</li>';
      if ($pedalsBike != "") echo '<li><span>Pedals: </span>'.$pedalsBike.'</li>';
      if ($rearBike != "") echo '<li><span>Rear wheel: </span>'.$rearBike.'</li>';
      if ($frontBike != "") echo '<li><span>Front wheel: </span>'.$frontBike.'</li>';
      if ($barsBike != "") echo '<li><span>Bars: </span>'.$barsBike.'</li>';
      if ($headsetBike != "") echo '<li><span>Headset: </span>'.$headsetBike.'</li>';
      if ($stemBike != "") echo '<li><span>Stem: </span>'.$stemBike.'</li>';
      if ($seatBike != "") echo '<li><span>Seat: </span>'.$seatBike.'</li>';
      

      echo '</ul><img src="'.$imageBike["url"].'"></li>';
      


    endwhile;
    echo '</ul></div>';
    echo "<script>  
        $('.bikes li').on('click','a.view-build',function(event){
           $('.bike-parts',$(this).closest('li')).fadeToggle(200);
           $(this).parent().parent().css({ display: 'none'});
           return false;
        });

       $('.bikes li').on('click','.bike-parts',function(event){
          $(this).animate({
            opacity: 0
          }, 200, function(){
          $('.overlay',$(this).closest('li')).css({ display: 'block' });
          $(this).css({
            display: 'none',
            opacity: '1'
          });
      });

    
      
    });
    </script>";
    $myvariable = ob_get_clean();
        return $myvariable;

}

add_shortcode( 'communityDSNcort', 'communityDNVFunction' );

function community_function_init() {
  $labels = array(
    'name'               => _x( 'CommunityDNV', 'post type general name' ),
    'singular_name'      => _x( 'CommunityDNV', 'post type singular name' ),
  );
  $args = array(
    'labels'         => $labels,
    'description'    => 'CommunityDNV bike gallery',
    'public'         => true,
    'has_archive'    => true,
    'supports'       => array('title')

  );
  register_post_type( 'communitydnv', $args ); 
}
add_action( 'init', 'community_function_init' );


/*Community dsnv end*/


function projectdsnvFunction() {
  ob_start();
    $args = array( 'post_type' => 'projectdsnv', 'posts_per_page' => 10 );
    $loop = new WP_Query( $args );
    
    
    while ( $loop->have_posts() ) : $loop->the_post();
      $imageProject  = get_field("image"); 
      $titleProject  = get_field("title"); 
      $subtitleProject  = get_field("subtitle"); 
      $pageProject = get_field("pageproject");
      echo "<div class='boxProject'>";
      echo "<img src=".$imageProject["url"]." />";
      echo "<h1><a href='".$pageProject."'>".$titleProject."</a></h1>";
      echo "<h3>".$subtitleProject."</h3>";
      echo "</div>";


    endwhile;
    $myvariable = ob_get_clean();
        return $myvariable;
}

add_shortcode( 'porjectdsnvcort', 'projectdsnvFunction' );

function project_function_init() {
   $labels = array(
    'name'               => _x( 'projectsDSNV', 'post type general name' ),
    'singular_name'      => _x( 'projectsDSNV', 'post type singular name' ),
  );
  $args = array(
    'labels'         => $labels,
    'description'    => 'projects dsnv',
    'public'         => true,
    'has_archive'    => true,
    'supports'       => array('title')

  );
  register_post_type( 'projectdsnv', $args );
}

add_action('init', 'project_function_init');

/*function my_updated_messages( $messages ) {
  global $post, $post_ID;
  $messages['product'] = array(
    0 => '', 
    1 => sprintf( __('Product updated. <a href="%s">View product</a>'), esc_url( get_permalink($post_ID) ) ),
    2 => __('Custom field updated.'),
    3 => __('Custom field deleted.'),
    4 => __('Product updated.'),
    5 => isset($_GET['revision']) ? sprintf( __('Product restored to revision from %s'), wp_post_revision_title( (int) $_GET['revision'], false ) ) : false,
    6 => sprintf( __('Product published. <a href="%s">View product</a>'), esc_url( get_permalink($post_ID) ) ),
    7 => __('Product saved.'),
    8 => sprintf( __('Product submitted. <a target="_blank" href="%s">Preview product</a>'), esc_url( add_query_arg( 'preview', 'true', get_permalink($post_ID) ) ) ),
    9 => sprintf( __('Product scheduled for: <strong>%1$s</strong>. <a target="_blank" href="%2$s">Preview product</a>'), date_i18n( __( 'M j, Y @ G:i' ), strtotime( $post->post_date ) ), esc_url( get_permalink($post_ID) ) ),
    10 => sprintf( __('Product draft updated. <a target="_blank" href="%s">Preview product</a>'), esc_url( add_query_arg( 'preview', 'true', get_permalink($post_ID) ) ) ),
  );
  return $messages;
}
add_filter( 'post_updated_messages', 'my_updated_messages' );

function my_contextual_help( $contextual_help, $screen_id, $screen ) { 
  if ( 'product' == $screen->id ) {

    $contextual_help = '<h2>Products</h2>
    <p>Products show the details of the items that we sell on the website. You can see a list of them on this page in reverse chronological order - the latest one we added is first.</p> 
    <p>You can view/edit the details of each product by clicking on its name, or you can perform bulk actions using the dropdown menu and selecting multiple items.</p>';

  } elseif ( 'edit-product' == $screen->id ) {

    $contextual_help = '<h2>Editing products</h2>
    <p>This page allows you to view/modify product details. Please make sure to fill out the available boxes with the appropriate details (product image, price, brand) and <strong>not</strong> add these details to the product description.</p>';

  }
  return $contextual_help;
}
add_action( 'contextual_help', 'my_contextual_help', 10, 3 );



function my_taxonomies_product() {
  $labels = array(
    'name'              => _x( 'Product Categories', 'taxonomy general name' ),
    'singular_name'     => _x( 'Product Category', 'taxonomy singular name' ),
    'search_items'      => __( 'Search Product Categories' ),
    'all_items'         => __( 'All Product Categories' ),
    'parent_item'       => __( 'Parent Product Category' ),
    'parent_item_colon' => __( 'Parent Product Category:' ),
    'edit_item'         => __( 'Edit Product Category' ), 
    'update_item'       => __( 'Update Product Category' ),
    'add_new_item'      => __( 'Add New Product Category' ),
    'new_item_name'     => __( 'New Product Category' ),
    'menu_name'         => __( 'Product Categories' ),
  );
  $args = array(
    'labels' => $labels,
    'hierarchical' => true,
  );
  register_taxonomy( 'product_category', 'product', $args );
}
add_action( 'init', 'my_taxonomies_product', 0 );


add_action( 'add_meta_boxes', 'product_price_box' );
function product_price_box() {
    add_meta_box( 
        'product_price_box',
        __( 'Product Price', 'myplugin_textdomain' ),
        'product_price_box_content',
        'product',
        'side',
        'high'
    );
}

function product_price_box_content( $post ) {
  wp_nonce_field( plugin_basename( __FILE__ ), 'product_price_box_content_nonce' );
  echo '<label for="product_price"></label>';
  echo '<input type="text" id="product_price" name="product_price" placeholder="enter a price" />';
}


add_action( 'save_post', 'product_price_box_save' );
function product_price_box_save( $post_id ) {

  if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) 
  return;
/*
  if ( !wp_verify_nonce( $_POST['product_price_box_content_nonce'], plugin_basename( __FILE__ ) ) )
  return;

  if ( 'page' == $_POST['post_type'] ) {
    if ( !current_user_can( 'edit_page', $post_id ) )
    return;
  } else {
    if ( !current_user_can( 'edit_post', $post_id ) )
    return;
  }
  $product_price = $_POST['product_price'];
  update_post_meta( $post_id, 'product_price', $product_price );
}*/
