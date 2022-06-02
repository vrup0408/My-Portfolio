<?php
namespace WTS_EAE;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class Settings_Controls {

	/**
	 * @static
	 * @since 1.0.0
	 * @access public
	*/
	public static function render( $field = [] ) {
		if ( empty( $field ) || empty( $field['id'] ) ) {
			return;
		}

		$defaults = [
			'type'        => '',
			'placeholder' => '',
			'classes'     => [],
			'std'         => '',
			'desc'        => '',
		];

		$field = array_merge( $defaults, $field );

		$method_name = '_' . $field['type'];

		if ( ! method_exists( __CLASS__, $method_name ) ) {
			$method_name = '_text';
		}

		self::$method_name( $field );
	}

	/**
	 * @static
	 * @since 1.0.0
	 * @access private
	*/
	private static function _text( array $field ) {
		if ( empty( $field['classes'] ) ) {
			$field['classes'] = [ 'regular-text' ];
		}
		?>
		<input type="<?php echo esc_attr( $field['type'] ); ?>" class="<?php echo esc_attr( implode( ' ', $field['classes'] ) ); ?>" id="<?php echo esc_attr( $field['id'] ); ?>" name="<?php echo esc_attr( $field['id'] ); ?>" value="<?php echo esc_attr( get_option( $field['id'], $field['std'] ) ); ?>"<?php echo esc_attr( ! empty( $field['placeholder'] ) ) ? ' placeholder="' . esc_attr( $field['placeholder'] ) . '"' : ''; ?> />
		<?php
		if ( ! empty( $field['sub_desc'] ) ) :
			echo esc_attr( $field['sub_desc'] );
		endif;
		?>
		<?php if ( ! empty( $field['desc'] ) ) : ?>
			<p class="description"><?php echo esc_attr( $field['desc'] ); ?></p>
			<?php
		endif;
	}

	/**
	 * @static
	 * @since 1.0.0
	 * @access private
	*/
	private static function _checkbox( array $field ) {
		?>
		<label>
			<input type="<?php echo esc_attr( $field['type'] ); ?>" id="<?php echo esc_attr( $field['id'] ); ?>" name="<?php echo esc_attr( $field['id'] ); ?>" value="<?php echo esc_attr( $field['value'] ); ?>"<?php checked( $field['value'], get_option( $field['id'], $field['std'] ) ); ?> />
			<?php
			if ( ! empty( $field['sub_desc'] ) ) :
				echo esc_attr( $field['sub_desc'] );
			endif;
			?>
		</label>
		<?php if ( ! empty( $field['desc'] ) ) : ?>
			<p class="description"><?php echo esc_attr( $field['desc'] ); ?></p>
			<?php
		endif;
	}

	/**
	 * @static
	 * @since 1.0.0
	 * @access private
	*/
	private static function _checkbox_list( array $field ) {
		$old_value = get_option( $field['id'], $field['std'] );
		if ( ! is_array( $old_value ) ) {
			$old_value = [];
		}

		foreach ( $field['options'] as $option_key => $option_value ) :
			?>
			<label>
				<input type="checkbox" name="<?php echo esc_attr( $field['id'] ); ?>[]" value="<?php echo esc_attr( $option_key ); ?>"<?php checked( in_array( $option_key, $old_value, true ), true ); ?> />
				<?php echo esc_attr( $option_value ); ?>
			</label><br />
		<?php endforeach; ?>
		<?php if ( ! empty( $field['desc'] ) ) : ?>
			<p class="description"><?php echo esc_attr( $field['desc'] ); ?></p>
			<?php
		endif;
	}

	/**
	 * @static
	 * @since 1.4.0
	 * @access private
	*/
	private static function _select( array $field ) {
		$old_value = get_option( $field['id'], $field['std'] );
		?>
		<select name="<?php echo esc_attr( $field['id'] ); ?>">
			<?php if ( ! empty( $field['show_select'] ) ) : ?>
				<option value="">— <?php echo esc_html__( 'Select', 'wts-eae' ); ?> —</option>
			<?php endif; ?>

			<?php foreach ( $field['options'] as $value => $label ) : ?>
				<option value="<?php echo esc_attr( $value ); ?>"<?php selected( $value, $old_value ); ?>><?php echo esc_attr( $label ); ?></option>
			<?php endforeach; ?>
		</select>

		<?php if ( ! empty( $field['desc'] ) ) : ?>
			<p class="description"><?php echo esc_attr( $field['desc'] ); ?></p>
			<?php
		endif;
	}

	/**
	 * @static
	 * @since 1.0.0
	 * @access private
	*/
	private static function _checkbox_list_cpt( array $field ) {
		$defaults = [
			'exclude' => [],
		];
		$field    = array_merge( $defaults, $field );

		$post_types_objects = get_post_types(
			[
				'public' => true,
			],
			'objects'
		);
		$field['options']   = [];
		foreach ( $post_types_objects as $cpt_slug => $post_type ) {
			if ( in_array( $cpt_slug, $field['exclude'], true ) ) {
				continue;
			}

			$field['options'][ $cpt_slug ] = $post_type->labels->name;
		}

		self::_checkbox_list( $field );
	}

	/**
	 * @static
	 * @since 1.0.0
	 * @access private
	*/
	private static function _checkbox_list_roles( array $field ) {
		$defaults = [
			'exclude' => [],
		];
		$field    = array_merge( $defaults, $field );

		$field['options'] = [];
		foreach ( get_editable_roles() as $role_slug => $role_data ) {
			if ( in_array( $role_slug, $field['exclude'], true ) ) {
				continue;
			}

			$field['options'][ $role_slug ] = $role_data['name'];
		}

		self::_checkbox_list( $field );
	}

	/**
	 * @static
	 * @since 1.0.0
	 * @access private
	*/
	private static function _raw_html( array $field ) {
		if ( empty( $field['html'] ) ) {
			return;
		}
		?>
		<div id="<?php echo esc_attr( $field['id'] ); ?>">

			<div><?php echo esc_attr( $field['html'] ); ?></div>
			<?php
			if ( ! empty( $field['sub_desc'] ) ) :
				echo esc_attr( $field['sub_desc'] );
			endif;
			?>
			<?php if ( ! empty( $field['desc'] ) ) : ?>
				<p class="description"><?php echo esc_attr( $field['desc'] ); ?></p>
			<?php endif; ?>
			</div>
		<?php
	}
}
