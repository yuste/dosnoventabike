<?php 

	class JSJGallerySlideshowShortcodeHandler {

		public function __construct($name_space, &$settings, &$theme, &$all_themes, $scripts) {
			$this->name_space = $name_space;
			$this->settings   = $settings;
			$this->theme      = $theme;
			$this->all_themes = $all_themes;
			$this->scripts    = $scripts;
			$this->all_images = array();
			$this->all_enqueued_themes = array();
		}

		/**
		 * Update our theme variable
		 *
		 * I'm only adding this because passing by reference wasn't working for me
		 *
		 * @return void
		 */
		public function updateTheme($theme) {
			$this->theme = $theme;
		}


		/**
		 * Update the all_themes variable
		 *
		 * I'm only adding this because passing by reference wasn't working for me
		 *
		 * @return void
		 */
		public function updateAllThemes($all_themes) {
			$this->all_themes = $all_themes;
		}

		/**
		 * Add an array of all used images with their respective alt text, caption, descrption... etc
		 *
		 * @return void
		 */
		public function enqueueImagesArray () {
			// Localize Settings
			wp_localize_script( 
				$this->scripts['main'],
				'jsj_gallery_slideshow_images', 
				$this->all_images
			);
		}

		/**
		 * Change Slidehow Function
		 * 
		 * Overwrite of WP Core
		 * 
		 * @return string
		 */
		public function galleryShortcode($attr){

			// Copy pasted from the WordPress core source
			global $post, $wp_locale;

			static $instance = 0;
			$instance++;
			if ( ! empty( $attr['ids'] ) ) {
			  // 'ids' is explicitly ordered, unless you specify otherwise.
				if ( empty( $attr['orderby'] ) )
					$attr['orderby'] = 'post__in';
				$attr['include'] = $attr['ids'];
			}

		  	// Allow plugins/themes to override the default gallery template.
			$output = apply_filters('post_gallery', '', $attr);
			if ( $output != '' )
				return $output;

		  	// We're trusting author input, so let's at least make sure it looks like a valid orderby statement
			if ( isset( $attr['orderby'] ) ) {
				$attr['orderby'] = sanitize_sql_orderby( $attr['orderby'] );
				if ( !$attr['orderby'] )
					unset( $attr['orderby'] );
			};

			extract(shortcode_atts(array(
				'order'      => 'ASC',
				'orderby'    => 'menu_order ID',
				'id'         => $post->ID,
				'itemtag'    => 'dl',
				'icontag'    => 'dt',
				'captiontag' => 'dd',
				'columns'    => 3,
				'size'       => $this->settings->other['defaultImageSize']['value'],
				'include'    => '',
				'exclude'    => ''
				), $attr));

			$id = intval($id);
			if ( 'RAND' == $order )
				$orderby = 'none';

			if ( !empty($include) ) {
				$_attachments = get_posts( array('include' => $include, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $order, 'orderby' => $orderby) );

				$attachments = array();
				foreach ( $_attachments as $key => $val ) {
					$attachments[$val->ID] = $_attachments[$key];
				}
			} elseif ( !empty($exclude) ) {
				$attachments = get_children( array('post_parent' => $id, 'exclude' => $exclude, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $order, 'orderby' => $orderby) );
			} else {
				$attachments = get_children( array('post_parent' => $id, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $order, 'orderby' => $orderby) );
			}

			if ( empty($attachments) )
				return '';

			if ( is_feed() ) {
				$output = "\n";
				foreach ( $attachments as $att_id => $attachment )
					$output .= wp_get_attachment_link($att_id, $size, true) . "\n";
				return $output;
			}
			// End WordPress Core Source copy-paste

			/**
			 *
			 * Don't include this, because this is horrible code
			 *
			 * $gallery_style = $gallery_div = '';
			 * if ( apply_filters( 'use_default_gallery_style', true ) )
			 *	$gallery_style = "<style type='text/css'>#{$selector} .gallery img { border: 0px; margin: 0px; }</style>";
			 * see gallery_shortcode() in wp-includes/media.php
			 */
			
			/**
			 * WARNING: We're ignoring and NOT including the 'gallery_style' filter
		     */

			/**
			 * See if a theme is defined, if so, check if exists and make it our current theme
			 */
			$theme = $this->setTheme($attr);

			/**
			 * Define all our variables to be used in our templates
			 */
			$template_variables = array(
				// Main Variables
				'name_space'         => $this->name_space,
				'theme_name'         => $theme['slug'],
				'instance'           => $instance,
				'id'                 => $instance,
				'totalCount'         => count($attachments),
				'count'              => count($attachments),
				
				// Cycle Variables (We're copying these one by one so that all template tags are here)
				'selector'           => $theme['cycle_options']['autoSelector']['css_class'],
				'caption_class'      => $theme['cycle_options']['caption']['css_class'],
				'next_class'         => $theme['cycle_options']['next']['css_class'],
				'pager_class'        => $theme['cycle_options']['pager']['css_class'],
				'prev_class'         => $theme['cycle_options']['prev']['css_class'],
				'numbering_class'    => $theme['cycle_options']['numbering']['css_class'],

				// Variables Used by Cycle
				'caption_template'   => $theme['cycle_options']['captionTemplate']['value'],
				'disabled_class'     => $theme['cycle_options']['disabledClass']['value'],
				'pager_active_class' => $theme['cycle_options']['pagerActiveClass']['value'],
				'slide_active_class' => $theme['cycle_options']['slideActiveClass']['value'],
				'slide_class'        => $theme['cycle_options']['slideClass']['value'],

				// Worpdress Variables
				'itemtag'            => tag_escape($itemtag),
				'captiontag'         => tag_escape($captiontag),
				'columns'            => intval($columns),
				'itemwidth'          => $columns > 0 ? floor(100/$columns) : 100,
				'float'              => is_rtl() ? 'right' : 'left',
				'size_class'         => $size_class = sanitize_html_class( $size ),

				// Text Variables
				'previous_text'      => __( '', 'jsj-gallery-slideshow' ),
				'next_text'          => __( '', 'jsj-gallery-slideshow' ),
				'number_translation' => __( 'of', '1 of 10','jsj-gallery-slideshow' ),
				
				// Slideshow Specific Variables		
				'images'             => $this->getImages($attachments, $size, $instance),
			);

			// Render Template
			$output = $this->renderTemplate($theme['template_file_location'], $template_variables);

			return $output;
		}

		/**
		 * Check if themes needs to be appended 
		 *
		 * @return <object>
		 */
		private function setTheme($attr) {
			if(is_array($attr)
				&& array_key_exists('theme', $attr)
				&& $attr['theme'] 
				&& $this->getTheme($attr['theme'])) {
				$theme = $this->getTheme($attr['theme']);
				if ($theme['slug'] !== $this->theme['slug']){
					array_push($this->all_enqueued_themes, $theme);
					return $theme;
				}
			}
			return $this->theme;
		}

		/**
		 * Check if theme exists and return it if exists
		 * 
		 * @return <boolean>
		 */
		private function getTheme($theme_name) {
			foreach($this->all_themes as $theme) {
				if(sanitize_title( $theme['name'] ) === sanitize_title($theme_name) 
					|| sanitize_title($theme['slug']) === sanitize_title($theme_name) ) {
					return $theme;
				}
			}
			return false;
		}

		/**
		 * Get an array of attachemnts as a HTML
		 *
		 * @param $attachments <array> - Array of WP attachments IDs
		 * @return <string> - HTML with images
		 */
		public function getImages($attachments, $size, $instance) {
			require_once( plugin_dir_path( dirname(__FILE__) ) . '/classes/class-image.php');

			$images_html = "";
			foreach ( $attachments as $id => $attachment ) {
				if (!array_key_exists($id, $this->all_images)) {
					$this->all_images[$id] = new JSJGallerySlideshowImage($id);
				}
				$images_html .= $this->all_images[$id]->getHTML($size);
			}
			return $images_html;
		}

		/**
		 * Render Template
		 *
		 * This function is pretty horrible and embarrasing, but it's the best solution I found that doesn't involve writing my own template system
		 * I hate you PHP and the things you make me do!
		 *
		 * @param filename <string>
		 * @param variables <array> - variables available to the template
		 * @return HTML <string> - Parsed HTML
		 */
	    public function renderTemplate($template_file_location, $vars) {
			//start output buffering (so we can return the content)
	        ob_start();
	        //bring all variables into "local" variables using "variable variable names"
	        foreach($vars as $k => $v) {
	            $$k = $v;
	        }

	        //include view
	        include($template_file_location);

	        $str = ob_get_contents();//get teh entire view.
	        ob_end_clean();//stop output buffering
	        return $str;
	    }

	}