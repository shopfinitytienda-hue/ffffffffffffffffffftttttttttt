<?php
/**
 * Página de inicio con slider, ofertas, banners y productos.
 *
 * @package TiendaAzulDirecta
 */

get_header();
$featured = tad_woocommerce_product_query(
	array(
		'posts_per_page' => 3,
		'tax_query'      => array(
			array(
				'taxonomy' => 'product_visibility',
				'field'    => 'name',
				'terms'    => 'featured',
			),
		),
	)
);
if ( ! $featured->have_posts() ) {
	$featured = tad_woocommerce_product_query( array( 'posts_per_page' => 3 ) );
}
$sales = tad_woocommerce_product_query(
	array(
		'posts_per_page' => 8,
		'post__in'       => wc_get_product_ids_on_sale(),
	)
);
$products = tad_woocommerce_product_query( array( 'posts_per_page' => 12 ) );
?>
<section class="tad-hero">
	<div class="tad-container tad-hero-grid">
		<div>
			<span class="tad-kicker"><?php esc_html_e( 'Tienda WooCommerce conectada', 'tienda-azul-directa' ); ?></span>
			<h1><?php esc_html_e( 'Compra directa, moderna y', 'tienda-azul-directa' ); ?> <span class="tad-gradient-text"><?php esc_html_e( 'sin carrito', 'tienda-azul-directa' ); ?></span></h1>
			<p class="tad-lead"><?php esc_html_e( 'Plantilla adaptable para móviles, tablets y escritorio con checkout rápido, envío gratis y pago contra entrega.', 'tienda-azul-directa' ); ?></p>
			<div class="tad-hero-actions">
				<a class="tad-button" href="#productos"><?php esc_html_e( 'Ver productos', 'tienda-azul-directa' ); ?></a>
				<a class="tad-button tad-pill--ghost" href="<?php echo esc_url( wc_get_page_permalink( 'myaccount' ) ); ?>"><?php esc_html_e( 'Iniciar sesión o registrarme', 'tienda-azul-directa' ); ?></a>
			</div>
			<div class="tad-free-shipping-bar"><?php esc_html_e( '🚚 Envío gratis en productos seleccionados · Pago contra entrega disponible', 'tienda-azul-directa' ); ?></div>
		</div>
		<div class="tad-product-slider" data-slider>
			<div class="tad-slider-track">
				<?php while ( $featured->have_posts() ) : $featured->the_post(); $product = wc_get_product( get_the_ID() ); ?>
					<article class="tad-slide">
						<a class="tad-slide-card" href="<?php the_permalink(); ?>">
							<?php echo get_the_post_thumbnail( get_the_ID(), 'large' ); ?>
							<div class="tad-slide-content">
								<?php tad_product_badges( $product ); ?>
								<h2><?php the_title(); ?></h2>
								<div class="tad-price"><?php echo wp_kses_post( $product ? $product->get_price_html() : '' ); ?></div>
							</div>
						</a>
					</article>
				<?php endwhile; wp_reset_postdata(); ?>
			</div>
		</div>
	</div>
</section>
<section id="ofertas" class="tad-section">
	<div class="tad-container">
		<div class="tad-section-head">
			<div>
				<span class="tad-kicker"><?php esc_html_e( 'Oferta relámpago', 'tienda-azul-directa' ); ?></span>
				<h2><?php esc_html_e( 'Aprovecha antes de que termine', 'tienda-azul-directa' ); ?></h2>
			</div>
			<div class="tad-countdown" data-countdown data-hours="24" aria-label="<?php esc_attr_e( 'Conteo de oferta', 'tienda-azul-directa' ); ?>"></div>
		</div>
		<div class="tad-flash-carousel" data-carousel>
			<div class="tad-carousel-track">
				<?php
				$query_for_sales = $sales->have_posts() ? $sales : tad_woocommerce_product_query( array( 'posts_per_page' => 8 ) );
				while ( $query_for_sales->have_posts() ) : $query_for_sales->the_post();
					?>
					<div class="tad-carousel-item"><?php wc_get_template_part( 'content', 'product-card' ); ?></div>
				<?php endwhile; wp_reset_postdata(); ?>
			</div>
		</div>
	</div>
</section>
<section class="tad-section">
	<div class="tad-container">
		<article class="tad-ad-card">
			<div>
				<span class="tad-kicker"><?php esc_html_e( 'Banner publicitario', 'tienda-azul-directa' ); ?></span>
				<h2><?php esc_html_e( 'Producto destacado con entrega rápida', 'tienda-azul-directa' ); ?></h2>
				<p><?php esc_html_e( 'Promociona aquí tu producto estrella con imagen, precio, envío gratis y llamada a compra directa.', 'tienda-azul-directa' ); ?></p>
				<a class="tad-button tad-pill--ghost" href="#productos"><?php esc_html_e( 'Comprar oferta', 'tienda-azul-directa' ); ?></a>
			</div>
			<?php
			$ad_product = tad_woocommerce_product_query( array( 'posts_per_page' => 1 ) );
			if ( $ad_product->have_posts() ) :
				$ad_product->the_post();
				echo get_the_post_thumbnail( get_the_ID(), 'large' );
				wp_reset_postdata();
			endif;
			?>
		</article>
	</div>
</section>
<section id="productos" class="tad-section">
	<div class="tad-container">
		<div class="tad-section-head">
			<div>
				<span class="tad-kicker"><?php esc_html_e( 'Nuestros productos', 'tienda-azul-directa' ); ?></span>
				<h2><?php esc_html_e( 'Catálogo adaptable', 'tienda-azul-directa' ); ?></h2>
			</div>
			<p><?php esc_html_e( 'En móviles se muestran dos columnas; en escritorio la cuadrícula se adapta automáticamente.', 'tienda-azul-directa' ); ?></p>
		</div>
		<div class="tad-products-grid">
			<?php while ( $products->have_posts() ) : $products->the_post(); ?>
				<?php wc_get_template_part( 'content', 'product-card' ); ?>
			<?php endwhile; wp_reset_postdata(); ?>
		</div>
	</div>
</section>
<?php get_footer(); ?>
