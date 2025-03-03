<?php
/**
 * Custom template tags for this theme
 *
 * @package Casino_Review_Pro
 */

if ( ! function_exists( 'casino_review_posted_on' ) ) :
	/**
	 * Prints HTML with meta information for the current post-date/time.
	 */
	function casino_review_posted_on() {
		$time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';
		if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
			$time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time><time class="updated" datetime="%3$s">%4$s</time>';
		}

		$time_string = sprintf(
			$time_string,
			esc_attr( get_the_date( DATE_W3C ) ),
			esc_html( get_the_date() ),
			esc_attr( get_the_modified_date( DATE_W3C ) ),
			esc_html( get_the_modified_date() )
		);

		$posted_on = sprintf(
			/* translators: %s: post date. */
			esc_html_x( 'Posted on %s', 'post date', 'casino-review-pro' ),
			'<a href="' . esc_url( get_permalink() ) . '" rel="bookmark">' . $time_string . '</a>'
		);

		echo '<span class="posted-on">' . $posted_on . '</span>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped

	}
endif;

if ( ! function_exists( 'casino_review_posted_by' ) ) :
	/**
	 * Prints HTML with meta information for the current author.
	 */
	function casino_review_posted_by() {
		$byline = sprintf(
			/* translators: %s: post author. */
			esc_html_x( 'by %s', 'post author', 'casino-review-pro' ),
			'<span class="author vcard"><a class="url fn n" href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) . '">' . esc_html( get_the_author() ) . '</a></span>'
		);

		echo '<span class="byline"> ' . $byline . '</span>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped

	}
endif;

