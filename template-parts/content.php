<?php
/**
 * Template part for displaying posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Casino_Review_Pro
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="entry-header">
		<?php
		if ( is_singular() ) :
			the_title( '<h1 class="entry-title">', '</h1>' );
		else :
			the_title( '<h2 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' );
		endif;

		if ( 'post' === get_post_type() ) :
			?>
			<div class="entry-meta">
				<span class="posted-on">
					<?php
					echo '<i class="fa-solid fa-calendar-days"></i> ';
					echo '<time class="entry-date published" datetime="' . esc_attr( get_the_date( 'c' ) ) . '">' . esc_html( get_the_date() ) . '</time>';
					?>
				</span>
				<span class="byline">
					<?php
					echo '<i class="fa-solid fa-user"></i> ';
					echo '<span class="author vcard"><a href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) . '">' . esc_html( get_the_author() ) . '</a></span>';
					?>
				</span>
				<?php if ( has_category() ) : ?>
					<span class="cat-links">
						<?php
						echo '<i class="fa-solid fa-folder"></i> ';
						the_category( ', ' );
						?>
					</span>
				<?php endif; ?>
			</div><!-- .entry-meta -->
		<?php endif; ?>
	</header><!-- .entry-header -->

	<?php if ( has_post_thumbnail() && ! is_singular() ) : ?>
		<div class="post-thumbnail">
			<a href="<?php the_permalink(); ?>">
				<?php the_post_thumbnail( 'large', array( 'class' => 'featured-image' ) ); ?>
			</a>
		</div>
	<?php endif; ?>

	<div class="entry-content">
		<?php
		if ( is_singular() ) :
			the_content(
				sprintf(
					wp_kses(
						/* translators: %s: Name of current post. Only visible to screen readers */
						__( 'Continue reading<span class="screen-reader-text"> "%s"</span>', 'casino-review-pro' ),
						array(
							'span' => array(
								'class' => array(),
							),
						)
					),
					wp_kses_post( get_the_title() )
				)
			);

			wp_link_pages(
				array(
					'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'casino-review-pro' ),
					'after'  => '</div>',
				)
			);
		else :
			the_excerpt();
			?>
			<a href="<?php the_permalink(); ?>" class="btn btn-primary read-more">
				<?php esc_html_e( 'Read More', 'casino-review-pro' ); ?>
			</a>
		<?php endif; ?>
	</div><!-- .entry-content -->

	<?php if ( is_singular() && has_tag() ) : ?>
		<footer class="entry-footer">
			<div class="entry-tags">
				<?php
				echo '<i class="fa-solid fa-tags"></i> ';
				the_tags( '', ', ', '' );
				?>
			</div>
		</footer><!-- .entry-footer -->
	<?php endif; ?>
</article><!-- #post-<?php the_ID(); ?> -->
