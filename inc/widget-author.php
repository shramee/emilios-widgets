<?php
/**
 * Widget to display Post Author info
 */

/** Register the widget */
add_action( 'widgets_init', 'Widget_Wixbu_Author::register_widget' );

/**
 * Class Widget_Wixbu_Author
 */
class Widget_Wixbu_Author extends WP_Widget {
	/** Basic Widget Settings */
	const WIDGET_NAME = "Post Author";
	const WIDGET_DESCRIPTION = "Displays post author data.";
	var $textdomain;
	var $fields;

	public static function register_widget() {
		register_widget("Widget_Wixbu_Author");
	}

	/**
	 * Construct the widget
	 */
	function __construct() {
		//We're going to use $this->textdomain as both the translation domain and the widget class name and ID
		$this->textdomain = strtolower( get_class( $this ) );
		//Translations
		load_plugin_textdomain( $this->textdomain, false, basename( dirname( __FILE__ ) ) . '/languages' );
		//Init the widget
		parent::__construct( $this->textdomain, __( self::WIDGET_NAME, $this->textdomain ), array(
			'description' => __( self::WIDGET_DESCRIPTION, $this->textdomain ),
			'classname'   => $this->textdomain
		) );
	}

	/**
	 * Adds a text field to the widget
	 *
	 * @param $field_name
	 * @param string $field_description
	 * @param string $field_default_value
	 * @param string $field_type
	 */
	private function add_field( $field_name, $field_description = '', $field_default_value = '', $field_type = 'text' ) {
		if ( ! is_array( $this->fields ) ) {
			$this->fields = array();
		}
		$this->fields[ $field_name ] = array(
			'name'          => $field_name,
			'description'   => $field_description,
			'default_value' => $field_default_value,
			'type'          => $field_type
		);
	}

	/**
	 * Widget frontend
	 *
	 * @param array $args
	 * @param array $instance
	 */
	public function widget( $args, $instance ) {
		$instance['title'] = $instance['title'] ? $instance['title'] : __( 'Course Description' );
		$title = apply_filters( 'widget_title', $instance['title'] );
		/* Before and after widget arguments are usually modified by themes */
		echo $args['before_widget'];
		/* Widget output here */
		$this->widget_output( $args, $instance );
		/* After widget */
		echo $args['after_widget'];
	}

	/**
	 * This function will execute the widget frontend logic.
	 * Everything you want in the widget should be output here.
	 */
	private function widget_output( $args, $instance ) {
		$author_email = get_the_author_meta( 'email' );
		$author_name = get_the_author_meta( 'display_name' );
		$author_desc = get_the_author_meta( 'description' );
		if ( function_exists( 'get_wp_user_avatar_src' ) ) {
			$author_pic = get_wp_user_avatar_src();
		}
		if ( ! $author_pic ) {
			$author_pic = get_avatar( $author_email, 400 );
		}

		echo "<div class='wixbu-author-pic widget-title' style='background-image:url($author_pic);'></div>";

		if ( ! empty( $author_name ) ) {
			echo $args['before_title'] . $author_name . $args['after_title'];
		}
		?>
		<div class="wixbu-section">
			<?php echo $author_desc; ?>
		</div>
		<?php
	}

	/**
	 * Widget backend
	 *
	 * @param array $instance
	 *
	 * @return string|void
	 */
	public function form( $instance ) {
		/* Generate admin for fields */
		foreach ( $this->fields as $field_name => $field_data ) {
			if ( $field_data['type'] === 'text' ):
				?>
				<p>
					<label
						for="<?php echo $this->get_field_id( $field_name ); ?>"><?php _e( $field_data['description'], $this->textdomain ); ?></label>
					<input class="widefat" id="<?php echo $this->get_field_id( $field_name ); ?>"
								 name="<?php echo $this->get_field_name( $field_name ); ?>" type="text"
								 value="<?php echo esc_attr( isset( $instance[ $field_name ] ) ? $instance[ $field_name ] : $field_data['default_value'] ); ?>"/>
				</p>
				<?php
			//elseif($field_data['type'] == 'textarea'):
			//You can implement more field types like this.
			else:
				echo __( 'Error - Field type not supported', $this->textdomain ) . ': ' . $field_data['type'];
			endif;
		}
	}

	/**
	 * Updating widget by replacing the old instance with new
	 *
	 * @param array $new_instance
	 * @param array $old_instance
	 *
	 * @return array
	 */
	public function update( $new_instance, $old_instance ) {
		return $new_instance;
	}
}