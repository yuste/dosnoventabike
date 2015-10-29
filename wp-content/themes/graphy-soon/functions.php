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
    </script>";
}
add_shortcode( 'communityScript', 'communityScript_func' );


function communityDNVFunction() {
  ob_start();
    $args = array( 'post_type' => 'communityDNV', 'posts_per_page' => 10 );
    $loop = new WP_Query( $args );
    
    echo '<div style="display: inline-block;"><select class="select290 changeFrameSelect">';
    echo '<option>Choose Frame</option><option >KUALA LUMPUR</option><option >MONTECARLO</option><option >DETROIT</option>';
    echo '<option >HOUSTON</option><option >BARCELONA</option><option >TOKYO</option><option >EDINBURGH</option>';
    echo '<option >SEOUL</option><option >COPENHAGEN</option><option >STUTTGART</option><option >VERONA</option>';
    echo '</select><select class="select290"><option>Choose Color</option></select><button class="btn290 btnViewAll">VIEW ALL</button></div>';
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
