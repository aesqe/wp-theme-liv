<?php $meta = liv_theme_entry_meta(); ?>

	<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<?php if( $post_thumb = get_the_post_thumbnail()) : ?>
		<div class="post-thumbnail-container"><?php echo $post_thumb ;?></div>
	<?php endif; ?>
		<header class="entry-header">
			<h1 class="entry-title"><?php the_title(); ?></h1>
		</header><!-- .entry-header -->

		<div class="entry-meta">
			<?php edit_post_link( __( 'Edit', 'liv_theme' ), '<span class="edit-link">', '</span>' ); ?>
		</div><!-- .entry-meta -->

		<?php if ( is_search() ) : ?>

		<div class="entry-summary">
			
			<?php the_excerpt(); ?>
		</div><!-- .entry-summary -->
		<?php else : ?>

		<div class="entry-content">
			<?php the_post_thumbnail(); ?>
			<?php the_content( __( 'Continue reading <span class="meta-nav">&rarr;</span>', 'liv_theme' ) ); ?>
			<?php wp_link_pages( array( 'before' => '<div class="page-links">' . __( 'Pages:', 'liv_theme' ), 'after' => '</div>' ) ); ?>
		</div><!-- .entry-content -->
		<?php endif; ?>

	</article><!-- #post -->
