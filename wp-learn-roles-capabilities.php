<?php
/**
 * Plugin Name: WP Learn Roles and Capabilities
 * Version: 1.0.0
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
