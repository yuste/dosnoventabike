<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after
 *
 * @package Graphy
 */
?>

	</div><!-- #content -->

	<footer id="colophon" class="site-footer" role="contentinfo">
		<?php get_sidebar( 'footer' ); ?>
		
		<div class="site-info footer-widget">
			<div class="site-copyright">Dosnoventa Bikes S.L. / Pasaje Bocabella 5 / 08013 Barcelona tel: +34 667 51 54 <a class="whiteColor">info@dosnoventabikes.com</a></div>
			<!--Y:MODIFICADO-->
			<!--<div class="site-copyright">&copy; <?php echo date('Y'); ?> <a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></div>
			<div class="site-credit"><?php _e( 'Powered by ', 'graphy' ); ?><a href="<?php echo esc_url( __( 'http://wordpress.org/', 'graphy' ) ); ?>">WordPress</a> &amp;
			<a href="<?php echo esc_url( __( 'http://themegraphy.com/', 'graphy' ) ); ?>">Themegraphy</a></div>-->
			<!--Y:FINMODIFICACION-->

		</div><!-- .site-info -->
	</footer><!-- #colophon -->
</div><!-- #page -->
<?php if (is_front_page()) : ?>
	<div class="barSubscribe">
	SUBSCRIBE TO DSNV NEWSLETTER
	</div>
	<div class="backgroundSubscribe">
		<div class="contentSubscribe">
			<img src="http://dosnoventa.jsalvatella.com/wp-content/uploads/2015/06/logoSubscribe.png" />
			<h1 class="titleContentSubscribe">SUBSCRIBE TO DSNV NEWSLETTER</h1>
			<input class="inputSubscribe" type="text" placeholder="Enter email address..." /><br />
			<button class="buttonSubscribe">SUBSCRIBE</button><button class="buttonSubscribeCancel">CLOSE</button>
		</div>
		<div class="contentSubscribeSuccess">

		</div>
	</div>
<?php endif; ?>

<?php wp_footer(); ?>

<script>

$.cssHooks.backgroundColor = {
    get: function(elem) {
        if (elem.currentStyle)
            var bg = elem.currentStyle["backgroundColor"];
        else if (window.getComputedStyle)
            var bg = document.defaultView.getComputedStyle(elem,
                null).getPropertyValue("background-color");
        if (bg.search("rgb") == -1)
            return bg;
        else {
            bg = bg.match(/^rgb\((\d+),\s*(\d+),\s*(\d+)\)$/);
            function hex(x) {
                return ("0" + parseInt(x).toString(16)).slice(-2);
            }
            return "#" + hex(bg[1]) + hex(bg[2]) + hex(bg[3]);
        }
    }
}


<?php if (is_front_page()) : ?>
	jQuery('footer').css('display', 'block');
    jQuery('#header-image').css('display', 'block');
	jQuery('.page').fadeIn( "slow", function() {
    	
 	});
 <?php else : ?>
	jQuery('.page').css('display', 'block');
	jQuery('footer').fadeIn( "slow", function() {
    	
 	});
    jQuery('#content').fadeIn( "slow", function() {
    	
 	});
    jQuery('#header-image').fadeIn( "slow", function() {
    	
 	});
<?php endif; ?>	




 var _top = $(window).scrollTop();
 var _direction;
 $(window).scroll(function(){
    var _cur_top = $(window).scrollTop();
    if(_top < _cur_top)
    {
        if (_cur_top > 300) {
        	if (jQuery('.backgroundSubscribe').css('display') == 'none'){
        		if (window.location.href.indexOf('/es/') != -1){
        			jQuery('.barSubscribe').html("SUBSCRIBIRSE AL BOLETÍN");
        		}
        		else {
        			jQuery('.barSubscribe').html("SUBSCRIBE TO DSNV NEWSLETTER");
        		}
        		jQuery('.barSubscribe').css('display', 'block');
        	}
        }
        
    }
    else {
    	if (_top < 100){
    		jQuery('.barSubscribe').css('display', 'none');	
    	}
    }
    _top = _cur_top;
  });

 jQuery('.barSubscribe').click(function(){
 	jQuery('.backgroundSubscribe').css('display','block');
 	jQuery('.barSubscribe').css('display', 'none');
 });

