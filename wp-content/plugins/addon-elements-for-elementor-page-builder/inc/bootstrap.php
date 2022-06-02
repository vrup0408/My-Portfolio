<?php

namespace WTS_EAE;

use Elementor;
use WTS_EAE\Classes\Helper;
use const EAE_PATH;

class Plugin {


	public static $instance;

	public $module_manager;

	public static $helper       = null;
	private static $show_notice = true;

	public static function get_instance() {
		if ( ! isset( self::$instance ) ) {
			self::$instance = new self();
		}

		return self::$instance;
	}

	public function __construct() {
		$this->register_autoloader();
		self::$helper = new Helper();

		add_action( 'elementor/init', [ $this, 'eae_elementor_init' ], -10 );
		add_action( 'elementor/elements/categories_registered', [ $this, 'register_category' ] );
		add_action( 'wp_enqueue_scripts', [ $this, 'eae_scripts' ] );
		add_action( 'elementor/editor/wp_head', [ $this, 'eae_editor_enqueue_scripts' ] );
		add_action( 'elementor/controls/controls_registered', [ $this, 'register_controls' ] );
		add_action( 'plugins_loaded', [ $this, '_plugins_loaded' ] );
		// WPML 4.5.0 move wpml move from plugin_loaded to after_setup_theme
		add_action('after_setup_theme', [$this,'_after_setup_theme']);
		add_action( 'admin_enqueue_scripts', [ $this, 'eae_admin_scripts' ] );

		$this->_includes();

		$this->module_manager = new Managers\Module_Manager();

		$wpv_notice = [];

		$wpv_notice = apply_filters( 'eae/admin_notices', $wpv_notice );

		if ( $wpv_notice ) {
			add_action( 'admin_init', [ $this, $wpv_notice[0] ], 10 );
		}
	}

	public function eae_elementor_init() {     }

	public function _plugins_loaded() {
		if ( ! did_action( 'elementor/loaded' ) ) {
			/* TO DO */
			add_action( 'admin_notices', [ $this, 'wts_eae_pro_fail_load' ] );

			return;
		}
		$elementor_version_required = '3.0';

		// Check for required Elementor version
		if ( ! version_compare( ELEMENTOR_VERSION, $elementor_version_required, '>=' ) ) {
			add_action( 'admin_notices', [ $this, 'elementor_requried_version_fail' ] );
			return;
		}

		// WPML Compatibility
		// if ( is_plugin_active( 'sitepress-multilingual-cms/sitepress.php' ) && is_plugin_active( 'wpml-string-translation/plugin.php' ) ) {
			
		// 	require_once EAE_PATH . 'wpml/wpml-compatibility.php';
		// }
	}

	public function _after_setup_theme(){
		if ( is_plugin_active( 'sitepress-multilingual-cms/sitepress.php' ) && is_plugin_active( 'wpml-string-translation/plugin.php' ) ) {	
			require_once EAE_PATH . 'wpml/wpml-compatibility.php';
		}
	}

	public function register_category( $elements ) {

		\Elementor\Plugin::instance()->elements_manager->add_category(
			'wts-eae',
			[
				'title' => 'Elementor Addon Elements',
				'icon'  => 'font',
			],
			1
		);
	}

