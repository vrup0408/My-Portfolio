<?php
namespace WTS_EAE\Modules\ContentSwitcher\skins;

use Elementor\Plugin as EPlugin;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
class Skin_1 extends Skin_Base {

	public function get_id() {
		return 'skin1';
	}

	public function get_title() {
		return __( 'Skin 1', 'wts-eae' );
	}

	public function render() {
		$settings = $this->parent->get_settings_for_display();

		$active_sec = $this->get_active_section( $settings['content_list'] );
		if ( empty( $active_sec ) ) {
			$active_sec['section_id'] = $settings['content_list'][0]['_id'];
			$active_sec['index_no']   = 0;
		}

		//Label Section Attribute
		$this->parent->add_render_attribute( 'switch-wrapper', 'class', 'eae-cs-label-wrapper' );

		//Content Section Attribute
		$this->parent->add_render_attribute( 'switch-content', 'class', 'eae-cs-content-section' );
		?>
			<div class="eae-content-switcher-wrapper eae-cs-layout-<?php echo $settings['_skin']; ?>" data-style="<?php echo $settings['_skin']; ?>" data-atab="<?php echo $active_sec['section_id']; ?>">
				<!--Header Secion Start-->
				<?php
					$this->render_header_button_skin( $settings );
				?>
				<!--Header Secion End-->
				<?php
					//Call Content Section from SKin Base Class
					$this->render_content( $settings );
				?>
			</div>
		<?php
	}

}
