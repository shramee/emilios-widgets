<?php
/**
 * Wixbu Widgets and Customizations Admin class
 */
class Wixbu_Customizations_Admin {

	/** @var Wixbu_Customizations_Admin Instance */
	private static $_instance = null;

	/* @var string $token Plugin token */
	public $token;

	/* @var string $url Plugin root dir url */
	public $url;

	/* @var string $path Plugin root dir path */
	public $path;

	/* @var string $version Plugin version */
	public $version;

	/**
	 * Main Wixbu Widgets and Customizations Instance
	 * Ensures only one instance of Storefront_Extension_Boilerplate is loaded or can be loaded.
	 * @return Wixbu_Customizations_Admin instance
	 * @since 	1.0.0
	 */
	public static function instance() {
		if ( null == self::$_instance ) {
			self::$_instance = new self();
		}
		return self::$_instance;
	} // End instance()

	/**
	 * Constructor function.
	 * @access  private
	 * @since 	1.0.0
	 */
	private function __construct() {
		$this->token   =   Wixbu_Customizations::$token;
		$this->url     =   Wixbu_Customizations::$url;
		$this->path    =   Wixbu_Customizations::$path;
		$this->version =   Wixbu_Customizations::$version;
	} // End __construct()

	/**
	 * Adds front end stylesheet and js
	 * @action wp_enqueue_scripts
	 */
	public function enqueue() {
		$token = $this->token;
		$url = $this->url;

		wp_enqueue_style( $token . '-css', $url . '/assets/admin.css' );
		wp_enqueue_script( $token . '-js', $url . '/assets/admin.js', array( 'jquery' ) );
	}

	public function admin_body_class( $classes ) {
		$user = wp_get_current_user();
		return $classes . " user-role-{$user->roles[0]}";
	}

	public function sidebar_description_field( $content ) {

		/** Sidebar descripiton field class */
		require 'class-sidebar-description-field.php';

		$content[0]['fields'][] = [
			'type'		=> 'sidebar-description',
			'label'		=> __( 'Sidebar description', 'lifterlms' ),
			'desc' 		=> __( 'This description will be shown in the sidebar.', 'lifterlms' ),
			'id' 		=> '_wixbu_sidebar_desc',
		];
		return $content;
	}

	public function save_post() {
		if ( isset( $_POST['post_ID'] ) ) {
			update_post_meta(
				$_POST['post_ID'],
				'_wixbu_sidebar_desc',
				filter_input( INPUT_POST, '_wixbu_sidebar_desc' )
			);
		}

	}
}