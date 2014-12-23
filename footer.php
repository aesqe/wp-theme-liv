
	</div><!-- #main .wrapper -->

	<footer id="colophon" role="contentinfo">

		<?php get_sidebar('footer'); ?>

		<div class="site-info">
			<?php do_action( 'liv_theme_credits' ); ?>
			<p><a href="<?php echo esc_url( __( 'http://wordpress.org/', 'liv_theme' ) ); ?>" title="<?php esc_attr_e( 'Semantic Personal Publishing Platform', 'liv_theme' ); ?>"><?php printf( __( 'Proudly powered by %s', 'liv_theme' ), 'WordPress' ); ?></a></p>
		</div><!-- .site-info -->
	</footer><!-- #colophon -->

</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>