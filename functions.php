<?php
/**
 * Funciones principales de Tienda Azul Directa.
 *
 * @package TiendaAzulDirecta
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function tad_theme_setup() {
	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'custom-logo', array( 'height' => 96, 'width' => 220, 'flex-height' => true, 'flex-width' => true ) );
	add_theme_support( 'woocommerce' );
	add_theme_support( 'wc-product-gallery-zoom' );
	add_theme_support( 'wc-product-gallery-lightbox' );
	add_theme_support( 'wc-product-gallery-slider' );

	register_nav_menus(
		array(
			'primary' => __( 'Menú principal', 'tienda-azul-directa' ),
			'legal'   => __( 'Enlaces legales', 'tienda-azul-directa' ),
		)
	);
}
add_action( 'after_setup_theme', 'tad_theme_setup' );

function tad_enqueue_assets() {
	wp_enqueue_style( 'tad-style', get_stylesheet_uri(), array(), wp_get_theme()->get( 'Version' ) );
	wp_enqueue_script( 'tad-store', get_template_directory_uri() . '/assets/js/store.js', array(), wp_get_theme()->get( 'Version' ), true );
}
add_action( 'wp_enqueue_scripts', 'tad_enqueue_assets' );

function tad_woocommerce_product_query( $args = array() ) {
	$defaults = array(
		'post_type'      => 'product',
		'post_status'    => 'publish',
		'posts_per_page' => 8,
		'orderby'        => 'date',
		'order'          => 'DESC',
	);

	return new WP_Query( wp_parse_args( $args, $defaults ) );
}

function tad_product_badges( $product ) {
	if ( ! $product ) {
		return;
	}

	echo '<div class="tad-product-badges">';
	echo '<span class="tad-badge tad-badge--success">' . esc_html__( 'Envío gratis', 'tienda-azul-directa' ) . '</span>';
	echo '<span class="tad-badge">' . esc_html__( 'Pago contra entrega', 'tienda-azul-directa' ) . '</span>';
	if ( $product->is_on_sale() ) {
		echo '<span class="tad-badge tad-badge--danger">' . esc_html__( 'Oferta', 'tienda-azul-directa' ) . '</span>';
	}
	echo '</div>';
}

function tad_add_to_cart_redirect_to_checkout() {
	return wc_get_checkout_url();
}
add_filter( 'woocommerce_add_to_cart_redirect', 'tad_add_to_cart_redirect_to_checkout' );

function tad_skip_cart_page() {
	if ( is_cart() && ! WC()->cart->is_empty() ) {
		wp_safe_redirect( wc_get_checkout_url() );
		exit;
	}
}
add_action( 'template_redirect', 'tad_skip_cart_page' );

function tad_change_add_to_cart_text() {
	return __( 'Comprar ahora', 'tienda-azul-directa' );
}
add_filter( 'woocommerce_product_single_add_to_cart_text', 'tad_change_add_to_cart_text' );
add_filter( 'woocommerce_product_add_to_cart_text', 'tad_change_add_to_cart_text' );

function tad_force_free_shipping_label( $label, $method ) {
	if ( false !== strpos( $method->method_id, 'free_shipping' ) ) {
		return __( 'Envío gratis', 'tienda-azul-directa' );
	}

	return $label;
}
add_filter( 'woocommerce_cart_shipping_method_full_label', 'tad_force_free_shipping_label', 10, 2 );

function tad_cod_gateway_title( $title, $gateway_id ) {
	if ( 'cod' === $gateway_id ) {
		return __( 'Pago contra entrega', 'tienda-azul-directa' );
	}

	return $title;
}
add_filter( 'woocommerce_gateway_title', 'tad_cod_gateway_title', 10, 2 );

function tad_checkout_intro() {
	echo '<div class="tad-free-shipping-bar">' . esc_html__( 'Compra directa segura: sin carrito, envío gratis y pago contra entrega disponible.', 'tienda-azul-directa' ) . '</div>';
}
add_action( 'woocommerce_before_checkout_form', 'tad_checkout_intro', 5 );

function tad_order_success_recommendations( $order_id ) {
	$recommendations = tad_woocommerce_product_query(
		array(
			'posts_per_page' => 4,
			'post__not_in'   => array(),
		)
	);

	if ( ! $recommendations->have_posts() ) {
		return;
	}
	?>
	<section class="tad-success-recommendations">
		<div class="tad-section-head">
			<div>
				<span class="tad-kicker"><?php esc_html_e( 'También te puede gustar', 'tienda-azul-directa' ); ?></span>
				<h2><?php esc_html_e( 'Recomendaciones para tu próxima compra', 'tienda-azul-directa' ); ?></h2>
			</div>
		</div>
		<div class="tad-products-grid">
			<?php
			while ( $recommendations->have_posts() ) {
				$recommendations->the_post();
				wc_get_template_part( 'content', 'product-card' );
			}
			wp_reset_postdata();
			?>
		</div>
	</section>
	<?php
}
add_action( 'woocommerce_thankyou', 'tad_order_success_recommendations', 20 );

function tad_product_video_url( $product_id ) {
	return esc_url( get_post_meta( $product_id, '_tad_product_video_url', true ) );
}
