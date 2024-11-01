<?php
/*
Plugin Name: t4xi_Latest_Tweets
Plugin URI: http://www.t4xi.com
Description: Add latest tweets in your sidebar.
Version: 1.2
Author: T4XI
Author URI: http://www.t4xi.com
*/

/**
 * Creamos el widget
 *
 */
class WP_Widget_Latest_Tweets extends WP_Widget {

	function __construct()
	{	
		wp_enqueue_script("jquery");
		wp_enqueue_script('wt_scripts', plugins_url("t4xi-latest-tweets/js/").'scripts.php');
		
		$opciones = array(
			'classname'     => 'wt_parent_box',
			'description'   => 'Add latest tweets in your sidebar.'
		);
		
		parent::__construct('wt_widget', __('t4xi_Twitter'), $opciones);

		
	}

	function widget($args, $instance)
	{
		/**
		 * Hacemos un extract para que los valores de los arrays esten disponibles
		 * como variables.
		 */
		
		extract($instance);
		
		$widget_name = $instance['widget_name'];
		$widget_id = $instance['widget_id'];
        $number_of_tweets = $instance['number_of_tweets'];
		$plugin_name = $instance['plugin_name'];
        $plugin_url   = $instance['plugin_url'];
        $follow_link   = $instance['follow_link'];

		// Mostramos el contenedor del widget (definido por el theme)
		echo $before_widget;
		
		
		// Mostramos el código html que se vera en cliente
	?>

		<div class="wt_box widget">
			<h3 class="widget-title"><? echo $widget_name; ?></h3>
			<a class="twitter-timeline" href="<? echo $plugin_url; ?>" data-tweet-limit="<? echo $number_of_tweets; ?>" data-widget-id="<? echo $widget_id; ?>" data-link-color="#ffffff"><? echo $plugin_name; ?></a>
			
			<? if ( $follow_link AND $follow_link == '1' ) { ?>
				<a href="<? echo $plugin_url; ?>" target="_blank"><? echo $plugin_name; ?></a>
				<!--<a href="https://twitter.com/hotelcondesbcn" class="twitter-follow-button" data-show-count="false" data-lang="es">Seguir a @hotelcondesbcn</a>-->
			<? } ?>
			
			<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+"://platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>

		</div>
		
	<?php
	
		// Mostramos el contenedor del widget (definido por el theme)
		echo $after_widget;
	}



	function update($new_instance, $old_instance)
	{
		$instance = $old_instance;
		
		$instance['widget_name']       = strip_tags( $new_instance['widget_name'] );
		$instance['widget_id']         = strip_tags( $new_instance['widget_id'] );
		$instance['number_of_tweets']  = strip_tags( $new_instance['number_of_tweets'] );
		$instance['plugin_name']       = strip_tags( $new_instance['plugin_name'] );
		$instance['plugin_url']        = strip_tags( $new_instance['plugin_url'] );
		$instance['follow_link']       = strip_tags( $new_instance['follow_link'] );

		return $instance;
	}

	function form($instance)
	{
		
		// Filtramos los valores para que se muestren correctamente en los formularios
		$instance['widget_name'] = esc_attr($instance['widget_name']);
		$instance['widget_id'] = esc_attr($instance['widget_id']);
		$instance['number_of_tweets']   = esc_attr($instance['number_of_tweets']);
		$instance['plugin_name'] = esc_attr($instance['plugin_name']);
		$instance['plugin_url']   = esc_attr($instance['plugin_url']);
		$instance['follow_link']   = esc_attr($instance['follow_link']);

		


		// Mostramos el formulario
		?>
		
		<p>
			<label for="<?php echo $this->get_field_id('widget_name'); ?>">Widget title:</label></p>
			<input value="<?php echo $instance['widget_name']; ?>" class="widefat" type="text" id="<?php echo $this->get_field_id('widget_name'); ?>" name="<?php echo $this->get_field_name('widget_name'); ?>">
		</p>	
	
		<p>
			<label for="<?php echo $this->get_field_id('widget_id'); ?>">Twitter Widget ID:</label></p>
			<input value="<?php echo $instance['widget_id']; ?>" class="widefat" type="text" id="<?php echo $this->get_field_id('widget_id'); ?>" name="<?php echo $this->get_field_name('widget_id'); ?>">
		</p>

		<p>
			<label for="<?php echo $this->get_field_id('number_of_tweets'); ?>">Number of tweets:</label></p>
			<input value="<?php echo $instance['number_of_tweets']; ?>" class="widefat" type="text" id="<?php echo $this->get_field_id('number_of_tweets'); ?>" name="<?php echo $this->get_field_name('number_of_tweets'); ?>">
		</p>

		<div style="padding: 5px 10px 10px 10px; margin-bottom: 10px; background: #e5e5e5;">
			<h3>Twitter link:</h3>
			<p>
				<input class="checkbox" type="checkbox" id="<?php echo $this->get_field_id('follow_link'); ?>" name="<?php echo $this->get_field_name('follow_link'); ?>" value="1" <?php checked('1', $instance['follow_link']); ?> >
				<label for="<?php echo $this->get_field_id('follow_link'); ?>">Show</label></p>
			</p>

			<p>
				<label for="<?php echo $this->get_field_id('plugin_name'); ?>">Display name:</label></p>
				<input value="<?php echo $instance['plugin_name']; ?>" class="widefat" type="text" id="<?php echo $this->get_field_id('plugin_name'); ?>" name="<?php echo $this->get_field_name('plugin_name'); ?>">
			</p>
			
			<p>
				<label for="<?php echo $this->get_field_id('plugin_url'); ?>">URL powered by Twitter:</label></p>
				<input value="<?php echo $instance['plugin_url']; ?>" class="widefat" type="text" id="<?php echo $this->get_field_id('plugin_url'); ?>" name="<?php echo $this->get_field_name('plugin_url'); ?>">
			</p>
		</div>
	
		
		<?php
	}

}

/**
 * Registramos el widget (Si no lo hacemos, WordPress no podrá detectarlo)
 * 
 */
 
function widget_register_twitter()
{
	register_widget('WP_Widget_Latest_Tweets');
}
add_action('widgets_init', 'widget_register_twitter');
