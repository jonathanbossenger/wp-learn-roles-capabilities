<?php
/**
 * Plugin Name: WP Learn Roles and Capabilities
 * Version: 1.0.2
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

	add_submenu_page(
		'tools.php',
		esc_html__( 'WP Learn Story CPT', 'wp_learn' ),
		esc_html__( 'WP Learn Story CPT', 'wp_learn' ),
		'manage_options',
		'wp_learn_story_cpt',
		'wp_learn_render_story_cpt'
	);
}

/**
 * Render the Role admin page
 */
function wp_learn_render_admin_page() {
	$author_role = get_role( 'author' );
	?>
    <div class="wrap" id="wp_learn_admin">
        <h1>Roles</h1>
        <pre style="font-size: 22px; line-height: 1.2;"><?php print_r( $author_role  ) ?></pre>
    </div>
	<?php
}

/**
 * Render the Story admin page
 */
function wp_learn_render_story_cpt() {
	$story = $GLOBALS['wp_post_types']['story']
	?>
    <div class="wrap" id="wp_learn_admin">
        <h1>Book</h1>
        <pre style="font-size: 22px; line-height: 1.2;"><?php print_r( array( 'capability_type' => $story->capability_type ) ) ?></pre>
        <pre style="font-size: 22px; line-height: 1.2;"><?php print_r( array( 'map_meta_cap' => $story->map_meta_cap ) ) ?></pre>
        <pre style="font-size: 22px; line-height: 1.2;"><?php print_r( array( 'cap' => $story->cap ) ) ?></pre>
        <pre style="font-size: 22px; line-height: 1.2;"><?php print_r( $story ) ?></pre>
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

add_action( 'init', 'wp_learn_init' );
function wp_learn_init() {
	/**
	 * Register a story custom post type
	 */
	register_post_type(
		'story',
		array(
			'labels'          => array(
				'name'          => __( 'Stories' ),
				'singular_name' => __( 'Story' )
			),
			'public'          => true,
			'show_ui'         => true,
			'show_in_rest'    => true,
			'supports'        => array(
				'title',
				'editor',
				'custom-fields',
			),
            'capability_type' => array( 'story', 'stories' ),
		)
	);
}