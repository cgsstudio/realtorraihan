<?php
/**
 * Contact page body, used by page-templates/contact.php.
 *
 * @package RealtorRaihan
 */

$bg = get_theme_mod( 'rr_contact_hero_bg', RR_URI . '/assets/img/skyline-dusk-wide.webp' );
?>
<div id="top" aria-hidden="true"></div>

<!-- 1. banner -->
<section class="ct-head" aria-labelledby="ct-page-title">
  <div class="ct-head__bg" aria-hidden="true">
    <img src="<?php echo esc_url( $bg ); ?>" alt="" loading="eager" decoding="async">
  </div>
  <div class="ct-head__in">
    <p class="ct-head__dot rv"><?php echo esc_html( rr_mod( 'rr_contact_eyebrow', 'Get In Touch' ) ); ?></p>
    <h1 class="rv" id="ct-page-title"><?php echo wp_kses( rr_mod( 'rr_contact_page_title', 'Let’s discuss your next<br>Dubai property <em>move.</em>' ), array( 'br' => array(), 'em' => array() ) ); ?></h1>
    <nav class="ct-head__crumb rv" aria-label="<?php esc_attr_e( 'Breadcrumb', 'realtor-raihan' ); ?>">
      <a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php esc_html_e( 'Home', 'realtor-raihan' ); ?></a><i aria-hidden="true"></i><span><?php esc_html_e( 'Contact', 'realtor-raihan' ); ?></span>
    </nav>
  </div>
</section>

<!-- 2. main contact section -->
<div class="ct-page-body">
  <?php get_template_part( 'parts/contact' ); ?>
</div>