	public function _includes() {
		if ( is_admin() ) {
			require_once EAE_PATH . 'inc/admin/settings-page.php';
			require_once EAE_PATH . 'inc/admin/controls.php';
			require_once EAE_PATH . 'inc/admin/Settings.php';
			require_once EAE_PATH . 'inc/admin/admin-notice.php';

			$admin_notice = new Admin_Notice();
		}
	}
	public function register_controls( Elementor\Controls_Manager $controls_manager ) {

		require_once EAE_PATH . 'controls/group/icon.php';
		require_once EAE_PATH . 'controls/group/icon_timeline.php';
		require_once EAE_PATH . 'controls/group/grid-control.php';

		$controls_manager->add_group_control( 'eae-icon', new \WTS_EAE\Controls\Group\Group_Control_Icon() );

		$controls_manager->add_group_control( 'eae-icon-timeline', new \WTS_EAE\Controls\Group\Group_Control_Icon_Timeline() );

		$controls_manager->add_group_control( 'eae-grid', new \WTS_EAE\Controls\Group\Group_Control_Grid() );
	}
	public function eae_admin_scripts() {
		$screen = get_current_screen();

		wp_enqueue_style( 'eae-admin-css', EAE_URL . 'assets/css/eae-admin.css', [], '1.0', '' );

		if ( $screen->id === 'toplevel_page_eae-settings' ) {
			add_action( 'admin_print_scripts', [ $this, 'eae_disable_admin_notices' ] );

			wp_enqueue_script( 'eae-admin', EAE_URL . 'assets/js/admin.js', [ 'wp-components' ], '1.0', true );

			$modules = self::$helper->get_eae_modules();

			wp_localize_script(
				'eae-admin',
				'eaeGlobalVar',
				[
					'site_url'     => site_url(),
					'eae_dir'      => EAE_URL,
					'ajax_url'     => admin_url( 'admin-ajax.php' ),
					'map_key'      => get_option( 'wts_eae_gmap_key' ),
					'eae_elements' => $modules,
					'eae_version'  => EAE_VERSION,
					'nonce'        => wp_create_nonce( 'eae_ajax_nonce' ),
				]
			);
		}
	}

	public function eae_disable_admin_notices() {
		global $wp_filter;
		if ( is_user_admin() ) {
			if ( isset( $wp_filter['user_admin_notices'] ) ) {
				unset( $wp_filter['user_admin_notices'] );
			}
		} elseif ( isset( $wp_filter['admin_notices'] ) ) {
			unset( $wp_filter['admin_notices'] );
		}
		if ( isset( $wp_filter['all_admin_notices'] ) ) {
			unset( $wp_filter['all_admin_notices'] );
		}
	}

	public function eae_scripts() {
		wp_enqueue_style( 'eae-css', EAE_URL . 'assets/css/eae' . EAE_SCRIPT_SUFFIX . '.css', [], EAE_VERSION );

		/* chart js file */
		wp_register_script( 'eae-chart', EAE_URL . 'assets/js/Chart.bundle' . EAE_SCRIPT_SUFFIX . '.js', [], '2.9.3', true );
		wp_register_script( 'eae-data-table', EAE_URL . 'assets/lib/tablesorter/tablesorter.js', [], '2.31.3', true );
		wp_register_script( 'eae-lottie', EAE_URL . 'assets/lib/lottie/lottie' . EAE_SCRIPT_SUFFIX . '.js', [], '5.6.8', true );

		/* animated text css and js file*/
		wp_register_script( 'animated-main', EAE_URL . 'assets/js/animated-main' . EAE_SCRIPT_SUFFIX . '.js', [ 'jquery' ], '1.0', true );

		wp_enqueue_script(
			'eae-main',
			EAE_URL . 'assets/js/eae' . EAE_SCRIPT_SUFFIX . '.js',
			[
				'jquery',
			],
			EAE_VERSION,
			true
		);
		if ( is_plugin_active( 'elementor/elementor.php' ) ) {
			wp_localize_script(
				'eae-main',
				'eae',
				[
					'ajaxurl'     => admin_url( 'admin-ajax.php' ),
					'current_url' => base64_encode( self::$helper->get_current_url_non_paged() ),
					'breakpoints' => Elementor\Core\Responsive\Responsive::get_breakpoints(),
				]
			);
		}
		wp_register_script( 'eae-particles', EAE_URL . 'assets/js/particles' . EAE_SCRIPT_SUFFIX . '.js', [ 'jquery' ], '2.0.0', true );
		wp_register_style( 'vegas-css', EAE_URL . 'assets/lib/vegas/vegas' . EAE_SCRIPT_SUFFIX . '.css', [], '2.4.0' );
		wp_register_script( 'vegas', EAE_URL . 'assets/lib/vegas/vegas' . EAE_SCRIPT_SUFFIX . '.js', [ 'jquery' ], '2.4.0', true );

		wp_register_script( 'wts-magnific', EAE_URL . 'assets/lib/magnific' . EAE_SCRIPT_SUFFIX . '.js', [ 'jquery' ], '1.1.0', true );
		wp_register_script( 'wts-isotope', EAE_URL . 'assets/lib/isotope/isotope.pkgd' . EAE_SCRIPT_SUFFIX . '.js', [ 'jquery' ], '3.0.6', true );
		wp_register_script( 'wts-tilt', EAE_URL . 'assets/lib/tilt/tilt.jquery' . EAE_SCRIPT_SUFFIX . '.js', [ 'jquery' ], '1.0', true );
		if ( is_plugin_active( 'elementor/elementor.php' ) ) {
			wp_register_style(
				'font-awesome-5-all',
				ELEMENTOR_ASSETS_URL . 'lib/font-awesome/css/all.min.css',
				[],
				'1.0'
			);
			wp_register_style(
				'font-awesome-4-shim',
				ELEMENTOR_ASSETS_URL . 'lib/font-awesome/css/v4-shims.min.css',
				[],
				'1.0'
			);
			wp_register_script(
				'font-awesome-4-shim',
				ELEMENTOR_ASSETS_URL . 'lib/font-awesome/js/v4-shims.min.js',
				[],
				'1.0',
				true
			);
		}
		$map_key = get_option( 'wts_eae_gmap_key' );
		if ( isset( $map_key ) && $map_key !== '' ) {
			wp_register_script( 'eae-gmap', 'https://maps.googleapis.com/maps/api/js?key=' . $map_key, [], EAE_VERSION, true );
		}

		wp_register_script( 'pinit', '//assets.pinterest.com/js/pinit.js', [], '1.0', true );

		wp_register_script( 'eae-stickyanything', EAE_URL . 'assets/js/stickyanything.js', [ 'jquery' ], '1.1.2', true );

		$localize_data = [
			'plugin_url' => EAE_URL,
		];
		wp_localize_script( 'eae-main', 'eae_editor', $localize_data );
	}

