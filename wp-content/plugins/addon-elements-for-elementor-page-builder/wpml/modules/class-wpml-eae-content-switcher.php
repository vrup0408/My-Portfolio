<?php
namespace WTS_EAE;

use WPML_Elementor_Module_With_Items;

class WPML_EAE_Content_Switcher extends WPML_Elementor_Module_With_Items {

	public function get_items_field() {
		return 'content_list';
	}

	public function get_fields() {
		return [ 'title','plain_content'];
	}

	protected function get_title( $field ) {

		switch ( $field ) {

			case 'title':
				return esc_html__( 'Content Switcher : Title', 'wts-eae' );
			case 'plain_content':
				return esc_html__( 'Content Switcher : Plain Text', 'wts-eae' );

			default:
				return '';
		}
	}

    protected function get_editor_type( $field ) {
        
		switch ( $field ) {

			case 'title':
				return 'LINE';
            case 'plain_content':
                return 'AREA';  
			default:
				return '';
		}
	}
}