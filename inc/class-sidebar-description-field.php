<?php
if ( ! defined( 'ABSPATH' ) ) { exit; }

/**
 * Copied and modified from LifterLMS
 * Original class - LLMS_Metabox_Post_Content_Field
 */
class LLMS_Metabox_Sidebar_Description_Field extends LLMS_Metabox_Field implements Meta_Box_Field_Interface {

	/**
	 * Class constructor
	 * @param array $_field Array containing information about field
	 */
	function __construct( $_field ) {

		$this->field = $_field;

	}

	/**
	 * Outputs the Html for the given field
	 */
	public function output() {

		parent::output();

		$settings = array(
			'textarea_name'	=> $this->field['id'],
			'quicktags' 	=> array(
				'buttons' => 'em,strong,link',
			),
			'tinymce' 	=> array(
				'theme_advanced_buttons1' => 'bold,italic,strikethrough,separator,bullist,numlist,separator,blockquote,separator,justifyleft,justifycenter,justifyright,separator,link,unlink,separator,undo,redo,separator',
				'theme_advanced_buttons2' => '',
			),
			'editor_css'	=> '<style>#wp-content-editor-container .wp-editor-area{height:300px; width:100%;}</style>',
			'drag_drop_upload' => true,
		);

		wp_editor( htmlspecialchars_decode( $this->meta ), $this->field['id'], apply_filters( 'lifterlms_course_full_description_editor_settings', $settings ) );

		parent::close_output();
	}
}

