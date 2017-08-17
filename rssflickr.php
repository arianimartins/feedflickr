<?php
/*
Plugin Name: Ariani Martins - Feed Flickr RSS
Plugin URI:  http://arianimartins.com
Description: Feed do Flickr
Author: Ariani Martins
Author URI: http://arianimartins.com
*/

require_once "getfeed.php";

class Feed_Flickr_Widget extends WP_Widget{

	function __construct(){
		parent::__construct(
            'Feed_Flickr_Widget',
            __('Feed Flickr - RSS', 'translation_domain'),
            array('description' => 'Exibe as suas fotos do flickr em uma widget área', 'translation_domain')
        );
	}

	public function form($instance){
		isset($instance['title']) ? $title = $instance['title'] : null;
		empty($instance['title']) ? $title = 'Flickr' : null;

        isset($instance['feed_url']) ? $feed_url = $instance['feed_url'] : null;
        isset($instance['user_id']) ? $user_id = $instance['user_id'] : null;
        isset($instance['tags']) ? $tags = $instance['tags'] : null;
        isset($instance['quantidade']) ? $quantidade = $instance['quantidade'] : null;

        ?>

        <!-- TÍTULO -->
        <p>
        	<label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Título:'); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>">
        </p>

        <!-- URL -->
        <p>
            <label for="<?php echo $this->get_field_id('feed_url'); ?>"><?php _e('URL do Feed:'); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id('feed_url'); ?>" name="<?php echo $this->get_field_name('feed_url'); ?>" type="text" value="<?php echo esc_attr($feed_url); ?>">
        </p>
        
        <!-- USER ID -->
        <p>
            <label for="<?php echo $this->get_field_id('user_id'); ?>"><?php _e('ID do Usuário:'); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id('user_id'); ?>" name="<?php echo $this->get_field_name('user_id'); ?>" type="text" value="<?php echo esc_attr($user_id); ?>">
        </p>
 
        <!-- TAGS -->
        <p>
            <label for="<?php echo $this->get_field_id('tags'); ?>"><?php _e('Tags:'); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id('tags'); ?>" name="<?php echo $this->get_field_name('tags'); ?>" type="text" value="<?php echo esc_attr($tags); ?>">
        </p>

        <!-- QUANTIDADE -->
        <p>
            <label for="<?php echo $this->get_field_id('quantidade'); ?>"><?php _e('Quantidade de fotos desejadas:'); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id('quantidade'); ?>" name="<?php echo $this->get_field_name('quantidade'); ?>" type="text" value="<?php echo esc_attr($quantidade); ?>">
        </p>

        <?php
	}

	public function update($new_instance, $old_instance){
		$instance = array();
		$instance['title'] = (!empty($new_instance['title']) ) ? strip_tags($new_instance['title']) : '';
        $instance['feed_url'] = (!empty($new_instance['feed_url']) ) ? strip_tags($new_instance['feed_url']) : '';
        $instance['user_id'] = (!empty($new_instance['user_id']) ) ? strip_tags($new_instance['user_id']) : '';
        $instance['tags'] = (!empty($new_instance['tags']) ) ? strip_tags($new_instance['tags']) : '';
        $instance['quantidade'] = (!empty($new_instance['quantidade']) ) ? strip_tags($new_instance['quantidade']) : '';

        return $instance;
	}

	public function widget($args, $instance){
		$title = apply_filters('widget_title', $instance['title']);
        $feed_url = $instance['feed_url'];
        $user_id = $instance['user_id'];
        $tags = $instance['tags'];
        $quantidade = $instance['quantidade'];

        echo $args['before_widget'];
        echo $args['before_title'];
        echo $title;
        echo $args['after_title'];
            getFeed($user_id,$tags,$quantidade);
        echo $args['after_widget'];
	}

}

function feed_flickr_css(){
    wp_enqueue_style('feed-flickr', plugins_url('rssflickr.css', __FILE__));
}
add_action('wp_enqueue_scripts', 'feed_flickr_css');


function register_feed_flickr(){
    register_widget('Feed_Flickr_Widget');
}
add_action('widgets_init', 'register_feed_flickr');

?>