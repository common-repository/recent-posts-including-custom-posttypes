<?php
/*
Plugin Name: RELATED POSTS
Plugin URI:
Version: 1.10
Description: Shows related posts quick and easy
Author: EnergieBoer
Author URI:
License: GPLv2

*/

define("DefNoOfPosts", "5");

class RecentPostsCPWidget extends WP_Widget {

	function RecentPostsCPWidget()
	{
		parent::WP_Widget( false, 'Related Posts',  array('description' => 'Related Posts') );
	}

	function widget($args, $instance)
	{
		global $NewRecentPostsCP;
		$title = empty( $instance['title'] ) ? 'Recent Posts including Custom PostTypes' : $instance['title'];
		echo $args['before_widget'];
		echo $args['before_title'] . $title . $args['after_title'];
		echo $NewRecentPostsCP->GetRecentPostsCP(  empty( $instance['ShowPosts'] ) ? DefNoOfPosts : $instance['ShowPosts'] );
		echo $args['after_widget'];
	}

	function update($new_instance)
	{
		return $new_instance;
	}

	function form($instance)
	{
		?>

		<p>
			<label for="<?php echo $this->get_field_id('title'); ?>"><?php echo 'Title:'; ?></label>
			<input type="text" name="<?php echo $this->get_field_name('title'); ?>" class="widefat" id="<?php echo $this->get_field_id('title'); ?>" value="<?php echo esc_attr($instance['title']); ?>" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('ShowPosts'); ?>"><?php echo 'Number of entries:'; ?></label>
			<input type="text" name="<?php echo $this->get_field_name('ShowPosts'); ?>" id="<?php echo $this->get_field_id('ShowPosts'); ?>" value="<?php if ( empty( $instance['ShowPosts'] ) ) { echo esc_attr(DefNoOfPosts); } else { echo esc_attr($instance['ShowPosts']); } ?>" size="3" />
		</p>

		<?php
	}

}



class RecentPostsCP {

	function GetRecentPostsCP($noofposts)
	{
		$post_types=get_post_types();
		$args = array( 'numberposts' => $noofposts , 'post_type' => $post_types, 'orderby' => 'rand');
		$recent_posts = wp_get_recent_posts( $args );
		echo '<ul>';
		foreach( $recent_posts as $recent ){
			echo '<li><a href="' . get_permalink($recent["ID"]) . '" title="'.esc_attr($recent["post_title"]).'" >' .   $recent["post_title"].'</a> </li> ';
		}
		echo '</ul>';
	}

}



$NewRecentPostsCP = new RecentPostsCP();

function RecentPostsCP_widgets_init()
{
	register_widget('RecentPostsCPWidget');
}

add_action('widgets_init', 'RecentPostsCP_widgets_init');


?>