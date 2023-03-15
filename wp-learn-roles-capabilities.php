<?php
/**
 * Plugin Name: WP Learn Roles and Capabilities
 * Version: 1.0.1
 */

/**
 * Create an admin page to show Role capabilities
 */
add_action( 'admin_menu', 'wp_learn_submenu', 11 );
function wp_learn_submenu() {
	add_submenu_page(
		'tools.php',
		esc_html__( 'WP Learn Capabilities', 'wp_learn' ),
		esc_html__( 'WP Learn Capabilities', 'wp_learn' ),
		'manage_options',
		'wp_learn_admin',
		'wp_learn_render_admin_page'
	);
}

/**
 * Render the Role admin page
 */
function wp_learn_render_admin_page() {
	$role = get_role( 'editor' );
	?>
    <div class="wrap" id="wp_learn_admin">
        <h1>Role</h1>
        <pre style="font-size: 22px; line-height: 1.2;"><?php print_r( $role ) ?>
		</pre>
    </div>
	<?php
}

/**
 * Adding plugin capabilities to the editor role
 */
register_activation_hook( __FILE__, 'wp_learn_add_custom_caps' );
function wp_learn_add_custom_caps() {
	$role = get_role( 'editor' );
	$role->add_cap( 'activate_plugins' );
	$role->add_cap( 'update_plugins' );
}

/**
 * Removing plugin capabilities from the editor role
 */
register_deactivation_hook( __FILE__, 'wp_learn_remove_custom_caps' );
function wp_learn_remove_custom_caps() {
	$role = get_role( 'editor' );
	$role->remove_cap( 'activate_plugins' );
	$role->remove_cap( 'update_plugins' );
}

/**
 * Adding a custom assistant role
 */
register_activation_hook( __FILE__, 'wp_learn_add_custom_role' );
function wp_learn_add_custom_role() {
	add_role(
		'assistant',
		'Assistant',
		array(
			'read'             => true,
			'activate_plugins' => true,
			'update_plugins'   => true,
		),
	);
}

/**
 * Removing the custom assistant role
 */
register_deactivation_hook( __FILE__, 'wp_learn_remove_custom_role' );
function wp_learn_remove_custom_role() {
	remove_role( 'assistant' );
}