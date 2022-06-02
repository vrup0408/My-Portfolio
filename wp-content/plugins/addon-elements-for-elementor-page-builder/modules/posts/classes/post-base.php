<?php
namespace WTS_EAE\Modules\Posts\Classes;

class PostBase{
	private static $_instance = null;

	public static function instance() {
		if ( is_null( self::$_instance ) ) {
			self::$_instance = new self();
		}
		return self::$_instance;
	}

	private function __construct() {
		add_action( 'wp_ajax_eae_post_data', [ $this, 'ajax_eae_post_data' ] );
		add_action( 'wp_ajax_nopriv_eae_post_data', [ $this, 'ajax_eae_post_data' ] );
	}	

    public function get_post_types() {

		$types = [];

		$post_types = get_post_types( [ 'public' => true ], 'object' );

		$exclusions = [ 'attachment', 'elementor_library', 'ae_global_templates' ];

		foreach ( $post_types as $post_type ) {
			if ( in_array( $post_type->name, $exclusions, true ) ) {
				continue;
			}
			$types[ $post_type->name ] = $post_type->label;
		}

		return $types;
	}

    public function get_rules_taxonomies() {
		$args = [
			'public' => true,

		];
		$tax_array  = [];
		$taxonomies = get_taxonomies( $args, 'objects' );
		if ( is_array( $taxonomies ) && count( $taxonomies ) ) {
			foreach ( $taxonomies as $slug => $taxonomy ) {
				$tax_array[ $slug ] = $taxonomy->labels->name;
			}
		}
		return $tax_array;
	}

	public function get_all_taxonomies() {
		$ae_taxonomy_filter_args = [
			'show_in_nav_menus' => true,
		];

		return get_taxonomies( $ae_taxonomy_filter_args, 'objects' );
	}

	public function get_rule_post_types( $output = 'object' ) {
		$final_post_types = [];
		$all_post_types   = get_post_types( [ 'public' => true ], $output );

		$skip_post_types = [
			'attachment',
			'ae_global_templates',
			'elementor_library',
		];

		if ( $output === 'names' ) {
			return array_diff( $all_post_types, $skip_post_types );
		}

		foreach ( $all_post_types as $name => $post_type ) {
			if ( ! in_array( $name, $skip_post_types, true ) ) {
				$final_post_types[ $name ] = $post_type->label;
			}
		}

		return $final_post_types;
	}

	public function get_taxonomies_by_post_type( $post_type ) {
		$tax_array  = [];
		$taxonomies = get_object_taxonomies( $post_type, 'objects' );
		if ( isset( $taxonomies ) && count( $taxonomies ) ) {
			foreach ( $taxonomies as $tax ) {
				$tax_array[ $tax->name ] = $tax->label;
			}
		}
		return $tax_array;
	}
	
	public function get_taxonomy_terms( $taxonomy ) {

		$tax_array = [];
		$terms     = get_terms(
			[
				'taxonomy'   => $taxonomy,
				'hide_empty' => false,
			]
		);

		if ( count( $terms ) ) {
			foreach ( $terms as $term ) {
				$tax_array[ $term->term_id ] = $term->name;
			}
		}

		return $tax_array;
	}

	public function get_authors() {
		$user_query = new \WP_User_Query(
			[
				'who'                 => 'authors',
				'has_published_posts' => true,
				'fields'              => [
					'ID',
					'display_name',
				],
			]
		);

		$authors = [];

		foreach ( $user_query->get_results() as $result ) {
			$authors[ $result->ID ] = $result->display_name;
		}

		return $authors;
	}

	public function get_widget_admin_note_html( $note, $link = '', $link_text = 'Click Here' ) {
		$note = '<p class="ae-editor-note"><i>' . $note;
		if ( trim( $link ) !== '' ) {
			$note .= ' <a href="' . $link . '" target="_blank">' . $link_text . '</a>';
		}
		$note .= '</i></p>';

		return $note;
	}
}