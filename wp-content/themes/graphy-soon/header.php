<?php
/**
 * The Header for our theme.
 *
 * Displays all of the <head> section and everything up till <div id="content">
 *
 * @package Graphy
 */
?><!DOCTYPE html>
<!--[if IE 8]>
<html class="ie8" <?php language_attributes(); ?>>
<![endif]-->
<!--[if !(IE 8) ]><!-->
<html <?php language_attributes(); ?>>
<!--<![endif]-->
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title><?php wp_title( '|', true, 'right' ); ?></title>
<link rel="profile" href="http://gmpg.org/xfn/11">
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
<script type="text/javascript" src="/wp-includes/js/jquery/jquery.js"></script>

<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<div id="page" class="hfeed site">
<!--MODIFICADO-->
	
	<header class="topHeader">
				
			<div class="whiteColor returnHome"><div class="languagesMenu"><a id="changeEs" href="javascript:;">ESP</a> | <a id="changeEn" href="javascript:;">ENG</a></div>
			<?php //if (!is_front_page()) : ?>
				<!--<a class="linkReturnHomePage" href="/">< RETURN TO HOMEPAGE <</a>-->
			<?php //endif; ?>	
			
			<ul class="shopHeader ">
				<li><span>LOGIN</span></li>
				<li>|</li>
				<li id="cart-target" class=" carrito toolbar-cart ">
			        <a href="/cart" class="cart" title="Shopping Cart">
			          <span class="icon-cart"></span>
			        </a>
				</li>
				<li>|</li>
				<li><img class="love" src="//cdn.shopify.com/s/files/1/0688/9903/t/1/assets/love.png?2057144681147752357"><span>JOIN DSNV</span></li>
			</ul>
			</div>
	</header>

<!--FINMODIFICADO-->
	<header id="masthead" class="site-header" role="banner">
		<div class="site-branding">
			<?php if ( get_theme_mod( 'graphy_logo' ) && get_theme_mod( 'graphy_replace_blogname' ) ) : ?>
			<h1 class="site-logo"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><img alt="<?php bloginfo( 'name' ); ?>" src="<?php echo esc_url( get_theme_mod( 'graphy_logo' ) ); ?>" /></a></h1>
			<?php elseif ( get_theme_mod( 'graphy_logo' ) ) : ?>
			<!--<div class="site-logo"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><img alt="" src="<?php echo esc_url( get_theme_mod( 'graphy_logo' ) ); ?>" /></a></div>-->
			<h1 class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
			<?php else : ?>
			<h1 class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
			<?php endif; ?>
			<?php if ( ! get_theme_mod( 'graphy_hide_blogdescription' ) ) : ?>
			<div class="site-description"><?php bloginfo( 'description' ); ?></div>
			<?php endif; ?>
		</div>

		<div class="main-navigation-wrapper">
			<nav id="site-navigation" class="main-navigation" role="navigation">
				<h1 class="menu-toggle"><?php _e( 'Menu', 'graphy' ); ?></h1>
				<?php $stringLogo = "<div class='site-logo'><a href='".esc_url( home_url( '/' ) )."' rel='home'><img src='".esc_url( get_theme_mod( 'graphy_logo' ) )."'/></a></div>"; ?>
				<?php wp_nav_menu( array( 'theme_location' => 'primary', 'items_wrap' => '<ul id="menu-global_menu" class="menu" ><li class="liLogo">'.$stringLogo.'%3$s</li></ul>' ) ); ?>
				<?php if ( ! get_theme_mod( 'graphy_hide_search' ) ) : ?>
				<?php get_search_form(); ?>
				<?php endif; ?>
			</nav><!-- #site-navigation -->
		</div>

		<?php if ( is_home() && get_header_image() ) : ?>
		<div id="header-image" class="header-image">
			<img src="<?php header_image(); ?>" width="<?php echo get_custom_header()->width; ?>" height="<?php echo get_custom_header()->height; ?>" alt="">
		</div><!-- #header-image -->
		<?php elseif ( is_page() && has_post_thumbnail() ) : ?>
			<?php if (is_front_page()) : ?>
				<div id="header-image" class="header-image header-image-frontpage">
					<img  id="imageHomeCentral" src="http://dosnoventa.jsalvatella.com/wp-content/uploads/2015/07/background-home-web2.jpg" class="hide attachment-graphy-page-thumbnail wp-post-image" alt="background-home">
				</div>
			<?php else :?>
				<div id="header-image" class="header-image">
				<?php the_post_thumbnail( 'graphy-page-thumbnail' ); ?>
				</div>
			<?php endif; ?>
		</div><!-- #header-image -->
		<?php endif; ?>
	</header><!-- #masthead -->

	<div id="content" class="site-content">
