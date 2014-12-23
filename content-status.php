<?php $meta = liv_theme_entry_meta(); ?>

	<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
		<header class="entry-header">
		<?php if ( is_single() ) : ?>
			<h1 class="entry-title"><?php the_title(); ?></h1>
			<?php else : ?>
			<h1 class="entry-title">
				<a href="<?php the_permalink(); ?>" rel="bookmark"><?php the_title(); ?></a>
			</h1>
		<?php endif; // is_single() ?>
		</header><!-- .entry-header -->

		<div class="entry-meta">
			<span class="entry-date"><?php echo __('Posted on', 'liv_theme') . ' ' . $meta->date . '</span> <span class="entry-categories">' . __('in', 'liv_theme') . ' ' . $meta->categories; ?></span>
			<span class="entry-tags"># <?php echo $meta->tags; ?></span>
			<?php if ( is_singular() && comments_open() ) : ?>
				<div class="comments-link"> | <?php comments_popup_link( '<span class="leave-reply">' . __( 'Leave a reply', 'liv_theme' ) . '</span>', __( '1 Reply', 'liv_theme' ), __( '% Replies', 'liv_theme' ) ); ?></div>
			<?php endif; ?>
			<?php edit_post_link( __( 'Edit', 'liv_theme' ), ' | <span class="edit-link">', '</span>' ); ?>
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
