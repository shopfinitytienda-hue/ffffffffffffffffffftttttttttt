<?php
/**
 * Encabezado fijo y semitransparente.
 *
 * @package TiendaAzulDirecta
 */
?><!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<header class="tad-site-header">
	<div class="tad-container tad-header-inner">
		<a class="tad-logo" href="<?php echo esc_url( home_url( '/' ) ); ?>" aria-label="<?php esc_attr_e( 'Ir al inicio', 'tienda-azul-directa' ); ?>">
			<?php if ( has_custom_logo() ) : ?>
				<?php the_custom_logo(); ?>
			<?php else : ?>
				<span class="tad-logo-mark">T</span>
				<span><?php bloginfo( 'name' ); ?></span>
			<?php endif; ?>
		</a>
		<button class="tad-menu-toggle tad-pill tad-pill--ghost" type="button" data-menu-toggle aria-expanded="false">
			<?php esc_html_e( 'Menú', 'tienda-azul-directa' ); ?>
		</button>
		<nav class="tad-main-nav" aria-label="<?php esc_attr_e( 'Menú principal', 'tienda-azul-directa' ); ?>">
			<?php
			wp_nav_menu(
				array(
					'theme_location' => 'primary',
					'container'      => false,
					'fallback_cb'    => 'tad_default_menu',
				)
			);
			?>
		</nav>
		<div class="tad-header-actions">
			<a class="tad-pill tad-pill--ghost" href="<?php echo esc_url( wc_get_page_permalink( 'myaccount' ) ); ?>"><?php esc_html_e( 'Mi cuenta', 'tienda-azul-directa' ); ?></a>
			<a class="tad-pill" href="<?php echo esc_url( wc_get_checkout_url() ); ?>"><?php esc_html_e( 'Pagar', 'tienda-azul-directa' ); ?></a>
		</div>
	</div>
</header>
<?php
function tad_default_menu() {
	echo '<ul>';
	echo '<li><a href="' . esc_url( home_url( '/' ) ) . '#inicio">' . esc_html__( 'Inicio', 'tienda-azul-directa' ) . '</a></li>';
	echo '<li><a href="' . esc_url( home_url( '/' ) ) . '#ofertas">' . esc_html__( 'Ofertas', 'tienda-azul-directa' ) . '</a></li>';
	echo '<li><a href="' . esc_url( home_url( '/' ) ) . '#productos">' . esc_html__( 'Productos', 'tienda-azul-directa' ) . '</a></li>';
	echo '<li><a href="' . esc_url( wc_get_page_permalink( 'myaccount' ) ) . '">' . esc_html__( 'Ingresar', 'tienda-azul-directa' ) . '</a></li>';
	echo '</ul>';
}
?>
<main id="inicio">
