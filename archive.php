<?php get_header(); ?>

	<section id="primary" class="site-content">
		<div id="content" role="main">

		<?php if ( have_posts() ) : ?>
			<header class="archive-header">
				<h1 class="archive-title"><?php
					if ( is_day() ) :
						printf( __( 'Daily Archives: %s', 'liv_theme' ), '<span>' . get_the_date() . '</span>' );
					elseif ( is_month() ) :
						printf( __( 'Monthly Archives: %s', 'liv_theme' ), '<span>' . get_the_date( _x( 'F Y', 'monthly archives date format', 'liv_theme' ) ) . '</span>' );
					elseif ( is_year() ) :
						printf( __( 'Yearly Archives: %s', 'liv_theme' ), '<span>' . get_the_date( _x( 'Y', 'yearly archives date format', 'liv_theme' ) ) . '</span>' );
					else :
						_e( 'Archives', 'liv_theme' );
					endif;
				?></h1>
			</header><!-- .archive-header -->

			<?php
			while ( have_posts() ) : the_post();

				get_template_part( 'content', get_post_format() );

			endwhile;

			liv_theme_content_nav( 'nav-below' );
			?>

		<?php else : ?>
			<?php get_template_part( 'content', 'none' ); ?>
		<?php endif; ?>

		</div><!-- #content -->
	</section><!-- #primary -->

<?php get_footer(); ?>