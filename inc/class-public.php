<?php

/**
 * Wixbu Widgets and Customizations public class
 */
class Wixbu_Customizations_Public{

	/** @var Wixbu_Customizations_Public Instance */
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
	 * Wixbu Widgets and Customizations public class instance
	 * @return Wixbu_Customizations_Public instance
	 */
	public static function instance() {
		if ( null == self::$_instance ) {
			self::$_instance = new self();
		}
		return self::$_instance;
	}

	/**
	 * Constructor function.
	 * @access  private
	 * @since   1.0.0
	 */
	private function __construct() {
		$this->token   =   Wixbu_Customizations::$token;
		$this->url     =   Wixbu_Customizations::$url;
		$this->path    =   Wixbu_Customizations::$path;
		$this->version =   Wixbu_Customizations::$version;
	}

	/**
	 * Adds front end stylesheet and js
	 * @action wp_enqueue_scripts
	 */
	public function enqueue() {
		$token = $this->token;
		$url = $this->url;

		wp_enqueue_style( $token . '-css', $url . '/assets/front.css' );
		wp_enqueue_script( $token . '-js', $url . '/assets/front.js', array( 'jquery' ) );
	}

	public function the_excerpt( $excerpt ) {
		if ( has_excerpt() ) {
			return $excerpt;
		}
	}

	public function back_to_parent() {
		global $post;

		$lesson = new LLMS_Lesson( $post );

		printf( __( '<p class="llms-parent-course-link"><a class="llms-button-action llms-lesson-link" href="%1$s">VOLVER A CURSO</a></p>', 'lifterlms' ), get_permalink( $lesson->get_parent_course() ), get_the_title( $lesson->get_parent_course() ) );
	}

	public function lesson_title() {
		the_title( '<h2 class="lesson-title">', '</h2>' );
	}

	public function my_courses() {
		return LLMS_Shortcode_Courses::instance()->output( [ 'mine' => 'enrolled' ] );
	}
}