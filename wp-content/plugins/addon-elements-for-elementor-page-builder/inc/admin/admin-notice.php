<?php

namespace WTS_EAE;

class Admin_Notice {

	public static $instance;

	public $module_manager;

	public static function get_instance() {
		if ( ! isset( self::$instance ) ) {
			self::$instance = new self();
		}

		return self::$instance;
	}

	public function __construct() {
		add_filter( 'eae/admin_notices', [ $this, 'eae_notice' ] );
		add_filter( 'eae/admin_notices', [ $this, 'fv_notice' ] );
	}

	public function eae_notice( $notice ) {
		$check_review = get_option( 'eae_review' );

		if ( ! $check_review ) {
			$review = [
				'installed' => current_time( 'Y/m/d' ),
				'status'    => '',
			];

			update_option( 'eae_review', $review );
		}

		$check_review = get_option( 'eae_review' );

		$start = $check_review['installed'];
		$end   = current_time( 'Y/m/d' );

		$days = $this->dateDiff( $start, $end );

		$usage = [];
		$usage = get_option( 'elementor_controls_usage' );

		if ( $usage ) {
			if ( array_key_exists( 'wp-page', $usage ) ) {
				$usage = $usage['wp-page'];
			} else {
				$usage = [];
			}
		} else {
			$usage = [];
		}

		$eae_widget   = [ 'eae-info-circle', 'eae-dual-button', 'wts-flipbox', 'wts-splittext', 'wts-modal-popup', 'eae-timeline', 'wts-AnimatedText', 'wts-ab-image', 'wts-gmap', 'eae-progress-bar', 'wts-textseparator', 'wts-postlist', 'eae-content-switcher', 'eae-filterableGallery', 'wts-shape-separator', 'wts-twitter', 'wts-pricetable' ];
		$widget_count = 0;
		foreach ( $eae_widget as $key => $value ) {
			if ( array_key_exists( $value, $usage ) ) {
				$widget_count = $widget_count + $usage[ $value ]['count'];
			}
		}

		if ( $days < 11 && $widget_count < 5 ) {
			return $notice;
		}

		$remind_later = get_transient( 'eae_remind_later' );
		// phpcs:ignore WordPress.PHP.StrictComparisons.LooseComparison
		if ( $check_review['status'] == '' && $remind_later == '' ) {
			$notice[] = 'eae_review';
			return $notice;
		}
	}
	public function dateDiff( $start, $end ) {
		$start_time = strtotime( $start );
		$end_time   = strtotime( $end );
		$datediff   = $end_time - $start_time;
		return round( $datediff / 86400 );
	}

	public function fv_notice( $notice ) {
		$download_later = get_transient( 'fv_download_later' );

		$fv_downloaded = get_option( 'fv_downloaded' );

		if ( $fv_downloaded === 'done' || $download_later ) {
			return $notice;
		}

		if ( ! is_plugin_active( 'form-vibes/form-vibes.php' ) ) {
			$query = [
				'post_type'   => 'page',
				'post_status' => 'publish',
				'meta_query'  => [
					[
						'key'     => '_elementor_data',
						'value'   => '"widgetType":"form"',
						'compare' => 'LIKE',
					],
				],
			];
			$data  = new \WP_Query( $query );

			if ( count( $data->posts ) <= 0 ) {
				return $notice;
			}
			$notice[] = 'fv_download_box';
			return $notice;
		}
	}
}
