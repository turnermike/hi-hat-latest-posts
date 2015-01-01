<?php
/**
 * Hi-hat Latest Posts
 *
 * @package   Hi_Hat_Latest_Posts
 * @author    Mike Turner <turner.mike@gmail.com>
 * @license   GPL-2.0+
 * @link      http://hi-hatconsulting.com
 * @copyright 2014 Hi-hat Consulting
 */

class Hi_Hat_Latest_Posts_Widget extends WP_Widget{

	//constructor
	function Hi_Hat_Latest_Posts_Widget(){

		$name = __('Hi-hat Lastest Posts', 'hi-hat-latest-posts');
		$desc = __('A plugin for displaying the latest posts for a custom post type.', 'hi-hat-latest-posts');
		$class_name = 'hi-hat-latest-posts';
		parent::WP_Widget(false, $name, array('classname' => $class_name, 'description' => $desc));
	}

	//widget form creation
	function form($instance){

		// Check values
		if( $instance) {
		     $title = esc_attr($instance['title']);
		     if(isset($instance['post_qty'])){
		     	$post_qty = esc_attr($instance['post_qty']);
		     }
		     if(isset($instance['post_type'])){
		     	$post_type = esc_attr($instance['post_type']);
		     }
		     if(isset($instance['display_date'])){
		     	$display_date = $instance['display_date'];
		     }
		     if(isset($instance['display_excerpt'])){
		     	$display_excerpt = $instance['display_excerpt'];
		     }

		} else {
		     $title = '';
		     $post_type = '';
		     $display_date = '';
		     $display_excerpt = '';
		}
		?>
		<div class="hi-hat-latest-posts-wrapper">
		<!-- title -->
		<p>
		<label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title', 'hi-hat-latest-posts'); ?></label>
		<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" />
		</p>
		<!-- post qty -->
		<p>
		<label for="<?php echo $this->get_field_id('post_qty'); ?>"><?php _e('Number of Posts to Display', 'hi-hat-latest-posts'); ?></label>
		<input class="widefat" id="<?php echo $this->get_field_id('post_qty'); ?>" name="<?php echo $this->get_field_name('post_qty'); ?>" type="text" value="<?php echo $post_qty; ?>" />
		</p>
		<!-- post type -->
		<?php
			$args = array(
				'public'	=> true,
				'_builtin' 	=> false
			);
			$all_post_types = get_post_types($args, 'names', 'and');
			if($all_post_types) :
		?>
				<p>
				<label for="<?php echo $this->get_field_id('post_type'); ?>"><?php _e('Post Type', 'hi-hat-latest-posts'); ?></label>
				<select class="widefat" id="<?php echo $this->get_field_id('post_type'); ?>" name="<?php echo $this->get_field_name('post_type'); ?>">
				<option value=""></option>
				<?php
					$selected = '';
					foreach($all_post_types as $pt){
						echo "<option value='$pt' " . selected($post_type, $pt) . ">$pt</option>";
					}

				?>
				</select>
				</p>
		<?php
			endif;
		?>
		<!-- display date -->
		<?php
			$checked = '';
			if($display_date === 'true'){ $checked = ' checked="checked"'; }
		?>
		<p>
		<label for="<?php echo $this->get_field_id('display_date'); ?>" class="checkbox-label"><?php _e('Display the Post Date?', 'hi-hat-latest-posts'); ?></label>&nbsp;&nbsp;
		<input type="checkbox" id="<?php echo $this->get_field_id('display_date'); ?>" name="<?php echo $this->get_field_name('display_date'); ?>" <?php echo $checked; ?> />
		<div class="clearfix"></div>

		</p>
		<!-- display excerpt -->
		<?php
			$checked = '';
			if($display_excerpt === 'true'){ $checked = ' checked="checked"'; }
		?>
		<p>
		<label for="<?php echo $this->get_field_id('display_excerpt'); ?>" class="checkbox-label"><?php _e('Display the Excerpt?', 'hi-hat-latest-posts'); ?></label>&nbsp;&nbsp;
		<input type="checkbox" id="<?php echo $this->get_field_id('display_excerpt'); ?>" name="<?php echo $this->get_field_name('display_excerpt'); ?>" <?php echo $checked; ?> />
		<div class="clearfix"></div>
		</p>

		<p>This widget is used to display the latest posts for a user defined post type. There are no required fields. If values are not provided, defaults will be used.</p>
		</div>

		<?php
	}