	public function eae_editor_enqueue_scripts() {
		wp_enqueue_style( 'eae-icons', EAE_URL . 'assets/lib/eae-icons/style.css', [], '1.0', '' );
		wp_enqueue_script( 'eae-editor-js', EAE_URL . 'assets/js/editor.js', [ 'jquery' ], '1.0', true );
		wp_localize_script(
			'eae-editor-js',
			'eaeEditor',
			[
				'ajaxurl'    => admin_url( 'admin-ajax.php' ),
			]
		);
	}
	private function register_autoloader() {
		spl_autoload_register( [ __CLASS__, 'autoload' ] );
	}

	public function autoload( $class ) {
		if ( 0 !== strpos( $class, __NAMESPACE__ ) ) {
			return;
		}

		if ( ! class_exists( $class ) ) {

			$filename = strtolower(
				preg_replace(
					[ '/^' . __NAMESPACE__ . '\\\/', '/([a-z])([A-Z])/', '/_/', '/\\\/' ],
					[ '', '$1-$2', '-', DIRECTORY_SEPARATOR ],
					$class
				)
			);

			$filename = EAE_PATH . $filename . '.php';

			if ( is_readable( $filename ) ) {
				include $filename;
			}
		}
	}
	public function elementor_requried_version_fail() {
		if ( ! current_user_can( 'update_plugins' ) ) {
			return;
		}
		$elementor_version_required = '3.0.0';
		$file_path                  = 'elementor/elementor.php';

		$upgrade_link = wp_nonce_url( self_admin_url( 'update.php?action=upgrade-plugin&plugin=' ) . $file_path, 'upgrade-plugin_' . $file_path );
		$message      = '<p>' . sprintf( __( 'Elementor Addon Elements requires Elementor %s Please update Elementor to continue.', 'wts-eae' ), $elementor_version_required ) . '</p>';
		$message     .= '<p>' . sprintf( '<a href="%s" class="button-primary">%s</a>', $upgrade_link, __( 'Update Elementor Now', 'wts-eae' ) ) . '</p>';

		//phpcs:ignore WordPress.WP.I18n.NonSingularStringLiteralText
		printf( '<div class="%1$s">%2$s</div>', 'error', esc_attr__( $message, 'wts-eae' ) );
	}

