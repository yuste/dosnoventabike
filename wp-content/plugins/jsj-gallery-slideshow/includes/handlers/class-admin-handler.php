<?php 
	
	class JSJGallerySlideshowAdmin {

		public function __construct($name_space, &$settings, &$title, &$all_themes) {
			$this->name_space = $name_space;
			$this->settings   = $settings;
			$this->title      = $title;
			$this->all_themes = $all_themes;
		}

		/**
		 * This will create a menu item under the option menu
		 * @see http://codex.wordpress.org/Function_Reference/add_options_page
		 *
		 * @return void
		 */
		public function addOptionsMenu(){
			add_options_page(__( 'JSJ Gallery Slideshow Options', 'jsj-gallery-slideshow' ), 'JSJ Gallery Slideshow', 'manage_options', 'jsj-gallery-slideshow', array($this, 'optionsPage'));
		}

		/**
		 * Update our themes variable
		 *
		 * I'm only adding this because passing by reference wasn't working for me
		 */
		public function updateAllThemes($themes) {
			$this->all_themes = $themes;
		}

		/**
		 * This is where you add all the html and php for your option page
		 *
		 * @return void
		 */
		public function optionsPage(){

			if($_GET && isset($_GET['tab'])){
				$options_tab = $_GET['tab'];
			}
			else{
				$options_tab = 'themes';
			}

			// Reset Settings
			if($_POST && isset($_POST[ $this->name_space . '-switch_default']) && $_POST[ $this->name_space . '-switch_default']) { 
				$this->settings->resetSettings();
				echo('<div class="updated settings-error"><p>' . __( 'Your settings have been reverted back to their default.', 'jsj-gallery-slideshow' ) . '</p></div>');
			}
			?>

			<div id="<?php echo $this->name_space; ?>-container" class="<?php echo $this->name_space; ?> <?php echo $this->name_space; ?>-container">

				<!-- Title & Description -->
				<h2 class="<?php echo $this->name_space; ?> <?php echo $this->name_space; ?>-header"><?php echo $this->title ?></h2>

				<!-- Display All Tabs -->
				<div id="nav" class="tab-nav">
					<h2 class="themes-php">
						<a class="nav-tab <?php if($options_tab == 'themes'){ echo 'nav-tab-active'; } ?>" href="?page=<?php echo $this->name_space; ?>&amp;tab=themes ">
							<?php _e('Themes', 'jsj-gallery-slideshow' ); ?>
						</a>
						<a class="nav-tab <?php if($options_tab == 'simple'){ echo 'nav-tab-active'; } ?>" href="?page=<?php echo $this->name_space; ?>&amp;tab=simple">
							<?php _e('Simple', 'jsj-gallery-slideshow' ); ?>
						</a>
						<a class="nav-tab <?php if($options_tab == 'advanced'){ echo 'nav-tab-active'; } ?>" href="?page=<?php echo $this->name_space; ?>&amp;tab=advanced">
							<?php _e('Advanced', 'jsj-gallery-slideshow' ); ?>
						</a>
					</h2>
				</div>

				<!-- Display Form -->
				<form method="post" action="options.php" class="<?php echo $this->name_space; ?>">
					<?php settings_fields( 'jsj_gallery_slideshow-settings-group' ); ?>
					<div class="<?php echo $this->name_space; ?>-tab-content <?php echo (($options_tab == 'themes') ? 'active' : 'disabled' );?>">
						<!-- Gallery Options -->
						<h3><?php _e( 'Theme Options', 'jsj-gallery-slideshow' ); ?></h3>
						<?php foreach($this->all_themes as $theme): ?>
							<label 
								class="<?php echo $this->name_space;?>_themes <?php echo $this->name_space;?>_theme_label" 
								for="<?php echo $theme['slug']; ?>"
							>
								<input 
									id="<?php echo $theme['slug']; ?>" 
									type="radio" 
									name="<?php echo $this->settings->themes['current_theme']['name_space']; ?>" 
									value="<?php echo $theme['slug']; ?>" 
									<?php if ( $theme['active']) echo 'checked="checked"'; ?>
								/>
								<img 
									src="<?php echo $theme['screenshot_url']; ?>" 
									alt="<?php echo $theme['name']; ?>" 
								/>
								<p><?php echo $theme['name']; ?></p>
							</label>
						<?php endforeach; ?>
						<a href="http://plugins.thejsj.com/all-themes/" target="_blank" class="<?php echo $this->name_space;?>_themes add-more-button">
							<img title="" alt="" src="data:image/png;base64,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" />
							<p>Add More Themes</p>
						</a>
					</div>

					<div class="<?php echo $this->name_space; ?>-tab-content <?php echo (($options_tab == 'simple') ? 'active' : 'disabled' );?>">
						<!-- Gallery Options -->
						<h3><?php _e( 'Gallery Options', 'jsj-gallery-slideshow' ); ?></h3>
						<?php $this->displayOptionsForm($this->settings->cycle, 'simple'); ?>
					</div>

					<div class="<?php echo $this->name_space; ?>-tab-content <?php echo (($options_tab == 'advanced') ? 'active' : 'disabled' );?>">		

						<!-- Gallery Options -->
						<h3><?php _e( 'Advanced Gallery Options', 'jsj-gallery-slideshow' ); ?></h3>
						<?php $this->displayOptionsForm($this->settings->cycle, 'advanced'); ?>			

						<!-- Loading Options -->
						<h3><?php _e( 'Loading Options', 'jsj-gallery-slideshow' ); ?></h3>
						<?php $this->displayOptionsForm($this->settings->other, 'advanced'); ?>		

					</div>
					<div style="clear:both"></div>

					<!-- Save -->
					<!-- <p><?php _e( 'If pleased with your settings, go ahead and save them!', 'jsj-gallery-slideshow' ); ?></p> -->
					<?php submit_button(); ?>

				</form>

				<!-- Revert Options to their defults -->
				<p><?php _e( 'Reset all plugin settings to their defaults. This will delete all your current settings.', 'jsj-gallery-slideshow' ); ?></p>
				<form name="<?php echo $this->name_space; ?>-default" method="post" action="<?php echo str_replace( '%7E', '~', $_SERVER['REQUEST_URI']); ?>">
	                <input type="hidden" name="<?php echo $this->name_space; ?>-switch_default" value="1">  
	                <input type="submit" name="Submit" value="<?php _e( 'Reset Plugin Settings', 'jsj-gallery-slideshow' ); ?>" class="button"/>
	            </form>
	     
	            <h4><?php _e('Resources', 'jsj-gallery-slideshow' ); ?></h4>
	            <ul>
	            	<li><?php echo sprintf( __('%sRequest A Feature%s', 'jsj-gallery-slideshow' ), '<a href="http://thejsj.com/jsj-gallery-slideshow-feature-request/" target="_blank">' , '</a>'); ?></li>
	            	<?php /* <li><?php echo sprintf( __('%sHow To Use This Plugin%s', 'jsj-gallery-slideshow' ), '<a href="#" target="_blank">' , '</a>'); ?></li>
	            	<?php // TODO : Add Survey link ?> */ ?>
	            	<?php /* <li><?php echo sprintf( __('%sProvide Feedback%s', 'jsj-gallery-slideshow' ), '<a href="#" target="_blank">','</a>'); ?></li> */ ?>
	            	<li><?php echo sprintf( __('%sReview This Plugin%s', 'jsj-gallery-slideshow' ), '<a href="http://wordpress.org/support/view/plugin-reviews/jsj-gallery-slideshow" target="_blank">','</a>'); ?></li>
	            	<li><?php echo sprintf( __('%sVisit Plugin Website%s', 'jsj-gallery-slideshow' ), '<a href="http://wordpress.org/plugins/jsj-gallery-slideshow/" target="_blank">', '</a>'); ?></li>
	            	<li><?php echo sprintf( __('%sSee All JSJ Plugins%s', 'jsj-gallery-slideshow' ), '<a href="http://profiles.wordpress.org/jorgesilva-1/" target="_blank">','</a>'); ?></li>
				</ul>
	            <h4><?php _e('Credit', 'jsj-gallery-slideshow' ); ?></h4>
	            <ul>
	            	<li><?php echo sprintf( __('Plugin by  %s', 'jsj-gallery-slideshow' ), '<a href="http://thejsj.com" target="_blank">Jorge Silva-Jetter</a>'); ?></li>
	            	<li><?php echo sprintf( __('Built with %sJquery Cycle%s', 'jsj-gallery-slideshow' ), '<a href="http://jquery.malsup.com/cycle/" target="_blank">' , '</a>'); ?></li>
	            	<li><?php echo sprintf( __('Inspired by %sCargo%s', 'jsj-gallery-slideshow' ), '<a href="http://cargocollective.com/slideshow" target="_blank">', '</a>'); ?></li>
				</ul>
				
		</div>
		<?php }

		/**
		 * Turns an array of options into HTML
		 *
		 * @return void
		 */
		private function displayOptionsForm($options_group, $tab = 'simple'){ ?>
			<table class="<?php echo $this->name_space; ?>">
			<?php $i = 0; // used for odd/even value?>
			<?php foreach($options_group as $key => $option): ?>
				<?php if(isset($option['tab']) && $option['tab'] == $tab): ?>
					<tr class="<?php echo $this->name_space; ?> <?php echo $this->name_space; ?>-main <?php echo ( isset($option['class']) ? $option['class'] : '' ); ?> <?php echo $i; ?> <?php echo ( $i % 2  == 0 ? 'odd' : 'even' ); ?>">
						<td class="<?php echo $this->name_space; ?> <?php echo $this->name_space; ?>-name"><strong><?php echo $option['title'] ?></strong></td>
						<td class="<?php echo $this->name_space; ?>-field">
							<label for="<?php echo $option['name_space']; ?>">
								<?php if($option['type'] == 'boolean'): // Boolean ?>
									<input type='checkbox' id="<?php echo $option['name_space']; ?>" name="<?php echo $option['name_space']; ?>" value='1' <?php if ( 1 == $option['value'] ) echo 'checked="checked"'; ?> />
								<?php elseif( $option['type'] != "select" ): ?>
									<input id="<?php echo $option['name_space']; ?>" class="<?php echo $this->name_space; ?>" type="<?php echo $option['type'] ?>" name="<?php echo $option['name_space'] ?>" value="<?php echo $option['value'] ?>" />
								<?php else: ?>
									<select id="<?php echo $option['name_space']; ?>" name="<?php echo $option['name_space'] ?>">
										<option class="<?php echo $this->name_space; ?>" value="<?php echo $option['value']; ?>"><?php echo $option['value']; ?></option>';
										<?php for($iii = 0; $iii < count($option['parameters']); $iii++): ?>
											<?php if($option['parameters'][$iii] != $option['value']): ?>
												<option class="<?php echo $this->name_space; ?>" value="<?php echo $option['parameters'][$iii]; ?>"><?php echo $option['parameters'][$iii]; ?></option>
											<?php endif; ?>
										<?php endfor; ?>
									</select>
								<?php endif; ?>
								<span class='description <?php echo $this->name_space; ?>-description'><?php echo $option['descp'] ?></span>
							</label>
						</td>
					</tr>
					<?php $i++; ?>
				<?php endif; ?>
			<?php endforeach; ?>
			</table><?php
		}

		/**
		 * Get a specific admin color user user preferences and the WP array of colors
		 *
		 * @return string
		 */
		private function getAdminColor($key = 3){
			if(!isset($this->colors)){
				global $_wp_admin_css_colors;
				$current_color = get_user_option( 'admin_color' );
				if($current_color && $_wp_admin_css_colors[$current_color]){
					$this->colors = $_wp_admin_css_colors[$current_color];
				}
			}
			if(isset($this->colors) && isset($this->colors->colors[$key])){
				return $this->colors->colors[$key];
			}
			return '#000'; 
		}
	}