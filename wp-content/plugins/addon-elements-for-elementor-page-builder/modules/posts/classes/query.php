<?php
namespace WTS_EAE\Modules\Posts\Classes;


use Elementor\Plugin;

class Query {

	private $settings = [];

	public function __construct( $settings ) {

		$this->settings = $settings;
	}

	public function get_posts() {
        //echo "<pre>"; print_r($this->settings); echo "</pre>";    
        $query_args = $this->build_query();    
    }
    
    public function build_query(){
        $source     = $this->settings['source'];
		$query_args = [];
        switch ( $source ) {
			// case 'current_loop':
			// 	if ( ! Plugin::instance()->editor->is_edit_mode() ) {
			// 								global $wp_query;
			// 								$main_query = clone $wp_query;
			// 								$post_items = $main_query;

			// 	} else {
			// 		$query_args = $this->get_preview_query();
			// 	}
			// 	break;

			// case 'manual_selection':
			// 	$query_args = $this->manual_selection_query();
			// 	break;

			// case 'related':
			// 	$query_args = $this->related_query();
			// 	break;


			default:
				$query_args = $this->post_query();
				break;
		}

		return $query_args;
    }

    private function post_query() {

		$settings = $this->settings;
		$paged    = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : '';

		$paged                     = $this->get_current_page_num();
		$query_args['post_status'] = 'publish'; // Hide drafts/private posts for admins
		$query_args['post_type']   = $settings['source'];

		// Include Author
		if ( is_array( $settings['include_author_ids'] ) && count( $settings['include_author_ids'] ) ) {
			$query_args['author'] = implode( ',', $settings['include_author_ids'] );
		}

		// Taxonomy Parameters (Taxonomy Query )
		$selected_terms = [];
		$post_type      = $settings['source'];
		$selected_tax   = $settings[ $post_type . '_tax_ids' ];
        

		/* Filter Bar */
		// When there is Term Id in $_POST
		// if ( isset( $settings['filter_taxonomy'] ) && ( isset( $_POST['term_id'] ) && $_POST['term_id'] >= 0 ) ) {

		// 	if ( $_POST['term_id'] != 0 ) {
		// 		$selected_terms['relation'] = 'AND';
		// 		$selected_terms[]           = [
		// 			'taxonomy' => $settings['filter_taxonomy'],
		// 			'field'    => 'term_id',
		// 			'terms'    => $_POST['term_id'],
		// 		];
		// 	}
		// 	// When there is default term selected
		// } elseif ( isset( $settings[ $settings['filter_taxonomy'] . '_filter_default_term' ] ) && $settings[ $settings['filter_taxonomy'] . '_filter_default_term' ] !== '' && $settings[ $settings['filter_taxonomy'] . '_filter_default_term' ] != 0 ) {
		// 	$selected_terms['relation'] = 'AND';
		// 	$selected_terms[]           = [
		// 		'taxonomy' => $settings['filter_taxonomy'],
		// 		'field'    => 'term_id',
		// 		'terms'    => $settings[ $settings['filter_taxonomy'] . '_filter_default_term' ],
		// 	];
		// 	// When there is 'All' tab is disabled
		// } elseif ( isset( $settings['show_all'] ) && $settings['show_all'] !== 'yes' ) {
		// 	$filter_terms               = Aepro::$_helper->get_filter_bar_filters( $settings );
		// 	$selected_terms['relation'] = 'AND';
		// 	$selected_terms[]           = [
		// 		'taxonomy' => $settings['filter_taxonomy'],
		// 		'field'    => 'term_id',
		// 		'terms'    => $filter_terms[0]->term_id,
		// 	];
		// 	// When there is 'All' tab is disabled
		// }
		/* Filter Bar End */

		if ( is_array( $selected_tax ) && count( $selected_tax ) ) {
			$selected_tax_terms = [];
			foreach ( $selected_tax as $tax ) {
				//Include by Terms
				$terms         = $settings[ $tax . '_' . $post_type . '_include_term_ids' ];
                
				$tax_relation  = $settings[ $post_type . '_tax_relation' ];
				$term_operator = $settings[ $tax . '_' . $post_type . '_term_operator' ];
				if ( is_array( $terms ) && count( $terms ) ) {
					$selected_tax_terms['relation'] = $tax_relation;
					$selected_tax_terms[]           = [
						'taxonomy' => $tax,
						'field'    => 'term_id',
						'terms'    => $terms,
						'operator' => $term_operator,
					];
				}

				//Exclude by Terms
				$terms = $settings[ $tax . '_' . $post_type . '_exclude_term_ids' ];
                if ( is_array( $terms ) && count( $terms ) ) {
					$selected_tax_terms[] = [
						'taxonomy' => $tax,
						'field'    => 'term_id',
						'terms'    => $terms,
						'operator' => 'NOT IN',
					];
				}
			}
            
			if ( is_array( $selected_tax_terms ) && count( $selected_tax_terms ) ) {
				$selected_terms[] = $selected_tax_terms;
			}
            
		}

		if ( is_array( $selected_terms ) && count( $selected_terms ) ) {
			$query_args['tax_query'] = $selected_terms;
		}

		//Exclude by current post.
		if ( $settings['current_post'] === 'yes' && is_single() ) {
			$post_data                  = Aepro::$_helper->get_demo_post_data();
			$query_args['post__not_in'] = [ $post_data->ID ];
		}

		//Exclude By Author
		if ( is_array( $settings['exclude_author_ids'] ) && count( $settings['exclude_author_ids'] ) ) {
			$query_args['author__not_in'] = $settings['exclude_author_ids'];
		}

		//Exclude by offset
		$query_args['offset'] = $settings['offset'];

		// Meta Query

		// Date Query

		$select_date = $settings['select_date'];
		if ( $select_date !== 'anytime' ) {
			$date_query = [];
			switch ( $select_date ) {
				case 'today':
					$date_query['after'] = '-1 day';
					break;
				case 'week':
					$date_query['after'] = '-1 week';
					break;
				case 'month':
					$date_query['after'] = '-1 month';
					break;
				case 'quarter':
					$date_query['after'] = '-3 month';
					break;
				case 'year':
					$date_query['after'] = '-1 year';
					break;
				case 'exact':
					if ( ! empty( $settings['post_status'] ) ) {
						$query_args['post_status'] = $settings['post_status'];
					}
					$after_date = $settings['date_after'];
					if ( ! empty( $after_date ) ) {
						$date_query['after'] = $after_date;
					}
					$before_date = $settings['date_before'];
					if ( ! empty( $before_date ) ) {
						$date_query['before'] = $before_date;
					}
					$date_query['inclusive'] = true;
					break;
			}
			$query_args['date_query'] = $date_query;
		}

		// Ordering Parameters
		$query_args['orderby'] = $settings['orderby'];
		$query_args['order']   = $settings['order'];

		if ( $settings['orderby'] === 'meta_value' || $settings['orderby'] === 'meta_value_num' ) {
			$query_args['meta_key'] = $settings['orderby_metakey'];
		}

		// Post Count
		if ( $settings['posts_per_page'] ) {
			$query_args['posts_per_page'] = $settings['posts_per_page'];
		}

		// Pagination Parameters
		if ( isset( $_POST['page_num'] ) || $paged > 1 ) {
			$query_args['offset'] = $this->calculate_offset( $settings, $query_args, $paged );
		}

		/** WooCommerce */
		if ( class_exists( 'WooCommerce' ) ) {
			// Out of Stock Product
			if( $settings['hide_out_of_stock'] === 'yes' ) {
				$query_args['meta_query'] = array(
					array(
						'key'       => '_stock_status',
						'value'     => 'outofstock',
						'compare'   => 'NOT IN'
					)
				);
			}

			// Featured Products
			if( $settings['show_featured'] === 'yes' ) {
				$featured_product_tax_query[] = array(
					'taxonomy' => 'product_visibility',
					'field'    => 'name',
					'terms'    => 'featured',
					'operator' => 'IN', // or 'NOT IN' to exclude feature products
				);

				if ( is_array( $featured_product_tax_query ) && count( $featured_product_tax_query ) ) {
					$selected_terms[] = $featured_product_tax_query;
				}

				if ( is_array( $selected_terms ) && count( $selected_terms ) ) {
					$query_args['tax_query'] = $selected_terms;
				}
			}
		}

		return $query_args;
	}


    public function get_current_page_num() {
		$current = 1;

		if ( isset( $_POST['page_num'] ) ) {
			$current = $_POST['page_num'];
			return $current;
		}

		if ( is_front_page() && ! is_home() ) {
			$current = ( get_query_var( 'page' ) ) ? get_query_var( 'page' ) : 1;
		} else {
			$current = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;
		}

		return $current;
	}
}    