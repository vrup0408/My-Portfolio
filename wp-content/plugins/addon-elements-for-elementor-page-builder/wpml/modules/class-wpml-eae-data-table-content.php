<?php
namespace WTS_EAE;

use WPML_Elementor_Module_With_Items;

class WPML_EAE_Data_Table_Content extends WPML_Elementor_Module_With_Items {

	public function get_items_field() {
		//return [ 'header_data','body_row_data' ];
       return 'body_row_data';
	}

	public function get_fields() {
		//return [ 'head_column_name','body_column_name'];
       return ['body_column_name'];
	}

	protected function get_title( $field ) {

		switch ( $field ) {

			// case 'head_column_name':
			// 	return esc_html__( 'Data Table : Text', 'wts-eae' );
			case 'body_column_name':
			 	return esc_html__( 'Data Table - Body : Text', 'wts-eae' );
            

			default:
				return '';
		}
	}

    protected function get_editor_type( $field ) {
        
		switch ( $field ) {

			// case 'head_column_name':
			// 	return 'LINE';
            case 'body_column_name':
                 return 'LINE';

			default:
				return '';
		}
	}
}