<?php
/**
 * Tarjeta de producto reutilizable.
 *
 * @package TiendaAzulDirecta
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$product = wc_get_product( get_the_ID() );
if ( ! $product ) {
	return;
}
?>
<article <?php wc_product_class( 'tad-product-card', $product ); ?>>
	<a href="<?php the_permalink(); ?>">
		<?php echo get_the_post_thumbnail( get_the_ID(), 'woocommerce_thumbnail' ); ?>
		<h3><?php the_title(); ?></h3>
	</a>
	<?php tad_product_badges( $product ); ?>
	<div class="tad-card-actions">
		<div class="tad-price"><?php echo wp_kses_post( $product->get_price_html() ); ?></div>
		<a class="tad-button" href="<?php echo esc_url( $product->add_to_cart_url() ); ?>"><?php esc_html_e( 'Comprar', 'tienda-azul-directa' ); ?></a>
	</div>
</article>
