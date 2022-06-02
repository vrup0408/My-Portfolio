<?php
namespace WTS_EAE;

use WPML_Elementor_Module_With_Items;

class WPML_EAE_Chart extends WPML_Elementor_Module_With_Items {

	public function get_items_field() {
		//return [ 'header_data','body_row_data' ];
        return 'dataset';
	}

	public function get_fields() {
		//return [ 'head_column_name','body_column_name'];
        return [ 'dataset_label'];
	}

	protected function get_title( $field ) {

		switch ( $field ) {

			case 'dataset_label':
				return esc_html__( 'Chart : Label', 'wts-eae' );
            // case 'slide_button_text':
            //     return esc_html__( 'Thumbnail Slider : Button Text', 'wts-eae' );
            // case 'slide_link':
            //         return esc_html__( 'Thumbnail Slider : Slide Link', 'wts-eae' );

			default:
				return '';
		}
	}

    protected function get_editor_type( $field ) {
        
		switch ( $field ) {

			case 'dataset_label':
				return 'LINE';
            // case 'slide_button_text':
            //     return 'LINE';
            // case 'slide_link':
            //     return 'LINE';    

			default:
				return '';
		}
	}
}