<?php
namespace WTS_EAE;

use WPML_Elementor_Module_With_Items;

class WPML_EAE_Thumbnail_Slider extends WPML_Elementor_Module_With_Items {

	public function get_items_field() {
		return 'slides';
	}

	public function get_fields() {
		return [ 'slide_heading','slide_description', 'slide_button_text', 'slide_link' => array('url') ];
	}

	protected function get_title( $field ) {

		switch ( $field ) {

			case 'slide_heading':
				return esc_html__( 'Thumbnail Slider : Heading & Description', 'wts-eae' );
			case 'slide_description':
				return esc_html__( 'Thumbnail Slider : Description', 'wts-eae' );
            case 'slide_button_text':
                return esc_html__( 'Thumbnail Slider : Button Text', 'wts-eae' );
            case 'url':
                    return esc_html__( 'Thumbnail Slider : Slide Link', 'wts-eae' );

			default:
				return '';
		}
	}

    protected function get_editor_type( $field ) {
        
		switch ( $field ) {

			case 'slide_heading':
				return 'LINE';
            case 'slide_description':
                return 'AREA';
            case 'slide_button_text':
                return 'LINE';
            case 'url':
                return 'LINK';    

			default:
				return '';
		}
	}
}