	//widget update
	function update($new_instance, $old_instance){

		$instance = $old_instance;

		// Fields
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['post_qty'] = strip_tags($new_instance['post_qty']);
		$instance['post_type'] = strip_tags($new_instance['post_type']);
		$instance['display_date'] = $new_instance['display_date'] ? 'true' : 'false';
		$instance['display_excerpt'] = $new_instance['display_excerpt'] ? 'true' : 'false';

		return $instance;

	}

	//widget display
	function widget($args, $instance){

		global $post;
		extract( $args );

		//default values
		$default_values = array(
			'title'				=> 'Latest Posts',
			'post_qty'			=> 4,
			'post_type' 		=> 'posts',
			'display_date'		=> true,
			'display_excerpt' 	=> false
		);

		// get the widget values
		$title = $instance['title'];
		$post_qty = $instance['post_qty'];
		$post_type = $instance['post_type'];
		$display_date = ($instance['display_date'] === 'true') ? 'true' : 'false';
		$display_excerpt = ($instance['display_excerpt'] === 'true') ? 'true' : 'false';

		//assign defaults if user data is not set
		if(!$title){
			$title = $default_values['title'];
		}
		if(!$post_qty){
			$post_qty = $default_values['post_qty'];
		}
		if(!$post_type){
			$post_type = $default_values['post_type'];
		}

		// query
		$args = array(
			'post_type'			=> $post_type,
			'post_status' 		=> 'publish',
			'posts_per_page'	=> $post_qty,
			'orderby'			=> 'post_date',
			'order'				=> 'DESC'

		);
		$results = new WP_Query($args);

		echo $before_widget;

		echo $before_title . $title , $after_title;

		if($results->have_posts()){

			echo "<ul>";

			while($results->have_posts()) : $results->the_post();

				echo "<li>";
				// taxonomy names are the post_name with the type of taxonomy appended to it
				// for example the taxonomy name for Buyer/Seller News Categories is buyer-seller-news-category
				// that's the post_name 'buyer-seller-news' with '-category' appended to the end if it
				// echo get_term_links($post->ID, $post_type . '-category');

				if($display_date === 'true'){
	                $date = mysql2date('F j, Y', $post->post_date);
	                echo "<p class='post_date'>$date</p>";
				}
				$title = get_the_title();
				if($title) echo "<h1><a href='" . get_the_permalink() . "'>$title</a></h1>";
				if($display_excerpt === 'true'){
					echo wpautop(get_the_excerpt());
				}

				// echo "Topics: " . get_term_links($post->ID, $post_type . '-tag');

				echo "</li>";

			endwhile;

			echo "</ul>";


		}else{
			echo "<p>There are no posts matching your criteria. Please try tweaking the widget settings.</p>";
		}

		echo $after_widget;
	}

}

add_action('widgets_init', create_function('', 'return register_widget("Hi_Hat_Latest_Posts_Widget");'));




/**
 * Plugin class. This class should ideally be used to work with the
 * public-facing side of the WordPress site.
 *
 * If you're interested in introducing administrative or dashboard
 * functionality, then refer to `class-plugin-name-admin.php`
 *
 * @TODO: Rename this class to a proper name for your plugin.
 *
 * @package Hi_Hat_Latest_Posts
 * @author  Your Name <email@example.com>
 */
class Hi_Hat_Latest_Posts {

	/**
	 * Plugin version, used for cache-busting of style and script file references.
	 *
	 * @since   1.0.0
	 *
	 * @var     string
	 */
	const VERSION = '1.0.0';

	/**
	 *
	 * Unique identifier for your plugin.
	 *
	 *
	 * The variable name is used as the text domain when internationalizing strings
	 * of text. Its value should match the Text Domain file header in the main
	 * plugin file.
	 *
	 * @since    1.0.0
	 *
	 * @var      string
	 */
	protected $plugin_slug = 'hi-hat-latest-posts';

