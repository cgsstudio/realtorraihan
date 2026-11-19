<?php
/**
 * Shared footer, identical on every page.
 *
 * @package RealtorRaihan
 */

$keywords = rr_lines( rr_mod( 'rr_footer_keywords', '' ) );
if ( ! $keywords ) {
	$keywords = rr_default_keywords();
}
$disc = rr_mod( 'rr_footer_disc', '' );
if ( ! $disc ) {
	$disc = 'Information on this website is general guidance, not financial, tax, or legal advice. Property prices, payment plans, rental yields, and visa requirements change and must be verified independently before you commit. Financial figures shown in the investment snapshot are illustrative.';
}
$copyright = get_theme_mod( 'rr_footer_copyright', '' );
?>
<footer class="ft" id="footer" aria-labelledby="ft-title">

  <div class="ft__bg" aria-hidden="true">
    <picture>
      <source media="(max-width:640px)" srcset="<?php echo esc_url( get_theme_mod( 'rr_ft_bg_sm', RR_URI . '/assets/img/ft-bg-sm.webp' ) ); ?>">
      <source media="(max-width:1100px)" srcset="<?php echo esc_url( get_theme_mod( 'rr_ft_bg_md', RR_URI . '/assets/img/ft-bg-md.webp' ) ); ?>">
      <img src="<?php echo esc_url( get_theme_mod( 'rr_ft_bg', RR_URI . '/assets/img/ft-bg.webp' ) ); ?>" width="2000" height="869" alt="" loading="lazy" decoding="async">
    </picture>
  </div>

  <div class="ft__wrap">

    <div class="ft__panel">

      <!-- brand column -->
      <div class="rv">
        <a class="ft__brand" href="<?php echo esc_url( home_url( '/' ) ); ?>" aria-label="<?php echo esc_attr( rr_site_name() ); ?>">
          <img class="ft__brandMark" src="<?php echo esc_url( rr_logo_mark() ); ?>" width="38" height="40" alt="<?php echo esc_attr( rr_site_name() ); ?>" loading="lazy" decoding="async">
          <span class="ft__brandSep" aria-hidden="true"></span>
          <span class="ft__brandName" id="ft-title"><?php echo esc_html( rr_site_name() ); ?></span>
        </a>

        <p class="ft__follow"><?php esc_html_e( 'Follow Us:', 'realtor-raihan' ); ?></p>
        <div class="ft__socials">
          <a class="ft__soc" href="<?php echo esc_url( rr_whatsapp() ); ?>" target="_blank" rel="noopener" aria-label="WhatsApp">
            <svg viewBox="0 0 24 24" fill="currentColor"><path d="M12 2a10 10 0 0 0-8.6 15.1L2 22l5-1.3A10 10 0 1 0 12 2Zm0 1.8a8.2 8.2 0 0 1 0 16.4 8.1 8.1 0 0 1-4.2-1.1l-.3-.2-3 .8.8-2.9-.2-.3A8.2 8.2 0 0 1 12 3.8Zm-3 4c-.2 0-.5.1-.7.3-.3.3-.8.8-.8 1.9s.8 2.1 1 2.2c.1.2 1.6 2.4 3.9 3.4 1.9.8 2.3.7 2.7.6.5 0 1.2-.5 1.4-1 .2-.5.2-.9.1-1l-.5-.3-1.4-.7c-.2-.1-.4-.1-.5.1l-.6.8c-.1.2-.3.2-.5.1-.2-.1-.9-.3-1.7-1a6.3 6.3 0 0 1-1.2-1.5c-.1-.2 0-.3.1-.4l.3-.4.2-.4v-.4l-.7-1.6c-.2-.4-.4-.4-.5-.4h-.5Z"/></svg>
          </a>
          <a class="ft__soc" href="mailto:<?php echo esc_attr( rr_email() ); ?>" aria-label="Email">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><rect x="2.5" y="4.5" width="19" height="15" rx="2.5"/><path d="m3 6.5 9 6 9-6"/></svg>
          </a>
          <a class="ft__soc" href="<?php echo esc_attr( rr_phone_href() ); ?>" aria-label="Call">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M22 16.9v3a2 2 0 0 1-2.2 2 19.8 19.8 0 0 1-8.6-3.1 19.5 19.5 0 0 1-6-6A19.8 19.8 0 0 1 2.1 4.2 2 2 0 0 1 4.1 2h3a2 2 0 0 1 2 1.7c.1 1 .4 1.9.7 2.8a2 2 0 0 1-.5 2.1L8.1 9.9a16 16 0 0 0 6 6l1.3-1.3a2 2 0 0 1 2.1-.4c.9.3 1.8.6 2.8.7a2 2 0 0 1 1.7 2Z"/></svg>
          </a>
          <a class="ft__soc" href="<?php echo esc_url( rr_anchor( 'contact' ) ); ?>" aria-label="<?php esc_attr_e( 'Enquiry form', 'realtor-raihan' ); ?>">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15a2 2 0 0 1-2 2H8l-5 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2Z"/></svg>
          </a>
        </div>

        <p class="ft__copy">
          <?php
          if ( $copyright ) {
              echo wp_kses_post( $copyright );
          } else {
              printf(
                  /* translators: %s year */
                  esc_html__( 'Copyright © %s Realtor Raihan. All rights reserved.', 'realtor-raihan' ),
                  esc_html( gmdate( 'Y' ) )
              );
              echo '<br>';
              echo esc_html__( 'Property consultant', 'realtor-raihan' ) . ' · <em>' . esc_html__( 'Dubai, UAE', 'realtor-raihan' ) . '</em>';
          }
          ?>
        </p>
      </div>

      <!-- link columns -->
      <div class="ft__cols">
        <?php
        $columns = array(
          'Quick Links' => array(
            array( 'Home', home_url( '/' ) ),
            array( 'About Me', rr_link( 'about' ) ),
            array( 'Blog', rr_blog_url() ),
            array( 'Properties', rr_anchor( 'properties' ) ),
            array( 'Contact', rr_anchor( 'contact' ) ),
          ),
          'Services'    => array(
            array( 'Buy Property', rr_anchor( 'services' ) ),
            array( 'Sell Property', rr_anchor( 'services' ) ),
            array( 'Rent Property', rr_anchor( 'services' ) ),
            array( 'Mortgage Guidance', rr_anchor( 'services' ) ),
            array( 'Golden Visa Guidance', rr_anchor( 'services' ) ),
          ),
          'Explore'     => array(
            array( 'Why Invest in Dubai', rr_anchor( 'why-invest' ) ),
            array( 'Investment Snapshot', rr_anchor( 'snapshot' ) ),
            array( 'Client Feedback', rr_anchor( 'testimonials' ) ),
            array( 'FAQs', rr_anchor( 'faq' ) ),
          ),
        );

        foreach ( $columns as $title => $links ) :
            ?>
            <div class="rv">
              <p class="ft__h"><?php echo esc_html( $title ); ?></p>
              <ul class="ft__list">
                <?php foreach ( $links as $link ) : ?>
                  <li><a href="<?php echo esc_url( $link[1] ); ?>"><?php echo esc_html( $link[0] ); ?></a></li>
                <?php endforeach; ?>
              </ul>
            </div>
            <?php
        endforeach;
        ?>

        <div class="rv">
          <p class="ft__h"><?php esc_html_e( 'Get in Touch', 'realtor-raihan' ); ?></p>
          <ul class="ft__list" style="gap:clamp(10px,1.2vw,14px)">
            <li class="ft__row">
              <span class="ft__rowK"><?php esc_html_e( 'Phone', 'realtor-raihan' ); ?></span>
              <a href="<?php echo esc_attr( rr_phone_href() ); ?>"><?php echo esc_html( rr_phone() ); ?></a>
            </li>
            <li class="ft__row">
              <span class="ft__rowK"><?php esc_html_e( 'Email', 'realtor-raihan' ); ?></span>
              <a href="mailto:<?php echo esc_attr( rr_email() ); ?>"><?php echo esc_html( rr_email() ); ?></a>
            </li>
            <li class="ft__row">
              <span class="ft__rowK"><?php esc_html_e( 'WhatsApp', 'realtor-raihan' ); ?></span>
              <a href="<?php echo esc_url( rr_whatsapp() ); ?>" target="_blank" rel="noopener"><?php esc_html_e( 'Chat on WhatsApp', 'realtor-raihan' ); ?></a>
            </li>
            <li class="ft__row">
              <span class="ft__rowK"><?php esc_html_e( 'Based in', 'realtor-raihan' ); ?></span>
              <p><?php echo esc_html( rr_area() ); ?></p>
            </li>
          </ul>
        </div>

      </div>
    </div>

    <div class="ft__foot">
      <p class="ft__disc rv"><?php echo wp_kses_post( $disc ); ?></p>

      <div class="ft__keys rv">
        <p class="ft__keysTitle"><?php echo esc_html( rr_mod( 'rr_keywords_title', 'Service locations' ) ); ?></p>
        <p class="ft__keysTx"><?php echo esc_html( implode( ' | ', $keywords ) ); ?></p>
      </div>
    </div>

  </div>
</footer>

<a class="ft__fab" id="ftFab" href="#top" aria-label="<?php esc_attr_e( 'Back to top', 'realtor-raihan' ); ?>">
  <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 19V5M5 12l7-7 7 7"/></svg>
</a>
