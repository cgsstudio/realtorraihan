<?php
/**
 * Realtor Raihan theme bootstrap.
 *
 * @package RealtorRaihan
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'RR_VERSION', '1.0.30' );
define( 'RR_DIR', get_template_directory() );
define( 'RR_URI', get_template_directory_uri() );

require_once RR_DIR . '/inc/helpers.php';
require_once RR_DIR . '/inc/keywords.php';
require_once RR_DIR . '/inc/customizer.php';
require_once RR_DIR . '/inc/home-fields.php';
require_once RR_DIR . '/inc/about-fields.php';
require_once RR_DIR . '/inc/contact-fields.php';
require_once RR_DIR . '/inc/blog-fields.php';
require_once RR_DIR . '/inc/contact.php';
require_once RR_DIR . '/inc/nav-walker.php';
require_once RR_DIR . '/inc/theme-setup.php';
require_once RR_DIR . '/inc/page-css.php';
require_once RR_DIR . '/inc/demo-content.php';
require_once RR_DIR . '/inc/newsletter.php';
require_once RR_DIR . '/inc/admin-ux.php';
require_once RR_DIR . '/inc/page-editor.php';
require_once RR_DIR . '/inc/post-types.php';

/**
 * Assets.
 */
function rr_assets() {
	$css = array(
		'rr-fonts'    => 'fonts.css',
		'rr-base'     => 'base.css',
		'rr-chrome'   => 'chrome.css',
		'rr-footer'   => 'footer.css',
	);

	if ( is_front_page() ) {
		$css['rr-home-hero']       = 'home-01-hero.css';
		$css['rr-home-intro']      = 'home-02-intro.css';
		$css['rr-home-why-invest'] = 'home-03-why-invest.css';
		$css['rr-home-services']   = 'home-04-services.css';
		$css['rr-home-testi']      = 'home-08-testimonials.css';
		$css['rr-home-why-choose'] = 'home-09-why-choose.css';
		$css['rr-home-faq']        = 'home-10-faq.css';
		$css['rr-home-contact']    = 'home-11-contact.css';
	}
	if ( is_page_template( 'page-templates/about.php' ) ) {
		$css['rr-about'] = 'about.css';
	}
	$is_contact = is_page( 'contact' )
		|| is_page( 'contact-us' )
		|| is_page( 'get-in-touch' )
		|| is_page_template( 'page-templates/contact.php' )
		|| is_page_template( 'page-contact.php' );
	if ( $is_contact ) {
		$css['rr-home-contact'] = 'home-11-contact.css';
		$css['rr-contact']      = 'contact.css';
	}
	$is_blog = is_home()
		|| is_archive()
		|| is_search()
		|| is_page( 'blog' )
		|| is_page_template( 'page-templates/blog.php' );
	if ( $is_blog ) {
		$css['rr-blog'] = 'blog.css';
	}
	if ( is_singular( 'post' ) ) {
		$css['rr-post'] = 'post.css';
	}

	// custom.css and custom.js load last, so the client's own CSS/JS wins.
	$css['rr-custom'] = 'custom.css';

	$i = 0;
	foreach ( $css as $handle => $file ) {
		wp_enqueue_style( $handle, RR_URI . '/assets/css/' . $file, array(), RR_VERSION );
		$i++;
	}

	wp_enqueue_script( 'rr-chrome', RR_URI . '/assets/js/chrome.js', array(), RR_VERSION, true );
	wp_enqueue_script( 'rr-custom', RR_URI . '/assets/js/custom.js', array(), RR_VERSION, true );

	if ( is_front_page() ) {
		$js = array(
			'rr-hero'        => '01-hero.js',
			'rr-intro'       => '02-intro.js',
			'rr-why-invest'  => '03-why-invest.js',
			'rr-services'    => '04-services.js',
			'rr-testi'       => '08-testimonials.js',
			'rr-why-choose'  => '09-why-choose.js',
			'rr-faq'         => '10-faq.js',
			'rr-contact-js'  => '11-contact.js',
		);
		foreach ( $js as $handle => $file ) {
			wp_enqueue_script( $handle, RR_URI . '/assets/js/' . $file, array(), RR_VERSION, true );
		}
	}
	if ( is_page_template( 'page-templates/about.php' ) ) {
		wp_enqueue_script( 'rr-about', RR_URI . '/assets/js/about.js', array(), RR_VERSION, true );
	}
	if ( $is_contact ) {
		wp_enqueue_script( 'rr-contact-js', RR_URI . '/assets/js/11-contact.js', array(), RR_VERSION, true );
	}
	if ( $is_blog ) {
		wp_enqueue_script( 'rr-blog', RR_URI . '/assets/js/blog.js', array(), RR_VERSION, true );
	}

	// Let the visitor (and the client) see the contact form result messages.
	wp_localize_script(
		'rr-chrome',
		'rrData',
		array(
			'contactSent' => isset( $_GET['enquiry'] ) && 'sent' === $_GET['enquiry'] ? '1' : '0',
			'isWP'        => '1',
		)
	);
}
add_action( 'wp_enqueue_scripts', 'rr_assets' );

/**
 * Body classes that let the CSS know where we are.
 */
function rr_body_class( $classes ) {
	$classes[] = 'rr-wp';
	if ( is_front_page() ) {
		$classes[] = 'rr-home';
	}
	if ( is_page( 'contact' ) || is_page( 'contact-us' ) || is_page( 'get-in-touch' ) || is_page_template( 'page-templates/contact.php' ) || is_page_template( 'page-contact.php' ) ) {
		$classes[] = 'page-contact';
		$classes[] = 'page-template-contact';
	}
	return $classes;
}
add_filter( 'body_class', 'rr_body_class' );

/**
 * Pages the theme needs (About with its template, Blog as the posts page, Home
 * as the static front page). Run once, and again if something is missing.
 */
add_action(
	'wp_loaded',
	function () {
		if ( get_option( 'rr_provisioned' ) ) {
			return;
		}
		rr_provision_pages();
		update_option( 'rr_provisioned', 1 );
	}
);
