<?php
/* 
 Plugin Name: Rescue Reveal Content Widget
 Plugin URI: https://rescuethemes.com
 Description: This plugin will add a widget called 'Rescue Reveal Content' to your Widgets area that will allow you to select an icon and enter content to display on your site. For themes developed by <a href="https://rescuethemes.com">Rescue Themes</a>
 Author: Rescue Themes
 Version: 1.0
 Author URI: https://rescuethemes.com
*/

class rescue_reveal_plugin extends WP_Widget {

	// Defines the widget name
	function rescue_reveal_plugin() {
		parent::WP_Widget(false, $name = __('Rescue Reveal Content', 'rescue') );
	}

	// Creates the widget in the WP admin area
	function form($instance) {

		// Check values
		if( $instance) {
		     $title = esc_attr($instance['title']);
		     $textarea = esc_textarea($instance['textarea']);
		     $image_uri = esc_url($instance['image_uri']);
		     $icon = esc_attr($instance['icon']);
		     $link = esc_url($instance['link']);
		} else {
		    $title = '';
		    $textarea = '';
		    $image_uri = '';
		    $icon = '';
		    $link = '';
		}
		?>

		<p>
		<label for="<?php echo $this->get_field_id('social'); ?>"><?php _e('Content:', 'rescue'); ?></label><br />
		</p>

		<p>
		<label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Widget Title', 'rescue'); ?></label>
		<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" />
		</p>

		<p>
		<label for="<?php echo $this->get_field_id('textarea'); ?>"><?php _e('Textarea:', 'rescue'); ?></label>
		<textarea class="widefat" style="min-height: 150px;" id="<?php echo $this->get_field_id('textarea'); ?>" name="<?php echo $this->get_field_name('textarea'); ?>"><?php echo $textarea; ?></textarea>
		</p>

	    <p>
	    <label for="<?php echo $this->get_field_id('image_uri'); ?>"><?php _e('Image:', 'rescue'); ?></label><br />
		<?php if ( $image_uri ) { ?>
		    <img class="custom_media_image" src="<?php echo $image_uri; ?>" style="margin:2em 0;padding:0;width:100px;float:left;display:inline-block" />
		<?php } ?>
	    <input type="text" class="widefat custom_media_url" name="<?php echo $this->get_field_name('image_uri'); ?>" id="<?php echo $this->get_field_id('image_uri'); ?>" value="<?php echo $image_uri; ?>">
	    </p>

	    <p>
	    <input type="button" value="<?php _e( 'Insert Image', 'rescue' ); ?>" class="button custom_media_upload" id="custom_image_uploader"/>
	    </p><br />

		<p>
		<label for="<?php echo $this->get_field_id('social'); ?>"><?php _e('Other Details:', 'rescue'); ?></label><br />
		</p>

		<p>
        <label for="<?php echo $this->get_field_id( 'icon' ); ?>"><?php _e('Icon', 'rescue'); ?>: Enter any icon name from the <a href="http://fortawesome.github.io/Font-Awesome/icons/" target="_blank">Font Awesome</a> list</label> 
        <input class="widefat" id="<?php echo $this->get_field_id( 'icon' ); ?>" name="<?php echo $this->get_field_name( 'icon' ); ?>" type="text" value="<?php echo esc_attr( $icon ); ?>" placeholder="e.g. fa-cloud" />
		</p>

		<p>
        <label for="<?php echo $this->get_field_id( 'link' ); ?>"><?php _e('Link', 'rescue'); ?></label> 
        <input class="widefat" id="<?php echo $this->get_field_id( 'link' ); ?>" name="<?php echo $this->get_field_name( 'link' ); ?>" type="text" value="<?php echo esc_attr( $link ); ?>" placeholder="e.g. https://rescuethemes.com" />
		</p>

	<?php
	}// end admin area form

	// Widget Update
	function update($new_instance, $old_instance) {
	    $instance = $old_instance;
	    // Fields
	    $instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags($new_instance['title']): '';
	    $instance['textarea'] = ( ! empty( $new_instance['textarea'] ) ) ? strip_tags($new_instance['textarea'], '<a>, <strong>'): '';
	   	$instance['image_uri'] = ( ! empty( $new_instance['image_uri'] ) ) ? strip_tags( $new_instance['image_uri'] ) : '';
	   	$instance['icon'] = ( ! empty( $new_instance['icon'] ) ) ? strip_tags( $new_instance['icon'] ) : '';
	   	$instance['link'] = ( ! empty( $new_instance['link'] ) ) ? strip_tags( $new_instance['link'] ) : '';
	    return $instance;
	}

	// Output the content on frontend
	function widget($args, $instance) {
	   extract( $args );

	   // Widget options
	   $title = apply_filters('widget_title', $instance['title']);
	   $textarea = $instance['textarea'];
	   $image_uri = $instance['image_uri'];
	   $icon = $instance['icon']; 
	   $link = $instance['link']; 

	   echo $before_widget;
	   // Display the widget
	   echo '<div class="reveal show-for-large-up">';

		   // echo $link;
		   echo '<a class="reveal-box" href="'.$link.'">';

		   // Check if title is set
		   if ( $title ) {
		      echo '<h4>'.$title.'</h4>';
		   }

		   // Check if image is set
		   if( $image_uri ) {
				$params = array( 'width' => 325, 'height' => 195, 'quality' => 100 );
		     echo '<figure><img width="325" height="195" class="alignleft" src="'.bfi_thumb( $image_uri, $params ).'" /></figure>';
		   }

	   echo '<dl>';

		   // Check if icon is set
		   if( $icon ) {
		     // echo $icon;
		   	echo '<dt><span class="reveal-icon"><i class="fa '.$icon.'"></i></span></dt>';
		   } else {
		   	echo '<dt><span class="reveal-icon"><i class="fa fa-paw"></i></span></dt>';
		   }

		   // Check if textarea is set
		   if( $textarea ) {
		     // echo $textarea;
		   	echo '<dd>'.$textarea.'</dd>';
		   }

	   echo '</dl>';

	   echo '</a><!-- .reveal-box .mind -->';

	   echo '</div><!-- .reveal .show-for-large-up -->';
	   echo $after_widget;
	} // end frontend output
}// end class

// Register widget
add_action('widgets_init', create_function('', 'return register_widget("rescue_reveal_plugin");'));

// Load scripts in admin area
if( !function_exists ('rescue_reveal_scripts') ) :
	function rescue_reveal_scripts(){

	  wp_enqueue_media();
	  // Media upload script
	  wp_enqueue_script('rescue_reveal_upload', plugin_dir_url( __FILE__ ) . 'js/image-upload-widget.js');

	}
	add_action('admin_enqueue_scripts', 'rescue_reveal_scripts');
endif; // end rescue_reveal_scripts

// Load styles in frontend
if( !function_exists ('rescue_reveal_styles') ) :
	function rescue_reveal_styles() {

		wp_enqueue_style('rescue_reveal_style', plugin_dir_url( __FILE__ ) . 'css/style.css');
		wp_enqueue_style( 'font_awesome', plugin_dir_url( __FILE__ ) . 'css/font-awesome.min.css', array(), '4.1.0', 'all' );

	}
	add_action('wp_enqueue_scripts', 'rescue_reveal_styles');
endif; // end rescue_reveal_styles

// Include all files in the /inc/ folder: Image Resizing 
foreach ( glob( plugin_dir_path( __FILE__ ) . "inc/*.php" ) as $file ) {
    include_once $file;
}

/* EOF */