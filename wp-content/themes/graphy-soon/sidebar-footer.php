<?php
/**
 * The Footer Widget
 *
 * @package Graphy
 */
if (   ! is_active_sidebar( 'footer-1' )
	&& ! is_active_sidebar( 'footer-2' )
	&& ! is_active_sidebar( 'footer-3' )
	&& ! is_active_sidebar( 'footer-4' )
)
	return;
?>

<div id="supplementary" class="footer-area">
	<div class="footer-widget">
		<?php if ( is_active_sidebar( 'footer-1' ) ) : ?>
		<div class="footer-widget-1 widget-area" role="complementary">
			<?php dynamic_sidebar( 'footer-1' ); ?>
		</div>
		<?php endif; ?>
		<?php if ( is_active_sidebar( 'footer-2' ) ) : ?>
		<div class="footer-widget-2 widget-area" role="complementary">
			<?php dynamic_sidebar( 'footer-2' ); ?>
		</div>
		<?php endif; ?>
		<?php if ( is_active_sidebar( 'footer-3' ) ) : ?>
		<div class="footer-widget-3 widget-area" role="complementary">
			<?php dynamic_sidebar( 'footer-3' ); ?>
		</div>
		<?php endif; ?>
		<?php if ( is_active_sidebar( 'footer-4' ) ) : ?>
		<div class="footer-widget-4 widget-area" role="complementary">
			<?php dynamic_sidebar( 'footer-4' ); ?>
		</div>
		<?php endif; ?>
		<!--MODIFICADO-->
		<p class="divLogosPartner">
			<a href="http://global.lacoste.com/es/lacoste-live-1/"><img class="footerLogoPartner" src="http://dosnoventa.jsalvatella.com/wp-content/uploads/2015/05/logo1.png"/></a>
			<a href="https://www.hedcycling.com/"><img class="footerLogoPartner"  src="http://dosnoventa.jsalvatella.com/wp-content/uploads/2015/06/logo2.png"/></a>
			<a href="http://www.rotorbike.com/"><img class="footerLogoPartner"  src="http://dosnoventa.jsalvatella.com/wp-content/uploads/2015/06/logo3.png"/></a>
			<a href="https://www.conti-online.com/www/bicycle_de_en/"><img class="footerLogoPartner"  src="http://dosnoventa.jsalvatella.com/wp-content/uploads/2015/05/logo4.png"/></a>
			<a href="http://www.sellesanmarco.it/"><img class="footerLogoPartner"  src="http://dosnoventa.jsalvatella.com/wp-content/uploads/2015/05/logo5.png"/></a>
			<a href="http://www.giro.com/eu_en/"><img class="footerLogoPartner"  src="http://dosnoventa.jsalvatella.com/wp-content/uploads/2015/06/logo6.png"/></a>
			<a href="http://www.oakley.com"><img class="footerLogoPartner"  src="http://dosnoventa.jsalvatella.com/wp-content/uploads/2015/05/logo7.png"/></a>
			<a href="http://www.dedaelementi.com/WEBSITE/index.php/en/"><img class="footerLogoPartner"  src="http://dosnoventa.jsalvatella.com/wp-content/uploads/2015/05/logo8.png"/></a>
		</p>
		<!--FINMODIFICADO-->
	</div><!-- #footer-widget-wrap -->
</div><!-- #supplementary -->
