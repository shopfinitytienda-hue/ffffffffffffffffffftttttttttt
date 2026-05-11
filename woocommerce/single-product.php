<?php
/**
 * Producto individual con imágenes, vídeos, descripción, detalles, variantes y compra directa.
 *
 * @package TiendaAzulDirecta
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header( 'shop' );
while ( have_posts() ) :
	the_post();
	$product   = wc_get_product( get_the_ID() );
	$video_url = tad_product_video_url( get_the_ID() );
	?>
	<section class="tad-product-page">
		<div class="tad-container tad-product-detail-grid">
			<div class="tad-product-gallery">
				<?php echo get_the_post_thumbnail( get_the_ID(), 'large' ); ?>
				<?php
				foreach ( $product->get_gallery_image_ids() as $image_id ) {
					echo wp_get_attachment_image( $image_id, 'large' );
				}
				if ( $video_url ) :
					?>
					<video controls preload="metadata" src="<?php echo esc_url( $video_url ); ?>"></video>
				<?php endif; ?>
			</div>
			<aside class="tad-product-summary">
				<?php tad_product_badges( $product ); ?>
				<h1><?php the_title(); ?></h1>
				<div class="tad-price"><?php echo wp_kses_post( $product->get_price_html() ); ?></div>
				<p><?php echo wp_kses_post( wpautop( $product->get_short_description() ) ); ?></p>
				<ul class="tad-product-meta-list">
					<li><strong><?php esc_html_e( 'Envío', 'tienda-azul-directa' ); ?></strong><span><?php esc_html_e( 'Gratis', 'tienda-azul-directa' ); ?></span></li>
					<li><strong><?php esc_html_e( 'Pago', 'tienda-azul-directa' ); ?></strong><span><?php esc_html_e( 'Contra entrega disponible', 'tienda-azul-directa' ); ?></span></li>
					<li><strong><?php esc_html_e( 'Disponibilidad', 'tienda-azul-directa' ); ?></strong><span><?php echo esc_html( $product->is_in_stock() ? __( 'Disponible', 'tienda-azul-directa' ) : __( 'Agotado', 'tienda-azul-directa' ) ); ?></span></li>
					<li><strong><?php esc_html_e( 'SKU', 'tienda-azul-directa' ); ?></strong><span><?php echo esc_html( $product->get_sku() ?: __( 'Consultar', 'tienda-azul-directa' ) ); ?></span></li>
				</ul>
				<div class="tad-buy-box">
					<?php woocommerce_template_single_add_to_cart(); ?>
				</div>
			</aside>
		</div>
		<div class="tad-container tad-section">
			<div class="tad-section-head">
				<div>
					<span class="tad-kicker"><?php esc_html_e( 'Descripción y detalles', 'tienda-azul-directa' ); ?></span>
					<h2><?php esc_html_e( 'Información del producto', 'tienda-azul-directa' ); ?></h2>
				</div>
			</div>
			<div class="tad-account-panel">
				<?php the_content(); ?>
				<?php wc_display_product_attributes( $product ); ?>
			</div>
		</div>
	</section>
	<?php
endwhile;
get_footer( 'shop' );