jQuery('#changeEs').click(function() {
	window.location.replace(window.location.href.replace('/en/','/es/'));
});

jQuery('#changeEn').click(function() {
	window.location.replace(window.location.href.replace('/es/','/en/'));
});

if (window.location.href.indexOf('/es/') != -1) {
	jQuery('#changeEs').addClass('decorateLanguage');
}
else {
	jQuery('#changeEn').addClass('decorateLanguage');
}

var numImage =Math.floor((Math.random() * 4) + 1);
jQuery('#imageHomeCentral').attr('src', "http://dosnoventa.jsalvatella.com/wp-content/uploads/2015/06/background-home"+numImage+".jpg");
jQuery('#imageHomeCentral').removeClass('hide');

if($('#cm_mapTR').find('table.storesTableLocator').length !=0){
	jQuery('.btnViewAllStores').css('display', 'block');
}

jQuery('.btnViewAllStores').click(function() {
	jQuery('.storesTableLocator').css('display', 'block');
	jQuery('.btnViewAllStores').css('display', 'none');
});


jQuery('.backgroundSubscribe').click(function() {
	if (jQuery('.backgroundSubscribe').css('display') == 'block') {
//		jQuery('.backgroundSubscribe').css('display', 'none');
	}
});

jQuery('.buttonSubscribeCancel').click(function(){
					jQuery('.contentSubscribeSuccess').css('display', 'none');
					jQuery('.contentSubscribe').css('display', 'block');
					jQuery('.backgroundSubscribe').css('display', 'none');
			});


function functionSubscribe() {
	console.log('json resp');
	console.dir(jsonResp);
}




jQuery('.btn-share-social').hover(function(){

   
    if (jQuery(this).hasClass('share-face')){
        jQuery(this).attr('src', 'http://dosnoventa.jsalvatella.com/wp-content/uploads/2015/05/btn-face-on.png');
    }
    else if (jQuery(this).hasClass('share-tweet')){
        jQuery(this).attr('src', 'http://dosnoventa.jsalvatella.com/wp-content/uploads/2015/05/btn-twitter-on.png');
    }
     else if (jQuery(this).hasClass('share-pin')){
        jQuery(this).attr('src', 'http://dosnoventa.jsalvatella.com/wp-content/uploads/2015/05/btn-pin-on.png');
    }
     else if (jQuery(this).hasClass('share-tumblr')){
        jQuery(this).attr('src', 'http://dosnoventa.jsalvatella.com/wp-content/uploads/2015/05/btn-tumblr-on.png');
    }
}, function(){
    if (jQuery(this).hasClass('share-face')){
        jQuery(this).attr('src', 'http://dosnoventa.jsalvatella.com/wp-content/uploads/2015/05/btn-face.png');
    }
    else if (jQuery(this).hasClass('share-tweet')){
        jQuery(this).attr('src', 'http://dosnoventa.jsalvatella.com/wp-content/uploads/2015/05/btn-twitter.png');
    }
     else if (jQuery(this).hasClass('share-pin')){
        jQuery(this).attr('src', 'http://dosnoventa.jsalvatella.com/wp-content/uploads/2015/05/btn-pin.png');
    }
     else if (jQuery(this).hasClass('share-tumblr')){
        jQuery(this).attr('src', 'http://dosnoventa.jsalvatella.com/wp-content/uploads/2015/05/btn-tumblr.png');
    }
});

