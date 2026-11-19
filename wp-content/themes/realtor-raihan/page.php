<?php
/**
 * A normal page: the content the client writes in the editor, inside the
 * site chrome, with the same type scale as the rest of the site.
 *
 * @package RealtorRaihan
 */

get_header();
?>
<div id="top" aria-hidden="true"></div>
<main class="rr-page" id="content">
	<header class="rr-page__head">
		<div class="sec__wrap">
			<p class="tag"><?php echo esc_html( get_bloginfo( 'name' ) ); ?></p>
			<h1><?php the_title(); ?></h1>
		</div>
	</header>
	<div class="sec__wrap rr-page__body">
		<?php
		while ( have_posts() ) :
			the_post();
			the_content();
		endwhile;
		?>
	</div>
</main>
<?php
get_footer();
