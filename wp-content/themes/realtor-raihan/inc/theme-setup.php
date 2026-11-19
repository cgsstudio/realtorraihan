<?php
/**
 * Theme supports, menus, page provisioning.
 *
 * @package RealtorRaihan
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

add_action(
	'after_setup_theme',
	function () {
		add_theme_support( 'title-tag' );
		add_theme_support( 'post-thumbnails' );
		add_theme_support( 'responsive-embeds' );
		add_theme_support( 'align-wide' );
		add_theme_support(
			'html5',
			array( 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption', 'style', 'script' )
		);
		add_theme_support(
			'custom-logo',
			array(
				'height'      => 192,
				'width'       => 900,
				'flex-height' => true,
				'flex-width'  => true,
			)
		);

		register_nav_menus(
			array(
				'primary' => __( 'Primary menu (header)', 'realtor-raihan' ),
				'footer'  => __( 'Footer quick links', 'realtor-raihan' ),
			)
		);

		// Blog thumbnails.
		add_image_size( 'rr-card', 900, 600, true );
	}
);

/**
 * Fallback header menu: used before the client assigns a menu to the
 * "Primary menu" location, so the site is never without navigation.
 */
function rr_fallback_menu() {
	$items = array(
		array( 'Home', rr_anchor( 'hero' ) ),
		array( 'About', rr_link( 'about' ) ),
		array( 'Blog', rr_blog_url() ),
		array( 'Contact', rr_anchor( 'contact' ) ),
	);
	echo '<a href="' . esc_url( $items[0][1] ) . '"' . ( is_front_page() ? ' aria-current="page"' : '' ) . '>Home</a>';
	echo '<a href="' . esc_url( $items[1][1] ) . '"' . ( is_page_template( 'page-templates/about.php' ) ? ' aria-current="page"' : '' ) . '>About</a>';
	echo '<a href="' . esc_url( $items[2][1] ) . '"' . ( ( is_home() || is_singular( 'post' ) ) ? ' aria-current="page"' : '' ) . '>Blog</a>';
	echo '<a href="' . esc_url( $items[3][1] ) . '">Contact</a>';
}

/**
 * One place that knows where the blog index lives.
 *
 * @return string
 */
function rr_blog_url() {
	$page = get_page_by_path( 'blog' );
	if ( $page ) {
		return get_permalink( $page );
	}
	$posts_page = get_option( 'page_for_posts' );
	if ( $posts_page ) {
		return get_permalink( $posts_page );
	}
	return home_url( '/?post_type=post' );
}

/**
 * Pages the theme needs. Created once on activation with their templates set,
 * so a fresh install already looks like the finished site.
 */
function rr_provision_pages() {
	$blog_page = get_option( 'page_for_posts' );

	$pages = array(
		'about' => array(
			'title'    => 'About',
			'template' => 'page-templates/about.php',
		),
		'blog'  => array(
			'title'    => 'Blog',
			'template' => '',
		),
		'home'  => array(
			'title'    => 'Home',
			'template' => 'page-templates/home.php',
		),
		'contact' => array(
			'title'    => 'Contact',
			'template' => '',
		),
	);

	foreach ( $pages as $slug => $data ) {
		$existing = get_page_by_path( $slug );
		if ( $existing ) {
			if ( 'blog' === $slug ) {
				update_option( 'page_for_posts', $existing->ID );
			}
			continue;
		}
		$id = wp_insert_post(
			array(
				'post_title'   => $data['title'],
				'post_name'    => $slug,
				'post_status'  => 'publish',
				'post_type'    => 'page',
				'post_content' => '',
			)
		);
		if ( is_wp_error( $id ) || ! $id ) {
			continue;
		}
		if ( $data['template'] ) {
			update_post_meta( $id, '_wp_page_template', $data['template'] );
		}
		if ( 'blog' === $slug ) {
			update_option( 'page_for_posts', $id );
		}
		if ( 'home' === $slug ) {
			update_option( 'show_on_front', 'page' );
			update_option( 'page_on_front', $id );
		}
	}
}
add_action( 'after_switch_theme', 'rr_provision_pages' );

/**
 * On activation also make sure a static front page is set even if the theme was
 * uploaded over an existing install.
 */
add_action(
	'admin_init',
	function () {
		if ( get_option( 'rr_provisioned' ) ) {
			return;
		}
		rr_provision_pages();
		update_option( 'rr_provisioned', 1 );
	}
);

/**
 * The header menu: a WP menu when the client made one, the built-in one until
 * then. Anchors are printed flat because the design's bar is not a list.
 *
 * @param int $index_start First stagger index (the mobile menu continues the count).
 */
function rr_primary_menu( $index_start = 0 ) {
	if ( ! has_nav_menu( 'primary' ) ) {
		rr_fallback_menu();
		return;
	}

	$locations = get_nav_menu_locations();
	$args      = (object) array(
		'items_wrap' => '%3$s',
		'rr_index'   => null,
	);

	$items = wp_get_nav_menu_items( $locations['primary'] );
	if ( ! $items ) {
		rr_fallback_menu();
		return;
	}

	$i = $index_start;
	foreach ( $items as $item ) {
		$args->rr_index = $i;
		$output         = '';
		$walker         = new RR_Nav_Walker();
		$walker->start_el( $output, $item, 0, $args, $item->ID );
		$walker->end_el( $output, $item, 0, $args );
		echo $output; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		$i++;
	}
}

/**
 * Article URLs stay short: /golden-visa/ rather than /2026/01/30/golden-visa/.
 * Matches the approved site's URLs and keeps the blog links readable.
 */

add_action(
	'init',
	function () {
		if ( get_option( 'rr_permalinks_set' ) ) {
			return;
		}
		update_option( 'permalink_structure', '/%postname%/' );
		update_option( 'rr_permalinks_set', 1 );
		flush_rewrite_rules( false );
	}
);