	public function wts_eae_pro_fail_load() {
		$plugin = 'elementor/elementor.php';

		if ( _is_elementor_installed() ) {
			if ( ! current_user_can( 'activate_plugins' ) ) {
				return;
			}

			$message      = esc_html__( 'Elementor Addon Elements is not working because you need to activate the Elementor plugin.', 'wts-eae' );
			$action_url   = wp_nonce_url( 'plugins.php?action=activate&amp;plugin=' . $plugin . '&amp;plugin_status=all&amp;paged=1&amp;s', 'activate-plugin_' . $plugin );
			$button_label = __( 'Activate Elementor', 'wts-eae' );
		} else {
			if ( ! current_user_can( 'install_plugins' ) ) {
				return;
			}
			$message      = esc_html__( 'Elementor Addon Elements is not working because you need to install the Elementor plugin.', 'wts-eae' );
			$action_url   = wp_nonce_url( self_admin_url( 'update.php?action=install-plugin&plugin=elementor' ), 'install-plugin_elementor' );
			$button_label = __( 'Install Elementor', 'wts-eae' );
		}

		$button = '<p><a href="' . $action_url . '" class="button-primary">' . $button_label . '</a></p><p></p>';

		//phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		printf( '<div class="%1$s"><p>%2$s</p>%3$s</div>', 'notice notice-error', $message, $button );
	}
	public function dateDiff( $start, $end ) {
		$start_time = strtotime( $start );
		$end_time   = strtotime( $end );
		$datediff   = $end_time - $start_time;
		return round( $datediff / 86400 );
	}
	public function eae_review() {
		if ( isset( $_GET['remind_later'] ) || isset( $_GET['review_done'] ) ) {
			if ( !isset( $_GET['eae_nonce'] ) || ! wp_verify_nonce( $_GET['eae_nonce'], 'eae_notice_box' ) ) {
				die( 'Sorry, your nonce did not verify!' );
			}else{
				if ( isset( $_GET['remind_later'] ) ) {
					$this->eae_remind_later();
				} elseif ( isset( $_GET['review_done'] ) ) {
					$this->eae_review_done();
				} 
			}
		}
		add_action( 'admin_notices', [ $this, 'eae_review_box' ] );
		
	}

	public function eae_review_box( ) {
		$review = get_option('eae_review');
		if(get_transient('eae_remind_later') || !empty($review['status'])){
			return;
		}
		?>
				<div class="notice notice-success">
					<p><?php echo 'I hope you are enjoying using <b>Elementor Addon Elements</b>. Could you please do a BIG favor and give it a 5-star rating on WordPress.org ? <br/> Just to help us spread the word and boost our motivation. <br/><b>~ Anand Upadhyay</b>'; ?></p>
					<p>
					<?php
						printf(
							'<a class="eae-notice-link" style="padding-right: 5px;" target="_blank" href="https://wordpress.org/support/plugin/addon-elements-for-elementor-page-builder/reviews/#new-post" class="button button-primary"><span class="dashicons dashicons-heart" style="text-decoration : none; margin : 0px 3px 0px 0px;"></span>%1$s</a>',
							esc_html__( 'Ok, you deserve it!', 'wts-eae' )
						);

						printf(
							'<a class="eae-notice-link" style="padding-right: 5px;" href="%1$s"><span class="dashicons dashicons-schedule" style="text-decoration : none; margin : 0px 3px;"></span>%2$s</a>',
							esc_url(

								add_query_arg( ['remind_later' => 'later' ,
								'eae_nonce' => wp_create_nonce( 'eae_notice_box' ) ])
							),
							esc_html__( 'May Be Later', 'wts-eae' )
						);

						printf(
							'<a class="eae-notice-link" style="padding-right: 5px;" href="%1$s"><span class="dashicons dashicons-smiley" style="text-decoration : none; margin : 0px 3px;"></span>%2$s</a>',
							esc_url(
								add_query_arg( ['review_done' =>  'done',
								'eae_nonce'	=> wp_create_nonce( 'eae_notice_box' ) ])
							),
							esc_html__( 'Already Done', 'wts-eae' )
						);
						?>
						<button type="button" class="notice-dismiss"><span class="screen-reader-text">Dismiss this notice.</span></button>
						<?php
					?>
					</p>
				</div>
		<?php
	}


	public function eae_remind_later() {
		set_transient( 'eae_remind_later', 'show again', WEEK_IN_SECONDS );
	}

	public function eae_review_done() {
		$review            = get_option( 'eae_review' );
		$review['status']  = 'done';
		$review['reviwed'] = current_time( 'Y/m/d' );
		update_option( 'eae_review', $review, false );
	}