if ( ! function_exists( 'casino_review_entry_footer' ) ) :
	/**
	 * Prints HTML with meta information for the categories, tags and comments.
	 */
	function casino_review_entry_footer() {
		// Hide category and tag text for pages.
		if ( 'post' === get_post_type() ) {
			/* translators: used between list items, there is a space after the comma */
			$categories_list = get_the_category_list( esc_html__( ', ', 'casino-review-pro' ) );
			if ( $categories_list ) {
				/* translators: 1: list of categories. */
				printf( '<span class="cat-links">' . esc_html__( 'Posted in %1$s', 'casino-review-pro' ) . '</span>', $categories_list ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
			}

			/* translators: used between list items, there is a space after the comma */
			$tags_list = get_the_tag_list( '', esc_html_x( ', ', 'list item separator', 'casino-review-pro' ) );
			if ( $tags_list ) {
				/* translators: 1: list of tags. */
				printf( '<span class="tags-links">' . esc_html__( 'Tagged %1$s', 'casino-review-pro' ) . '</span>', $tags_list ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
			}
		}

		if ( ! is_single() && ! post_password_required() && ( comments_open() || get_comments_number() ) ) {
			echo '<span class="comments-link">';
			comments_popup_link(
				sprintf(
					wp_kses(
						/* translators: %s: post title */
						__( 'Leave a Comment<span class="screen-reader-text"> on %s</span>', 'casino-review-pro' ),
						array(
							'span' => array(
								'class' => array(),
							),
						)
					),
					wp_kses_post( get_the_title() )
				)
			);
			echo '</span>';
		}

		edit_post_link(
			sprintf(
				wp_kses(
					/* translators: %s: Name of current post. Only visible to screen readers */
					__( 'Edit <span class="screen-reader-text">%s</span>', 'casino-review-pro' ),
					array(
						'span' => array(
							'class' => array(),
						),
					)
				),
				wp_kses_post( get_the_title() )
			),
			'<span class="edit-link">',
			'</span>'
		);
	}
endif;

if ( ! function_exists( 'casino_review_post_thumbnail' ) ) :
	/**
	 * Displays an optional post thumbnail.
	 *
	 * Wraps the post thumbnail in an anchor element on index views, or a div
	 * element when on single views.
	 */
	function casino_review_post_thumbnail() {
		if ( post_password_required() || is_attachment() || ! has_post_thumbnail() ) {
			return;
		}

		if ( is_singular() ) :
			?>

			<div class="post-thumbnail">
				<?php the_post_thumbnail(); ?>
			</div><!-- .post-thumbnail -->

		<?php else : ?>

			<a class="post-thumbnail" href="<?php the_permalink(); ?>" aria-hidden="true" tabindex="-1">
				<?php
					the_post_thumbnail(
						'post-thumbnail',
						array(
							'alt' => the_title_attribute(
								array(
									'echo' => false,
								)
							),
						)
					);
				?>
			</a>

			<?php
		endif; // End is_singular().
	}
endif;

if ( ! function_exists( 'wp_body_open' ) ) :
	/**
	 * Shim for sites older than 5.2.
	 *
	 * @link https://core.trac.wordpress.org/ticket/12563
	 */
	function wp_body_open() {
		do_action( 'wp_body_open' );
	}
endif;

/**
 * Display casino rating stars
 */
function casino_review_rating_stars( $rating, $max = 5 ) {
    $html = '<div class="rating-stars">';
    
    // Convert 10-point scale to 5-star scale if needed
    if ( $max == 10 ) {
        $rating = $rating / 2;
        $max = 5;
    }
    
    // Full stars
    for ( $i = 1; $i <= floor( $rating ); $i++ ) {
        $html .= '<span class="star filled"><i class="fa-solid fa-star"></i></span>';
    }
    
    // Half star
    if ( $rating - floor( $rating ) >= 0.5 ) {
        $html .= '<span class="star filled"><i class="fa-solid fa-star-half-stroke"></i></span>';
        $i++;
    }
    
    // Empty stars
    for ( ; $i <= $max; $i++ ) {
        $html .= '<span class="star"><i class="fa-regular fa-star"></i></span>';
    }
    
    $html .= '</div>';
    
    return $html;
}

/**
 * Display breadcrumbs
 */
function casino_review_breadcrumbs() {
    $home_text = 'Home';
    $separator = '<i class="fa-solid fa-chevron-right"></i>';
    
    echo '<div class="breadcrumbs">';
    
    // Home link
    echo '<a href="' . esc_url( home_url( '/' ) ) . '">' . esc_html( $home_text ) . '</a>';
    
    if ( is_category() || is_single() ) {
        echo $separator;
        
        // If it's a single post
        if ( is_single() ) {
            // If it's a custom post type
            if ( get_post_type() != 'post' ) {
                $post_type = get_post_type_object( get_post_type() );
                echo '<a href="' . esc_url( get_post_type_archive_link( get_post_type() ) ) . '">' . esc_html( $post_type->labels->name ) . '</a>';
                echo $separator;
            } else {
                // Display category
                $categories = get_the_category();
                if ( ! empty( $categories ) ) {
                    echo '<a href="' . esc_url( get_category_link( $categories[0]->term_id ) ) . '">' . esc_html( $categories[0]->name ) . '</a>';
                    echo $separator;
                }
            }
            
            // Current post
            echo '<span class="current">' . esc_html( get_the_title() ) . '</span>';
        } else {
            // Current category
            echo '<span class="current">' . esc_html( single_cat_title( '', false ) ) . '</span>';
        }
    } elseif ( is_page() ) {
        echo $separator;
        
        // Current page
        echo '<span class="current">' . esc_html( get_the_title() ) . '</span>';
    } elseif ( is_tag() ) {
        echo $separator;
        
        // Current tag
        echo '<span class="current">' . esc_html( single_tag_title( '', false ) ) . '</span>';
    } elseif ( is_author() ) {
        echo $separator;
        
        // Current author
        echo '<span class="current">' . esc_html( get_the_author() ) . '</span>';
    } elseif ( is_year() ) {
        echo $separator;
        
        // Current year
        echo '<span class="current">' . esc_html( get_the_time( 'Y' ) ) . '</span>';
    } elseif ( is_month() ) {
        echo $separator;
        
        // Year link
        echo '<a href="' . esc_url( get_year_link( get_the_time( 'Y' ) ) ) . '">' . esc_html( get_the_time( 'Y' ) ) . '</a>';
        echo $separator;
        
        // Current month
        echo '<span class="current">' . esc_html( get_the_time( 'F' ) ) . '</span>';
    } elseif ( is_day() ) {
        echo $separator;
        
        // Year link
        echo '<a href="' . esc_url( get_year_link( get_the_time( 'Y' ) ) ) . '">' . esc_html( get_the_time( 'Y' ) ) . '</a>';
        echo $separator;
        
        // Month link
        echo '<a href="' . esc_url( get_month_link( get_the_time( 'Y' ), get_the_time( 'm' ) ) ) . '">' . esc_html( get_the_time( 'F' ) ) . '</a>';
        echo $separator;
        
        // Current day
        echo '<span class="current">' . esc_html( get_the_time( 'd' ) ) . '</span>';
    } elseif ( is_search() ) {
        echo $separator;
        
        // Search results
        echo '<span class="current">' . esc_html__( 'Search Results', 'casino-review-pro' ) . '</span>';
    } elseif ( is_404() ) {
        echo $separator;
        
        // 404 page
        echo '<span class="current">' . esc_html__( 'Page Not Found', 'casino-review-pro' ) . '</span>';
    } elseif ( is_post_type_archive() ) {
        echo $separator;
        
        // Post type archive
        echo '<span class="current">' . esc_html( post_type_archive_title( '', false ) ) . '</span>';
    } elseif ( is_tax() ) {
        echo $separator;
        
        // Get taxonomy
        $taxonomy = get_queried_object()->taxonomy;
        $taxonomy_object = get_taxonomy( $taxonomy );
        
        // Taxonomy post type
        $post_type = $taxonomy_object->object_type[0];
        $post_type_object = get_post_type_object( $post_type );
        
        // Post type archive link
        echo '<a href="' . esc_url( get_post_type_archive_link( $post_type ) ) . '">' . esc_html( $post_type_object->labels->name ) . '</a>';
        echo $separator;
        
        // Current taxonomy term
        echo '<span class="current">' . esc_html( single_term_title( '', false ) ) . '</span>';
    }
    
    echo '</div>';
}
