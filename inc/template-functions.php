<?php
/**
 * Functions which enhance the theme by hooking into WordPress
 *
 * @package Casino_Review_Pro
 */

/**
 * Adds custom classes to the array of body classes.
 *
 * @param array $classes Classes for the body element.
 * @return array
 */
function casino_review_body_classes( $classes ) {
	// Adds a class of hfeed to non-singular pages.
	if ( ! is_singular() ) {
		$classes[] = 'hfeed';
	}

	// Adds a class of no-sidebar when there is no sidebar present.
	if ( ! is_active_sidebar( 'sidebar-1' ) ) {
		$classes[] = 'no-sidebar';
	}

	// Add class for post types
	if ( is_singular() ) {
		$classes[] = 'single-' . get_post_type();
	}

	// Add class for dark mode
	if ( get_theme_mod( 'casino_review_dark_mode', false ) ) {
		$classes[] = 'dark-mode';
	}

	return $classes;
}
add_filter( 'body_class', 'casino_review_body_classes' );

/**
 * Add a pingback url auto-discovery header for single posts, pages, or attachments.
 */
function casino_review_pingback_header() {
	if ( is_singular() && pings_open() ) {
		printf( '<link rel="pingback" href="%s">', esc_url( get_bloginfo( 'pingback_url' ) ) );
	}
}
add_action( 'wp_head', 'casino_review_pingback_header' );

/**
 * Change excerpt length
 */
function casino_review_excerpt_length( $length ) {
	return 25;
}
add_filter( 'excerpt_length', 'casino_review_excerpt_length' );

/**
 * Change excerpt more
 */
function casino_review_excerpt_more( $more ) {
	return '...';
}
add_filter( 'excerpt_more', 'casino_review_excerpt_more' );

/**
 * Add custom image sizes to media library
 */
function casino_review_add_image_size_names( $sizes ) {
	return array_merge( $sizes, array(
		'casino-logo' => __( 'Casino Logo', 'casino-review-pro' ),
		'casino-thumbnail' => __( 'Casino Thumbnail', 'casino-review-pro' ),
		'game-thumbnail' => __( 'Game Thumbnail', 'casino-review-pro' ),
	) );
}
add_filter( 'image_size_names_choose', 'casino_review_add_image_size_names' );

/**
 * Modify archive title
 */
function casino_review_archive_title( $title ) {
	if ( is_category() ) {
		$title = single_cat_title( '', false );
	} elseif ( is_tag() ) {
		$title = single_tag_title( '', false );
	} elseif ( is_post_type_archive() ) {
		$title = post_type_archive_title( '', false );
	} elseif ( is_tax() ) {
		$title = single_term_title( '', false );
	} elseif ( is_author() ) {
		$title = get_the_author();
	}

	return $title;
}
add_filter( 'get_the_archive_title', 'casino_review_archive_title' );

/**
 * Add schema markup to casino post type
 */
function casino_review_add_casino_schema( $content ) {
	if ( is_singular( 'casino' ) ) {
		// Get casino data
		$casino_id = get_the_ID();
		$casino_name = get_the_title();
		$casino_description = get_the_excerpt();
		$casino_url = get_permalink();
		$casino_website = get_post_meta( $casino_id, '_casino_website_url', true );
		$casino_rating = get_post_meta( $casino_id, '_casino_overall_rating', true );
		$casino_established = get_post_meta( $casino_id, '_casino_established', true );
		
		// Create schema markup
		$schema = array(
			'@context' => 'https://schema.org',
			'@type' => 'Review',
			'itemReviewed' => array(
				'@type' => 'Organization',
				'name' => $casino_name,
				'description' => $casino_description,
				'url' => $casino_website ? $casino_website : $casino_url,
				'foundingDate' => $casino_established ? $casino_established : '',
			),
			'reviewRating' => array(
				'@type' => 'Rating',
				'ratingValue' => $casino_rating ? $casino_rating : '0',
				'bestRating' => '10',
				'worstRating' => '0',
			),
			'author' => array(
				'@type' => 'Person',
				'name' => get_the_author(),
			),
			'publisher' => array(
				'@type' => 'Organization',
				'name' => get_bloginfo( 'name' ),
				'url' => home_url(),
			),
		);
		
		// Add schema to content
		$content .= '<script type="application/ld+json">' . json_encode( $schema, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT ) . '</script>';
	}
	
	return $content;
}
add_filter( 'the_content', 'casino_review_add_casino_schema', 20 );

