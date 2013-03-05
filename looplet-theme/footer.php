<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the id=main div and all content after
 *
 * @package Looplet
 * @since Looplet 1.0
 */
?>

	</div><!-- #main .site-main -->

	<footer id="colophon" class="site-footer" role="contentinfo">
		<div class="site-info">
			<?php do_action( 'looplet_credits' ); ?>
			<a href="http://wordpress.org/" title="<?php esc_attr_e( 'A Semantic Personal Publishing Platform', 'looplet' ); ?>" rel="generator"><?php printf( __( 'Proudly powered by %s', 'looplet' ), 'WordPress' ); ?></a>
			<span class="sep"> | </span>
			<?php printf( __( 'Theme: %1$s by %2$s.', 'looplet' ), 'Looplet', '<a href="https://twitter.com/jaydhoffmann" rel="designer">Jay Hoffmann</a>' ); ?>
		</div><!-- .site-info -->
	</footer><!-- #colophon .site-footer -->
</div><!-- #page .hfeed .site -->

<script src="<?php echo get_template_directory_uri() ?>/js/prism.js"></script>

<?php wp_footer(); ?>

</body>
</html>