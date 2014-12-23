<?php
/**
 * The Template for displaying all single posts.
 *
 * @package WordPress
 * @subpackage Twenty_Twelve
 * @since Twenty Twelve 1.0
 */

get_header(); ?>

	<div id="primary" class="site-content">
		<div id="content" role="main">

			<?php while ( have_posts() ) : the_post(); ?>

				<?php get_template_part( 'content-single', get_post_format() ); ?>

				<nav class="nav-single">
					<h3 class="assistive-text"><?php _e( 'Post navigation', 'liv_theme' ); ?></h3>
					<span class="nav-previous"><?php previous_post_link( '%link', '<span class="meta-nav">' . _x( '<i class="icon-long-arrow-left"></i>', 'Previous post link', 'liv_theme' ) . '</span> %title' ); ?></span>
					<span class="nav-next"><?php next_post_link( '%link', '%title <span class="meta-nav">' . _x( '<i class="icon-long-arrow-right"></i>', 'Next post link', 'liv_theme' ) . '</span>' ); ?></span>
				</nav><!-- .nav-single -->


				<?php comments_template( '', true ); ?>

			<?php endwhile; // end of the loop. ?>

		</div><!-- #content -->
	</div><!-- #primary -->

<?php get_footer(); ?>