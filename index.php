<?php
/**
 * Plantilla base.
 *
 * @package TiendaAzulDirecta
 */

get_header();
?>
<section class="tad-section">
	<div class="tad-container tad-products-grid">
		<?php if ( have_posts() ) : ?>
			<?php while ( have_posts() ) : the_post(); ?>
				<article class="tad-product-card">
					<a href="<?php the_permalink(); ?>">
						<?php the_post_thumbnail( 'large' ); ?>
						<h2><?php the_title(); ?></h2>
					</a>
					<?php the_excerpt(); ?>
				</article>
			<?php endwhile; ?>
		<?php endif; ?>
	</div>
</section>
<?php get_footer(); ?>
