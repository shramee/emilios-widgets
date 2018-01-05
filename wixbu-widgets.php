<?php
/*
Plugin Name: Wixbu Widgets and Customizations
Plugin URI: http://shramee.me/
Description: Simple plugin starter for quick delivery
Author: Shramee
Version: 1.0.0
Author URI: http://shramee.me/
@developer shramee <shramee.srivastav@gmail.com>
*/

/** Plugin admin class */
require 'inc/class-admin.php';
/** Plugin public class */
require 'inc/class-public.php';
/** Sidebar description widget */
require 'inc/widget-description.php';
/** Author widget */
require 'inc/widget-author.php';

/**
 * Wixbu Widgets and Customizations main class
 * @static string $token Plugin token
 * @static string $file Plugin __FILE__
 * @static string $url Plugin root dir url
 * @static string $path Plugin root dir path
 * @static string $version Plugin version
 */
class Wixbu_Customizations{

	/** @var Wixbu_Customizations Instance */
	private static $_instance = null;

	/** @var string Token */
	public static $token;

	/** @var string Version */
	public static $version;

	/** @var string Plugin main __FILE__ */
	public static $file;

	/** @var string Plugin directory url */
	public static $url;

	/** @var string Plugin directory path */
	public static $path;

	/** @var Wixbu_Customizations_Admin Instance */
	public $admin;

	/** @var Wixbu_Customizations_Public Instance */
	public $public;

	/**
	 * Return class instance
	 * @return Wixbu_Customizations instance
	 */
	public static function instance( $file ) {
		if ( null == self::$_instance ) {
			self::$_instance = new self( $file );
		}
		return self::$_instance;
	}

	/**
	 * Constructor function.
	 * @param string $file __FILE__ of the main plugin
	 * @access  private
	 * @since   1.0.0
	 */
	private function __construct( $file ) {

		self::$token   = 'wbwc';
		self::$file    = $file;
		self::$url     = plugin_dir_url( $file );
		self::$path    = plugin_dir_path( $file );
		self::$version = '1.0.0';

		$this->_admin(); //Initiate admin
		$this->_public(); //Initiate public

	}

	/**
	 * Initiates admin class and adds admin hooks
	 */
	private function _admin() {
		//Instantiating admin class
		$this->admin = Wixbu_Customizations_Admin::instance();

		//Enqueue admin end JS and CSS
		add_action( 'admin_enqueue_scripts',	array( $this->admin, 'enqueue' ) );

		//Add sidebar description field in course options
		add_filter( 'llms_metabox_fields_lifterlms_course_options', array( $this->admin, 'sidebar_description_field' ) );

		//Save sidebar description field
		add_action( 'save_post', array( $this->admin, 'save_post' ) );

	}

	/**
	 * Initiates public class and adds public hooks
	 */
	private function _public() {
		//Instantiating public class
		$this->public = Wixbu_Customizations_Public::instance();

		//Enqueue front end JS and CSS
		add_action( 'wp_enqueue_scripts',	array( $this->public, 'enqueue' ) );
		remove_action( 'lifterlms_single_lesson_before_summary', 'lifterlms_template_single_parent_course', 10 );
		add_action( 'lifterlms_single_lesson_before_summary', array( $this->public, 'back_to_parent' ), 7 );

	}
}

/** Intantiating main plugin class */
Wixbu_Customizations::instance( __FILE__ );
