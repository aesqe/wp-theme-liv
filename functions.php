<?php

$content_width = 600;


function liv_theme_setup()
{
	load_theme_textdomain( 'liv_theme', get_template_directory() . '/languages' );

	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'automatic-feed-links' );
	add_theme_support( 'title-tag' );

	add_theme_support( 'html5', array(
		'search-form', 'comment-form', 'comment-list', 'gallery', 'caption'
	));

	add_theme_support( 'post-formats', array(
		'aside', 'image', 'video', 'quote', 'link', 'gallery', 'status', 'audio', 'chat'
	));

	set_post_thumbnail_size( 600, 9999 ); // Unlimited height, soft crop

	if ( is_singular() ) {
		wp_enqueue_script( "comment-reply" );
	}

	register_nav_menus( array(
		'primary' => __( 'Primary Menu', 'liv_theme' )
	));

	add_editor_style();
}
add_action( 'after_setup_theme', 'liv_theme_setup', 100 );


function liv_theme_fontawesome()
{
	$google_fonts_uri = 'http://fonts.googleapis.com/css?family=Lato:700,400|PT+Serif:700,400,400italic';
	
	wp_enqueue_style( 'liv_theme-fontawesome', get_stylesheet_directory_uri() . '/font-awesome.css' );
	wp_enqueue_style( 'liv_theme-googlefonts', $google_fonts_uri);
	wp_enqueue_style( 'liv_theme-style', get_stylesheet_uri() );
}
add_action( 'wp_enqueue_scripts', 'liv_theme_fontawesome' );


function liv_theme_widgets_init()
{
	register_sidebar( array(
		'name' => __( 'Footer Widget Area', 'liv_theme' ),
		'id' => 'footer',
		'description' => __( 'Appears in the footer', 'liv_theme' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget' => '</aside>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );
}
add_action( 'widgets_init', 'liv_theme_widgets_init' );


function liv_theme_comment( $comment, $args, $depth )
{
	$GLOBALS['comment'] = $comment;

	switch ( $comment->comment_type ) :
		case 'pingback' :
		case 'trackback' :
		// Display trackbacks differently than normal comments.
	?>
	<li <?php comment_class(); ?> id="comment-<?php comment_ID(); ?>">
		<p><?php _e( 'Pingback:', 'liv_theme' ); ?> <?php comment_author_link(); ?> <?php edit_comment_link( __( '(Edit)', 'liv_theme' ), '<span class="edit-link">', '</span>' ); ?></p>
	<?php
			break;
		default :
		// Proceed with normal comments.
		global $post;
	?>
	<li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">
		<article id="comment-<?php comment_ID(); ?>" class="comment">
			<header class="comment-meta comment-author vcard">
				<?php
					echo get_avatar( $comment, 44 );
					printf( '<cite><b class="fn">%1$s</b> %2$s</cite>',
						get_comment_author_link(),
						// If current post author is also comment author, make it known visually.
						( $comment->user_id === $post->post_author ) ? '<span>' . __( 'Post author', 'liv_theme' ) . '</span>' : ''
					);
					printf( '<a href="%1$s"><time datetime="%2$s">%3$s</time></a>',
						esc_url( get_comment_link( $comment->comment_ID ) ),
						get_comment_time( 'c' ),
						/* translators: 1: date, 2: time */
						sprintf( __( '%1$s at %2$s', 'liv_theme' ), get_comment_date(), get_comment_time() )
					);
				?>
				<?php edit_comment_link( __( 'Edit', 'liv_theme' ), '<p class="edit-link">', '</p>' ); ?>
			</header><!-- .comment-meta -->

			<?php if ( '0' == $comment->comment_approved ) : ?>
				<p class="comment-awaiting-moderation"><?php _e( 'Your comment is awaiting moderation.', 'liv_theme' ); ?></p>
			<?php endif; ?>

			<section class="comment-content comment">
				<?php comment_text(); ?>
			</section><!-- .comment-content -->

			<div class="reply">
				<?php comment_reply_link( array_merge( $args, array( 'reply_text' => __( 'Reply', 'liv_theme' ), 'after' => ' <span>&darr;</span>', 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?>
			</div><!-- .reply -->
		</article><!-- #comment-## -->
	<?php
		break;
	endswitch; // end comment_type check
}


function liv_theme_entry_meta()
{
	// Translators: used between list items, there is a space after the comma.
	$categories_list = get_the_category_list( __( ', ', 'liv_theme' ) );

	// Translators: used between list items, there is a space after the comma.
	$tag_list = get_the_tag_list( '', __( ', ', 'liv_theme' ) );

	$date = sprintf( '<a href="%1$s" title="%2$s" rel="bookmark" class="date-bookmark"><time class="entry-date" datetime="%3$s">%4$s</time></a>',
		esc_url( get_permalink() ),
		esc_attr( get_the_time() ),
		esc_attr( get_the_date( 'c' ) ),
		esc_html( get_the_date() )
	);

	$author = sprintf( '<span class="author vcard"><a class="url fn n" href="%1$s" title="%2$s" rel="author">%3$s</a></span>',
		esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ),
		esc_attr( sprintf( __( 'View all posts by %s', 'liv_theme' ), get_the_author() ) ),
		get_the_author()
	);

	// Translators: 1 is category, 2 is tag, 3 is the date and 4 is the author's name.
	if ( $tag_list ) {
		$utility_text = __( 'This entry was posted on %3$s in %1$s and tagged %2$s', 'liv_theme' );
	} elseif ( $categories_list ) {
		$utility_text = __( 'This entry was posted on %3$s in %1$s', 'liv_theme' );
	} else {
		$utility_text = __( '%3$s', 'liv_theme' );
	}

	return (object) array(
		'categories' => $categories_list,
		'tags' => $tag_list,
		'date' => $date,
		'author' => $author
	);
}


if ( ! function_exists( 'liv_theme_content_nav' ) ) :
/**
 * Displays navigation to next/previous pages when applicable.
 *
 * @since Liv 1.0
 */
function liv_theme_content_nav( $html_id ) {
	global $wp_query;

	$html_id = esc_attr( $html_id );

	if ( $wp_query->max_num_pages > 1 ) : ?>
		<nav id="<?php echo $html_id; ?>" class="navigation" role="navigation">
			<h3 class="assistive-text"><?php _e( 'Post navigation', 'liv_theme' ); ?></h3>
			<div class="nav-previous"><?php next_posts_link( __( '<span class="meta-nav">&larr;</span> Older posts', 'liv_theme' ) ); ?></div>
			<div class="nav-next"><?php previous_posts_link( __( 'Newer posts <span class="meta-nav">&rarr;</span>', 'liv_theme' ) ); ?></div>
		</nav><!-- #<?php echo $html_id; ?> .navigation -->
	<?php endif;
}
endif;

function liv_theme_filter_wp_link_pages_link( $link, $i )
{
	if( $link == $i ) {
		return '<span class="current">' . $i . '</span>';
	}

	return $link;
}
add_filter( 'wp_link_pages_link', 'liv_theme_filter_wp_link_pages_link', 10, 2 );