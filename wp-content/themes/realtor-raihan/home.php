<?php
/**
 * The blog index: hero, topic filter, post grid, newsletter band.
 * Posts come from WordPress, so a new article appears here automatically.
 *
 * @package RealtorRaihan
 */

get_header();

$hero_q = new WP_Query(
	array(
		'post_type'      => 'post',
		'posts_per_page' => 1,
		'ignore_sticky_posts' => false,
	)
);
$hero_id = $hero_q->have_posts() ? $hero_q->posts[0]->ID : 0;
wp_reset_postdata();

$terms = get_terms(
	array(
		'taxonomy'   => 'category',
		'hide_empty' => true,
	)
);
?>
<div id="top" aria-hidden="true"></div>

<!-- hero -->
<section class="bl-hero" id="top-blog" aria-labelledby="bl-title">
  <div class="bl-hero__bg" aria-hidden="true">
    <img src="<?php echo esc_url( get_theme_mod( 'rr_blog_hero', RR_URI . '/assets/img/skyline-dusk-wide.webp' ) ); ?>" alt="" loading="eager" decoding="async">
  </div>
  <div class="bl-hero__wrap">
    <p class="bl-meta-eyebrow"><i aria-hidden="true"></i><span><?php echo esc_html( rr_mod( 'rr_blog_eyebrow', 'Property notes' ) ); ?></span></p>
    <h1 id="bl-title"><?php echo wp_kses( rr_mod( 'rr_blog_title', 'Dubai property,<br>explained <em>properly.</em>' ), array( 'br' => array(), 'em' => array() ) ); ?></h1>
    <p class="bl-hero__lede"><?php echo esc_html( rr_mod( 'rr_blog_lede', 'Service charges, yields, payment plans, handover snags and the paperwork nobody warns you about. These are the notes I would send a friend before they buy. Short, specific, and written from deals I have actually closed.' ) ); ?></p>
  </div>
</section>

<!-- intro -->
<section class="bl-titles" aria-labelledby="bl-list-title">
  <div class="bl-titles__wrap">
    <p class="tag tag--center"><?php esc_html_e( 'Blog', 'realtor-raihan' ); ?></p>
    <h2 id="bl-list-title"><?php echo wp_kses( rr_mod( 'rr_blog_list_title', 'Discover our latest Dubai<br>property <em>insights.</em>' ), array( 'br' => array(), 'em' => array() ) ); ?></h2>
  </div>
</section>

<!-- list -->
<section class="bl-list" id="notes">
  <div class="bl-list__wrap">
    <div class="bl-list__head">
      <div class="bl-filter" role="group" aria-label="<?php esc_attr_e( 'Filter by topic', 'realtor-raihan' ); ?>">
        <button class="bl-chip is-on" type="button" data-cat="all"><?php esc_html_e( 'All', 'realtor-raihan' ); ?></button>
        <?php
        if ( $terms && ! is_wp_error( $terms ) ) {
            foreach ( $terms as $term ) {
                printf(
                    '<button class="bl-chip" type="button" data-cat="%1$s">%2$s</button>',
                    esc_attr( $term->slug ),
                    esc_html( $term->name )
                );
            }
        }
        ?>
      </div>
    </div>

    <div class="bl-grid" id="blGrid">
      <?php
      if ( have_posts() ) :
          while ( have_posts() ) :
              the_post();
              $cats     = get_the_category();
              $cat_slug = $cats ? $cats[0]->slug : '';
              $cat_name = $cats ? $cats[0]->name : '';
              ?>
              <a class="bl-card" href="<?php the_permalink(); ?>" data-cat="<?php echo esc_attr( $cat_slug ); ?>">
                <div class="bl-card__img">
                  <?php if ( has_post_thumbnail() ) : ?>
                    <?php the_post_thumbnail( 'rr-card', array( 'loading' => 'lazy' ) ); ?>
                  <?php else : ?>
                    <img src="<?php echo esc_url( RR_URI . '/assets/img/gen-marina-night.webp' ); ?>" alt="" loading="lazy" decoding="async">
                  <?php endif; ?>
                </div>
                <div class="bl-card__body">
                  <p class="bl-card__date"><span><?php echo esc_html( get_the_date() ); ?></span><i aria-hidden="true"></i><span><?php echo esc_html( $cat_name ); ?></span></p>
                  <h3><?php the_title(); ?></h3>
                  <p><?php echo esc_html( wp_trim_words( get_the_excerpt(), 28 ) ); ?></p>
                  <span class="bl-more"><?php esc_html_e( 'Read the note', 'realtor-raihan' ); ?>
                    <?php echo rr_arrow(); // phpcs:ignore ?>
                  </span>
                </div>
              </a>
              <?php
          endwhile;
      else :
          ?>
          <p><?php esc_html_e( 'No articles yet. Add your first one under Posts.', 'realtor-raihan' ); ?></p>
        <?php endif; ?>
    </div>

    <div class="bl-pager">
      <?php
      the_posts_pagination(
          array(
              'mid_size'  => 1,
              'prev_text' => esc_html__( 'Previous', 'realtor-raihan' ),
              'next_text' => esc_html__( 'Next', 'realtor-raihan' ),
          )
      );
      ?>
    </div>
  </div>
</section>

<!-- newsletter -->
<section class="bl-new" aria-labelledby="bl-new-title">
  <div class="bl-new__wrap">
    <div>
      <h2 id="bl-new-title"><?php echo wp_kses( rr_mod( 'rr_news_title', 'One note a month,<br><em>no noise.</em>' ), array( 'br' => array(), 'em' => array() ) ); ?></h2>
      <p><?php echo esc_html( rr_mod( 'rr_news_text', 'A short email with what actually moved in the Dubai market, plus one thing worth knowing before your next viewing. Unsubscribe any time.' ) ); ?></p>
    </div>
    <form id="blForm" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>" method="post" novalidate>
      <input type="hidden" name="action" value="rr_newsletter">
      <?php wp_nonce_field( 'rr_newsletter', 'rr_newsletter_nonce' ); ?>
      <input type="email" id="blEmail" name="email" placeholder="you@example.com" aria-label="<?php esc_attr_e( 'Email address', 'realtor-raihan' ); ?>" required>
      <button class="pill pill--gold" type="submit"><?php esc_html_e( 'Subscribe', 'realtor-raihan' ); ?>
        <?php echo rr_arrow(); // phpcs:ignore ?>
      </button>
      <small id="blNote"><?php echo isset( $_GET['newsletter'] ) && 'sent' === $_GET['newsletter'] ? esc_html__( 'Thank you, you are on the list.', 'realtor-raihan' ) : esc_html__( 'One email a month. Unsubscribe any time.', 'realtor-raihan' ); ?></small>
    </form>
  </div>
</section>

<?php
get_footer();
