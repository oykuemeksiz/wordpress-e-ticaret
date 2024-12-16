<?php
/**
 * Astra Addon BSF & WP-Com package extended functionality.
 *
 * In this file as per WooCommerce.com standards we manipulated following things -
 * 1. Deprecation of Code editor due to usage of
 *      i) eval()
 *      ii) echo $php_snippet;
 * 2. Removed modern checkout layout's easy login due to $_POST['password'] sanitization case.
 *
 * @package Astra Addon
 * @since 4.1.1
 */

/**
 * Check if code editor custom layout enabled.
 *
 * @param  int $post_id Post Id.
 * @return boolean
 * @since 4.1.5
 */
function astra_addon_is_code_editor_layout( $post_id ) {
	$php_enabled = get_post_meta( $post_id, 'editor_type', true );
	if ( 'code_editor' === $php_enabled ) {
		return true;
	}
	return false;
}

/**
 * Get PHP snippet if enabled.
 *
 * @param  int $post_id Post Id.
 * @return boolean|html
 * @since 4.1.1
 */
function astra_addon_get_php_snippet( $post_id ) {
	if ( ! astra_addon_is_code_editor_layout( $post_id ) ) {
		return false;
	}
	$code = get_post_meta( $post_id, 'ast-advanced-hook-php-code', true );
	if ( defined( 'ASTRA_ADVANCED_HOOKS_DISABLE_PHP' ) ) {
		return $code;
	}
	ob_start();
	// @codingStandardsIgnoreStart
	eval( '?>' . $code . '<?php ' ); // phpcs:ignore Squiz.PHP.Eval.Discouraged -- Ignored PHP standards to execute PHP code snipett.
	// @codingStandardsIgnoreEnd
	return ob_get_clean();
}

/**
 * Echo PHP snippet if enabled.
 *
 * @param  int $post_id Post Id.
 * @since 4.1.1
 */
function astra_addon_echo_php_snippet( $post_id ) {
	if ( astra_addon_is_code_editor_layout( $post_id ) ) {
		$php_snippet = astra_addon_get_php_snippet( $post_id );
		echo $php_snippet; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	}
}

/**
 * Check email exist.
 *
 * @since 3.9.0
 */
function astra_addon_woocommerce_login_user() {

	check_ajax_referer( 'woocommerce-login', 'security' );

	$response = array(
		'success' => false,
	);

	$user_name_email          = isset( $_POST['user_name_email'] ) ? sanitize_text_field( wp_unslash( $_POST['user_name_email'] ) ) : false;
	$password                 = isset( $_POST['password'] ) ? wp_unslash( $_POST['password'] ) : false; // phpcs:disable WordPress.Security.ValidatedSanitizedInput.InputNotSanitized
	$selected_user_name_email = '';

	if ( filter_var( $user_name_email, FILTER_VALIDATE_EMAIL ) ) {
		$selected_user_name_email = sanitize_email( $user_name_email );
	} else {
		$selected_user_name_email = $user_name_email;
	}

	$creds = array(
		'user_login'    => $selected_user_name_email,
		'user_password' => $password,
		'remember'      => false,
	);

	$user = wp_signon( $creds, false );

	if ( ! is_wp_error( $user ) ) {

		$response = array(
			'success' => true,
		);
	} else {
		$response['error'] = wp_kses_post( $user->get_error_message() );
	}

	wp_send_json_success( $response );
}

// Login user on modern checkout layout.
add_action( 'wp_ajax_astra_woocommerce_login_user', 'astra_addon_woocommerce_login_user' );
add_action( 'wp_ajax_nopriv_astra_woocommerce_login_user', 'astra_addon_woocommerce_login_user' );

/**
 * Function to filter input of Custom Layout's code editor.
 *
 * @param  string $output Output.
 * @param  string $key Key.
 * @return string
 * @since 4.5.0
 */
function astra_addon_filter_code_editor( $output, $key ) {
	return filter_input( INPUT_POST, $key, FILTER_DEFAULT ); // phpcs:ignore WordPressVIPMinimum.Security.PHPFilterFunctions.RestrictedFilter -- Default filter after all other cases, Keeping this filter for backward compatibility.
}

add_filter( 'astra_addon_php_default_filter_input', 'astra_addon_filter_code_editor', 10, 2 );

/**
 * Astra get template.
 */
if ( ! function_exists( 'astra_addon_get_template' ) ) {

	/**
	 * Get other templates (e.g. blog layout 2/3, advanced footer layout 1/2/3/etc) passing attributes and including the file.
	 *
	 * @param string $template_name template path. E.g. (directory / template.php).
	 * @param array  $args (default: array()).
	 * @param string $template_path (default: '').
	 * @param string $default_path (default: '').
	 * @since 1.0.0
	 * @return void
	 */
	function astra_addon_get_template( $template_name, $args = array(), $template_path = '', $default_path = '' ) {

		$located = astra_addon_locate_template( $template_name, $template_path, $default_path );

		if ( ! file_exists( $located ) ) {
			/* translators: 1: file location */
			_doing_it_wrong( __FUNCTION__, esc_html( sprintf( __( '%s does not exist.', 'astra-addon' ), '<code>' . $located . '</code>' ) ), '1.0.0' );
			return;
		}

		// Allow 3rd party plugin filter template file from their plugin.
		$located = apply_filters( 'astra_addon_get_template', $located, $template_name, $args, $template_path, $default_path );

		do_action( 'astra_addon_before_template_part', $template_name, $template_path, $located, $args );

		if ( file_exists( $located ) ) {
			// @codingStandardsIgnoreStart
			include $located; // phpcs:ignore audit.php.lang.security.file.inclusion-arg
			// @codingStandardsIgnoreEnd
		}

		do_action( 'astra_addon_after_template_part', $template_name, $template_path, $located, $args );
	}
}