	/**
	 * Instance of this class.
	 *
	 * @since    1.0.0
	 *
	 * @var      object
	 */
	protected static $instance = null;

	/**
	 * Initialize the plugin by setting localization and loading public scripts
	 * and styles.
	 *
	 * @since     1.0.0
	 */
	private function __construct() {

		// enqueue admin styles
		add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_admin_styles' ) );
		// enqueue public styles
		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_public_styles' ) );
	}

	/**
	 * Return the plugin slug.
	 *
	 * @since    1.0.0
	 *
	 * @return    Plugin slug variable.
	 */
	public function get_plugin_slug() {
		return $this->plugin_slug;
	}

	/**
	 * Return an instance of this class.
	 *
	 * @since     1.0.0
	 *
	 * @return    object    A single instance of this class.
	 */
	public static function get_instance() {

		// If the single instance hasn't been set, set it now.
		if ( null == self::$instance ) {
			self::$instance = new self;
		}

		return self::$instance;
	}

	/**
	 * Fired when the plugin is activated.
	 *
	 * @since    1.0.0
	 *
	 * @param    boolean    $network_wide    True if WPMU superadmin uses
	 *                                       "Network Activate" action, false if
	 *                                       WPMU is disabled or plugin is
	 *                                       activated on an individual blog.
	 */
	public static function activate( $network_wide ) {

		if ( function_exists( 'is_multisite' ) && is_multisite() ) {

			if ( $network_wide  ) {

				// Get all blog ids
				$blog_ids = self::get_blog_ids();

				foreach ( $blog_ids as $blog_id ) {

					switch_to_blog( $blog_id );
					self::single_activate();

					restore_current_blog();
				}

			} else {
				self::single_activate();
			}

		} else {
			self::single_activate();
		}

	}

	/**
	 * Fired when the plugin is deactivated.
	 *
	 * @since    1.0.0
	 *
	 * @param    boolean    $network_wide    True if WPMU superadmin uses
	 *                                       "Network Deactivate" action, false if
	 *                                       WPMU is disabled or plugin is
	 *                                       deactivated on an individual blog.
	 */
	public static function deactivate( $network_wide ) {

		if ( function_exists( 'is_multisite' ) && is_multisite() ) {

			if ( $network_wide ) {

				// Get all blog ids
				$blog_ids = self::get_blog_ids();

				foreach ( $blog_ids as $blog_id ) {

					switch_to_blog( $blog_id );
					self::single_deactivate();

					restore_current_blog();

				}

			} else {
				self::single_deactivate();
			}

		} else {
			self::single_deactivate();
		}

	}

	/**
	 * Get all blog ids of blogs in the current network that are:
	 * - not archived
	 * - not spam
	 * - not deleted
	 *
	 * @since    1.0.0
	 *
	 * @return   array|false    The blog ids, false if no matches.
	 */
	private static function get_blog_ids() {

		global $wpdb;

		// get an array of blog ids
		$sql = "SELECT blog_id FROM $wpdb->blogs
			WHERE archived = '0' AND spam = '0'
			AND deleted = '0'";

		return $wpdb->get_col( $sql );

	}

	/**
	 * Fired for each blog when the plugin is activated.
	 *
	 * @since    1.0.0
	 */
	private static function single_activate() {

		//debug
		ob_start();

	}

	/**
	 * Fired for each blog when the plugin is deactivated.
	 *
	 * @since    1.0.0
	 */
	private static function single_deactivate() {

	}

	/**
	 * Register and enqueue public-facing style sheet.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_public_styles() {
		wp_enqueue_style($this->plugin_slug . '-public-styles', plugins_url('styles.css', __FILE__), array(), '1.0.0');
	}

	/**
	 * Register and enqueue admin style sheet.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_admin_styles() {
		wp_enqueue_style($this->plugin_slug . '-admin-styles', plugins_url('../admin/styles.css', __FILE__), array(), '1.0.0');
	}



}