jQuery('.buttonSubscribe').click(function() {
	var emailAux = jQuery('.inputSubscribe').val();
	//var valuejson = '{"apikey":"45557fa2e18187ffab7366067047947b-us11", "email_address":"dyuste@wesmartpark.com", "status":"subscribed"}';
	//$('<form method="GET" action="http://mc.us11.list-manage.com/subscribe/form-post-json?u=03ac651df87e39ab869218023&id=0fae1e80ff"><input name="EMAIL" type="text" value="pruebitamil@dosnoventa.com"><input name="b_03ac651df87e39ab869218023_0fae1e80ff" value=""></form>').appendTo('body').submit();
	//var jsonString = JSON.parse('{"u":"03ac651df87e39ab869218023", "id":"0fae1e80ff", "EMAIL":"daniel.yuste.padilla@gmail.com" }');
	var jsonString = 'u=ae18b7277c6d505f4d0a6e0e6&id=fc57f753dc&EMAIL='+emailAux;

	$.ajax({
          // Cambia por la URL de tu lista de correo
          url: "https://mc.us9.list-manage.com/subscribe/form-post-json",
          // Serializamos los datos del formulario para pasarlos a pares query=value
          data: jsonString,
          dataType: 'jsonp',
          // Nombre de la función callback requerido por el API de MailChimp
          jsonp: 'c'
       }).done(function(data){
       		jQuery('.contentSubscribeSuccess').css('display', 'block');
       		jQuery('.contentSubscribe').css('display', 'none');
     		if (data.result == "success") {
     			if (window.location.href.indexOf('/es/') != -1){
     				jQuery('.contentSubscribeSuccess').html("Se te ha enviado un email de confirmación <br /><br /><button class='buttonSubscribeCancel'>ACEPTAR</button>");
     			}
     			else {
     				jQuery('.contentSubscribeSuccess').html("It sent to you an confirmation email <br /><br /><button class='buttonSubscribeCancel'>ACCEPT</button>");	
     			}
     		}
     		else {
     			if (data.msg){
     				if (data.msg.indexOf('Too many subscribe attempt') != -1){
     					if (window.location.href.indexOf('/es/') != -1){
     						jQuery('.contentSubscribeSuccess').html("Se ha sobrepasado el número de intentos <br /><br /><button class='buttonSubscribeCancel'>ACEPTAR</button>");
     					}
     					else {
     						jQuery('.contentSubscribeSuccess').html("The number of attempts has been exceeded <br /><br /><button class='buttonSubscribeCancel'>ACCEPT</button>");	
     					}
     				}
     			}
     			else if (data.errors) {
     				if (window.location.href.indexOf('/es/') != -1){
						jQuery('.contentSubscribeSuccess').html("Introduce un email valido <br /><br /><button class='buttonSubscribeCancel'>ACEPTAR</button>");			
     				}
     				else {
     					jQuery('.contentSubscribeSuccess').html("Enter a correct email <br /><br /><button class='buttonSubscribeCancel'>ACCEPT</button>");			
     				}
     				
     			}
     			
     		
     		}

     		jQuery('.contentSubscribeSuccess').css('font-size','50px');

 			jQuery('.buttonSubscribeCancel').click(function(){
				jQuery('.contentSubscribeSuccess').css('display', 'none');
				jQuery('.contentSubscribe').css('display', 'block');
				jQuery('.backgroundSubscribe').css('display', 'none');
			});

     		


        }).fail(function(err){
        	if (window.location.href.indexOf('/es/') != -1){
             	jQuery('.contentSubscribeSuccess').html("El sistema no funciona en este momento, por favor intentalo más tarde <br /><br /><button class='buttonSubscribeCancel'>ACEPTAR</button>");			
            }
            else {
            	jQuery('.contentSubscribeSuccess').html("The system don't work in this moment, please you can try it later <br /><br /><button class='buttonSubscribeCancel'>ACCEPT</button>");			
            }
             jQuery('.contentSubscribeSuccess').css('font-size','50px');
             jQuery('.buttonSubscribeCancel').click(function(){
				jQuery('.contentSubscribeSuccess').css('display', 'none');
				jQuery('.contentSubscribe').css('display', 'block');
				jQuery('.backgroundSubscribe').css('display', 'none');
			});

        });

});



</script>
</body>
</html>