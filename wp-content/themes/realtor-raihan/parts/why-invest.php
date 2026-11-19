<?php
/**
 * Section 3: why invest in Dubai (13 cards, first one is the photo feature).
 *
 * @package RealtorRaihan
 */

$cards = rr_h_rows( 'why_invest' );
$icon  = '<span class="card__ico" aria-hidden="true"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M7 17 17 7M9 7h8v8"/></svg></span>';
?>
<section class="wi" id="why-invest" aria-labelledby="wi-title">
  <div class="wi__spot" aria-hidden="true"></div>
  <div class="wi__gridTex" aria-hidden="true"></div>
  <span class="wi__ghost" aria-hidden="true"><?php echo esc_html( rr_h( 'wi_num' ) ); ?></span>

  <div class="wi__wrap">

    <div class="wi__meta">
      <p class="tag"><?php echo esc_html( rr_h( 'wi_tag' ) ); ?></p>
    </div>

    <div class="wi__head">
      <?php rr_head_lines( rr_h( 'wi_title' ), 'wi-title' ); ?>

      <div class="wi__aside rv">
        <p><?php echo wp_kses_post( rr_h( 'wi_aside' ) ); ?></p>
      </div>
    </div>

    <div class="wi__stat rv">
      <span class="wi__tickerNum"><?php echo esc_html( rr_h( 'wi_num' ) ); ?></span>
      <span class="wi__statBody">
        <span class="wi__tickerTxt"><?php echo esc_html( rr_h( 'wi_num_tx' ) ); ?></span>
      </span>
    </div>

    <div class="wi__cards">
      <?php foreach ( $cards as $i => $card ) : ?>
        <a class="card<?php echo 0 === $i ? ' card--feature' : ''; ?>" href="<?php echo esc_url( rr_anchor( 'contact' ) ); ?>">
          <div class="card__img"><img src="<?php echo esc_url( rr_img( isset( $card['photo'] ) ? $card['photo'] : '', 'skyline-sunset-wide.webp' ) ); ?>" alt="" loading="lazy" decoding="async"></div>
          <div class="card__veil"></div><span class="card__sheen"></span>
          <div class="card__top">
            <span class="card__num"><?php echo esc_html( rr_num( $i + 1 ) ); ?></span>
            <?php echo $icon; // phpcs:ignore ?>
          </div>
          <h3><?php echo esc_html( $card['title'] ); ?></h3>
          <p><?php echo wp_kses_post( $card['text'] ); ?></p>
        </a>
      <?php endforeach; ?>
    </div>

  </div>
</section>
