<?php
/**
 * Plantilla de páginas generales, cuenta y checkout.
 *
 * @package TiendaAzulDirecta
 */

get_header();
?>
<section class="tad-section">
	<div class="tad-container">
		<?php while ( have_posts() ) : the_post(); ?>
			<div class="tad-section-head">
				<div>
					<span class="tad-kicker"><?php esc_html_e( 'Área segura', 'tienda-azul-directa' ); ?></span>
					<h1><?php the_title(); ?></h1>
				</div>
			</div>
			<div class="tad-account-panel">
				<?php the_content(); ?>
			</div>
		<?php endwhile; ?>
	</div>
</section>
<?php get_footer(); ?>