	public function fv_download_box() {
		if ( isset( $_GET['fv_download_later'] ) || isset( $_GET['fv_not_interested'] ) ) {
			if(! isset( $_GET['eae_nonce'] ) || ! wp_verify_nonce( $_GET['eae_nonce'], 'eae_notice_box' )){
				die( 'Sorry, Some issue with nonce!' );
			}else{
				if ( isset( $_GET['fv_download_later'] ) ) {
					$this->fv_download_later();
				} elseif ( isset( $_GET['fv_not_interested'] ) ) {
					$this->fv_not_interested();
				} 
			}
		}

		$this->check_form_used();
	}
	public function check_form_used() {
		if ( !is_plugin_active( 'form-vibes/form-vibes.php' )) {
			add_action( 'admin_notices', [ $this, 'fv_add_box' ], 10 );
		}
	}

	public function fv_add_box() {
		if(get_transient('fv_download_later') || !empty(get_option('fv_downloaded'))){
			return;
		}
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
			return;
		}
		self::$show_notice = false;
		?>
		<div class="fv-add-box notice notice-success is-dismissible">
			<div class="fv-logo">
				<svg viewBox="0 0 1340 1340" version="1.1">
					<g id="Page-1" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
						<g id="Artboard" transform="translate(-534.000000, -2416.000000)" fill-rule="nonzero">
							<g id="g2950" transform="translate(533.017848, 2415.845322)">
								<circle id="circle2932" fill="#FF6634" cx="670.8755" cy="670.048026" r="669.893348"></circle>
								<path d="M1151.33208,306.590013 L677.378555,1255.1191 C652.922932,1206.07005 596.398044,1092.25648 590.075594,1079.88578 L589.97149,1079.68286 L975.423414,306.590013 L1151.33208,306.590013 Z M589.883553,1079.51122 L589.97149,1079.68286 L589.940317,1079.74735 C589.355382,1078.52494 589.363884,1078.50163 589.883553,1079.51122 Z M847.757385,306.589865 L780.639908,441.206555 L447.47449,441.984865 L493.60549,534.507865 L755.139896,534.508386 L690.467151,664.221407 L558.27749,664.220865 L613.86395,775.707927 L526.108098,951.716924 L204.45949,306.589865 L847.757385,306.589865 Z" id="Combined-Shape" fill="#FFFFFF"></path>
							</g>
						</g>
					</g>
				</svg>
			</div>
			<div class="fv-add-content">
			<div>
			<p><?php printf( 'I hope you are enjoying using <b>%1$s</b>. Here is another useful plugin by us - <b>%2$s</b>. <br/>If you are using Elementor Pro Form, then you can capture form submissions within WordPress Admin.', 'Elementor Addon Elements', 'Form Vibes' ); ?></p>

				<p>
					<?php

						printf(
							'<a class="eae-notice-link" style="padding: 5px;"  href=" %splugin-install.php?s=form+vibes&tab=search&type=term">Download Now</a>',
							esc_url( admin_url() )
						);
						printf(
							'<a class="eae-notice-link" style="padding-right: 5px;" href="%1$s"><span class="dashicons dashicons-schedule" style="text-decoration : none; margin : 0px 3px;"></span>%2$s</a>',
							esc_url(
								add_query_arg( ['fv_download_later' =>'later',
								 				'eae_nonce'=> wp_create_nonce( 'eae_notice_box' )
											 ] )
							),
							esc_html__( 'May Be Later', 'wts-eae' )
						);
						printf(
							'<a class="eae-notice-link" style="padding-right: 5px;" href="%1$s"><span class="dashicons dashicons-smiley" style="text-decoration : none; margin : 0px 3px;"></span>%2$s</a>',
							esc_url(
								add_query_arg( 
									[
										'fv_not_interested' =>  'done', 
									 	'eae_nonce'	=>  wp_create_nonce( 'eae_notice_box' )
									]	  
								)
							),
							esc_html__( 'Not Interested', 'wts-eae' )
						);
					?>
				</p>
				</div>
			</div>
		</div>
		<?php
	}

	public function fv_download_later() {
		set_transient( 'fv_download_later', 'show again', WEEK_IN_SECONDS );
	}

	public function fv_not_interested() {
		update_option( 'fv_downloaded', 'done', false );
	}
}

Plugin::get_instance();
