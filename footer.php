<?php
/**
 * Cierre del tema con enlaces legales mínimos.
 *
 * @package TiendaAzulDirecta
 */
?>
</main>
<footer class="tad-legal-footer">
	<div class="tad-container">
		<div>&copy; <?php echo esc_html( gmdate( 'Y' ) ); ?> <?php bloginfo( 'name' ); ?>. <?php esc_html_e( 'Todos los derechos reservados.', 'tienda-azul-directa' ); ?></div>
		<nav aria-label="<?php esc_attr_e( 'Enlaces legales', 'tienda-azul-directa' ); ?>">
			<?php
			wp_nav_menu(
				array(
					'theme_location' => 'legal',
					'container'      => false,
					'fallback_cb'    => 'tad_legal_menu',
					'depth'          => 1,
				)
			);
			?>
		</nav>
	</div>
</footer>
<?php
function tad_legal_menu() {
	echo '<a href="' . esc_url( home_url( '/terminos-y-condiciones/' ) ) . '">' . esc_html__( 'Términos y condiciones', 'tienda-azul-directa' ) . '</a>';
	echo '<a href="' . esc_url( home_url( '/privacidad/' ) ) . '">' . esc_html__( 'Privacidad', 'tienda-azul-directa' ) . '</a>';
}
wp_footer();
?>
</body>
</html>