/**
 * Filter posts by custom fields in admin
 */
function casino_review_admin_posts_filter( $vars ) {
	global $typenow;
	global $wp_query;
	
	if ( $typenow == 'casino' ) {
		// Filter by rating
		if ( isset( $_GET['casino_rating'] ) && $_GET['casino_rating'] != '' ) {
			$vars['meta_key'] = '_casino_overall_rating';
			$vars['meta_value'] = $_GET['casino_rating'];
			$vars['meta_compare'] = '>=';
		}
		
		// Filter by year established
		if ( isset( $_GET['casino_established'] ) && $_GET['casino_established'] != '' ) {
			$vars['meta_query'][] = array(
				'key' => '_casino_established',
				'value' => $_GET['casino_established'],
				'compare' => '=',
			);
		}
	}
	
	return $vars;
}
add_filter( 'parse_query', 'casino_review_admin_posts_filter' );

/**
 * Add filter dropdowns to admin
 */
function casino_review_admin_filter_dropdowns() {
	global $typenow;
	
	if ( $typenow == 'casino' ) {
		// Rating filter
		$ratings = array(
			'' => __( 'Any Rating', 'casino-review-pro' ),
			'9' => __( '9+', 'casino-review-pro' ),
			'8' => __( '8+', 'casino-review-pro' ),
			'7' => __( '7+', 'casino-review-pro' ),
			'6' => __( '6+', 'casino-review-pro' ),
			'5' => __( '5+', 'casino-review-pro' ),
		);
		
		$current_rating = isset( $_GET['casino_rating'] ) ? $_GET['casino_rating'] : '';
		
		echo '<select name="casino_rating">';
		foreach ( $ratings as $value => $label ) {
			printf(
				'<option value="%s" %s>%s</option>',
				esc_attr( $value ),
				selected( $current_rating, $value, false ),
				esc_html( $label )
			);
		}
		echo '</select>';
		
		// Year established filter
		$years = range( date('Y'), 1990 );
		$years = array_combine( $years, $years );
		$years = array( '' => __( 'Any Year', 'casino-review-pro' ) ) + $years;
		
		$current_year = isset( $_GET['casino_established'] ) ? $_GET['casino_established'] : '';
		
		echo '<select name="casino_established">';
		foreach ( $years as $value => $label ) {
			printf(
				'<option value="%s" %s>%s</option>',
				esc_attr( $value ),
				selected( $current_year, $value, false ),
				esc_html( $label )
			);
		}
		echo '</select>';
	}
}
add_action( 'restrict_manage_posts', 'casino_review_admin_filter_dropdowns' );

/**
 * Display related posts
 */
function casino_review_related_posts( $post_id = null, $num_posts = 3 ) {
	if ( is_null( $post_id ) ) {
		$post_id = get_the_ID();
	}
	
	$post_type = get_post_type( $post_id );
	
	// Only show related posts for blog posts
	if ( $post_type != 'post' ) {
		return;
	}
	
	// Get current post's categories
	$categories = get_the_category( $post_id );
	
	if ( empty( $categories ) ) {
		return;
	}
	
	$category_ids = array();
	foreach ( $categories as $category ) {
		$category_ids[] = $category->term_id;
	}
	
	// Query related posts
	$args = array(
		'post_type' => 'post',
		'post__not_in' => array( $post_id ),
		'posts_per_page' => $num_posts,
		'category__in' => $category_ids,
		'orderby' => 'rand',
	);
	
	$related_posts = new WP_Query( $args );
	
	if ( $related_posts->have_posts() ) {
		echo '<div class="related-posts">';
		echo '<h3>' . esc_html__( 'Related Posts', 'casino-review-pro' ) . '</h3>';
		echo '<div class="related-posts-grid">';
		
		while ( $related_posts->have_posts() ) {
			$related_posts->the_post();
			?>
			<div class="related-post">
				<?php if ( has_post_thumbnail() ) : ?>
					<a href="<?php the_permalink(); ?>" class="related-post-thumbnail">
						<?php the_post_thumbnail( 'medium' ); ?>
					</a>
				<?php endif; ?>
				
				<h4 class="related-post-title">
					<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
				</h4>
				
				<div class="related-post-meta">
					<?php echo get_the_date(); ?>
				</div>
			</div>
			<?php
		}
		
		echo '</div>';
		echo '</div>';
		
		wp_reset_postdata();
	}
}
