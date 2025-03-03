<?php
/**
 * Custom shortcodes for Casino Review Pro theme
 *
 * @package Casino_Review_Pro
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

/**
 * Add shortcode for displaying featured games
 */
function casino_review_featured_games_shortcode( $atts ) {
    $atts = shortcode_atts(
        array(
            'count' => 6,
            'provider' => '',
            'category' => '',
            'type' => '',
            'title' => __( 'Featured Games', 'casino-review-pro' ),
            'layout' => 'grid', // grid, carousel
            'columns' => 3,
        ),
        $atts,
        'featured_games'
    );

    // Build query args
    $args = array(
        'post_type' => 'game',
        'posts_per_page' => intval( $atts['count'] ),
        'orderby' => 'meta_value_num',
        'meta_key' => '_game_rating',
        'order' => 'DESC',
    );

    // Add provider taxonomy if specified
    if ( ! empty( $atts['provider'] ) ) {
        $args['tax_query'][] = array(
            'taxonomy' => 'game_provider',
            'field' => 'slug',
            'terms' => explode( ',', $atts['provider'] ),
        );
    }

    // Add category taxonomy if specified
    if ( ! empty( $atts['category'] ) ) {
        $args['tax_query'][] = array(
            'taxonomy' => 'game_category',
            'field' => 'slug',
            'terms' => explode( ',', $atts['category'] ),
        );
    }

    // Add game type meta query if specified
    if ( ! empty( $atts['type'] ) ) {
        $args['meta_query'][] = array(
            'key' => '_game_type',
            'value' => $atts['type'],
            'compare' => 'LIKE',
        );
    }

    // Get games
    $games_query = new WP_Query( $args );

    if ( ! $games_query->have_posts() ) {
        return '<p>' . __( 'No games found.', 'casino-review-pro' ) . '</p>';
    }

    // Start building output
    $output = '<div class="featured-games-wrapper">';
    
    if ( ! empty( $atts['title'] ) ) {
        $output .= '<h2 class="featured-games-title">' . esc_html( $atts['title'] ) . '</h2>';
    }
    
    // Carousel layout
    if ( $atts['layout'] === 'carousel' ) {
        $output .= '<div class="games-carousel">';
        $output .= '<div class="carousel-controls">';
        $output .= '<button class="carousel-prev"><i class="fa-solid fa-chevron-left"></i></button>';
        $output .= '<button class="carousel-next"><i class="fa-solid fa-chevron-right"></i></button>';
        $output .= '</div>';
        
        $output .= '<div class="carousel-container">';
        $output .= '<div class="carousel-items">';
        
        while ( $games_query->have_posts() ) {
            $games_query->the_post();
            $game_id = get_the_ID();
            
            // Get game meta data
            $game_provider = get_post_meta( $game_id, '_game_provider', true );
            $game_rtp = get_post_meta( $game_id, '_game_rtp', true );
            $game_rating = get_post_meta( $game_id, '_game_rating', true );
            $game_play_url = get_post_meta( $game_id, '_game_play_url', true );
            
            $output .= '<div class="carousel-item game-item">';
            $output .= '<div class="game-card">';
            
            if ( has_post_thumbnail() ) {
                $output .= '<a href="' . get_permalink() . '" class="game-card-image">';
                $output .= get_the_post_thumbnail( $game_id, 'medium', array( 'class' => 'game-thumbnail' ) );
                $output .= '</a>';
            }
            
            $output .= '<div class="game-card-content">';
            $output .= '<h3 class="game-card-title"><a href="' . get_permalink() . '">' . get_the_title() . '</a></h3>';
            
            if ( $game_provider ) {
                $output .= '<div class="game-card-provider">' . esc_html( $game_provider ) . '</div>';
            }
            
            $output .= '<div class="game-card-meta">';
            
            if ( $game_rating ) {
                $output .= '<div class="game-card-rating">';
                $output .= casino_review_rating_stars( $game_rating, 10 );
                $output .= '</div>';
            }
            
            if ( $game_rtp ) {
                $output .= '<div class="game-card-rtp">RTP: ' . esc_html( $game_rtp ) . '%</div>';
            }
            
            $output .= '</div>'; // .game-card-meta
            
            $output .= '<div class="game-card-actions">';
            $output .= '<a href="' . get_permalink() . '" class="btn btn-sm btn-outline">' . __( 'Read More', 'casino-review-pro' ) . '</a>';
            
            if ( $game_play_url ) {
                $output .= '<a href="' . esc_url( $game_play_url ) . '" class="btn btn-sm btn-primary" target="_blank">' . __( 'Play Now', 'casino-review-pro' ) . '</a>';
            }
            
            $output .= '</div>'; // .game-card-actions
            
            $output .= '</div>'; // .game-card-content
            $output .= '</div>'; // .game-card
            $output .= '</div>'; // .carousel-item
        }
        
        $output .= '</div>'; // .carousel-items
        $output .= '</div>'; // .carousel-container
        $output .= '</div>'; // .games-carousel
    }
    // Grid layout (default)
    else {
        $output .= '<div class="games-grid columns-' . intval( $atts['columns'] ) . '">';
        
        while ( $games_query->have_posts() ) {
            $games_query->the_post();
            $game_id = get_the_ID();
            
            // Get game meta data
            $game_provider = get_post_meta( $game_id, '_game_provider', true );
            $game_rtp = get_post_meta( $game_id, '_game_rtp', true );
            $game_rating = get_post_meta( $game_id, '_game_rating', true );
            $game_play_url = get_post_meta( $game_id, '_game_play_url', true );
            
            $output .= '<div class="game-card">';
            
            if ( has_post_thumbnail() ) {
                $output .= '<a href="' . get_permalink() . '" class="game-card-image">';
                $output .= get_the_post_thumbnail( $game_id, 'medium', array( 'class' => 'game-thumbnail' ) );
                $output .= '</a>';
            }
            
            $output .= '<div class="game-card-content">';
            $output .= '<h3 class="game-card-title"><a href="' . get_permalink() . '">' . get_the_title() . '</a></h3>';
            
            if ( $game_provider ) {
                $output .= '<div class="game-card-provider">' . esc_html( $game_provider ) . '</div>';
            }
            
            $output .= '<div class="game-card-meta">';
            
            if ( $game_rating ) {
                $output .= '<div class="game-card-rating">';
                $output .= casino_review_rating_stars( $game_rating, 10 );
                $output .= '</div>';
            }
            
            if ( $game_rtp ) {
                $output .= '<div class="game-card-rtp">RTP: ' . esc_html( $game_rtp ) . '%</div>';
            }
            
            $output .= '</div>'; // .game-card-meta
            
            $output .= '<div class="game-card-actions">';
            $output .= '<a href="' . get_permalink() . '" class="btn btn-sm btn-outline">' . __( 'Read More', 'casino-review-pro' ) . '</a>';
            
            if ( $game_play_url ) {
                $output .= '<a href="' . esc_url( $game_play_url ) . '" class="btn btn-sm btn-primary" target="_blank">' . __( 'Play Now', 'casino-review-pro' ) . '</a>';
            }
            
            $output .= '</div>'; // .game-card-actions
            
            $output .= '</div>'; // .game-card-content
            $output .= '</div>'; // .game-card
        }
        
        $output .= '</div>'; // .games-grid
    }
    
    $output .= '</div>'; // .featured-games-wrapper
    
    wp_reset_postdata();
    
    return $output;
}
add_shortcode( 'featured_games', 'casino_review_featured_games_shortcode' );

/**
 * Add shortcode for displaying payment methods
 */
function casino_review_payment_methods_shortcode( $atts ) {
    $atts = shortcode_atts(
        array(
            'count' => 12,
            'type' => '',
            'title' => __( 'Payment Methods', 'casino-review-pro' ),
            'columns' => 4,
        ),
        $atts,
        'payment_methods'
    );

    // Build query args
    $args = array(
        'post_type' => 'payment_method',
        'posts_per_page' => intval( $atts['count'] ),
        'orderby' => 'title',
        'order' => 'ASC',
    );

    // Add payment type taxonomy if specified
    if ( ! empty( $atts['type'] ) ) {
        $args['tax_query'] = array(
            array(
                'taxonomy' => 'payment_type',
                'field' => 'slug',
                'terms' => explode( ',', $atts['type'] ),
            ),
        );
    }

    // Get payment methods
    $methods_query = new WP_Query( $args );

    if ( ! $methods_query->have_posts() ) {
        return '<p>' . __( 'No payment methods found.', 'casino-review-pro' ) . '</p>';
    }

    // Start building output
    $output = '<div class="payment-methods-wrapper">';
    
    if ( ! empty( $atts['title'] ) ) {
        $output .= '<h2 class="payment-methods-title">' . esc_html( $atts['title'] ) . '</h2>';
    }
    
    $output .= '<div class="payment-methods-grid columns-' . intval( $atts['columns'] ) . '">';
    
    while ( $methods_query->have_posts() ) {
        $methods_query->the_post();
        
        $output .= '<div class="payment-method-item">';
        $output .= '<a href="' . get_permalink() . '" class="payment-method-link">';
        
        if ( has_post_thumbnail() ) {
            $output .= get_the_post_thumbnail( null, 'medium', array( 'class' => 'payment-method-logo' ) );
        }
        
        $output .= '<h3 class="payment-method-name">' . get_the_title() . '</h3>';
        $output .= '</a>';
        $output .= '</div>';
    }
    
    $output .= '</div>'; // .payment-methods-grid
    $output .= '</div>'; // .payment-methods-wrapper
    
    wp_reset_postdata();
    
    return $output;
}
add_shortcode( 'payment_methods', 'casino_review_payment_methods_shortcode' );

/**
 * Add shortcode for displaying latest bonuses
 */
function casino_review_latest_bonuses_shortcode( $atts ) {
    $atts = shortcode_atts(
        array(
            'count' => 4,
            'type' => '',
            'exclusive' => 'false',
            'title' => __( 'Latest Bonus Offers', 'casino-review-pro' ),
            'layout' => 'grid', // grid, list
            'columns' => 2,
        ),
        $atts,
        'latest_bonuses'
    );

    // Build query args
    $args = array(
        'post_type' => 'bonus',
        'posts_per_page' => intval( $atts['count'] ),
        'orderby' => 'date',
        'order' => 'DESC',
    );

    // Add bonus type taxonomy if specified
    if ( ! empty( $atts['type'] ) ) {
        $args['tax_query'] = array(
            array(
                'taxonomy' => 'bonus_type',
                'field' => 'slug',
                'terms' => explode( ',', $atts['type'] ),
            ),
        );
    }

    // Exclusive bonuses only
    if ( $atts['exclusive'] === 'true' ) {
        $args['meta_query'] = array(
            array(
                'key' => '_bonus_exclusive',
                'value' => '1',
                'compare' => '=',
            ),
        );
    }

    // Get bonuses
    $bonuses_query = new WP_Query( $args );

    if ( ! $bonuses_query->have_posts() ) {
        return '<p>' . __( 'No bonus offers found.', 'casino-review-pro' ) . '</p>';
    }

    // Start building output
    $output = '<div class="latest-bonuses-wrapper">';
    
    if ( ! empty( $atts['title'] ) ) {
        $output .= '<h2 class="latest-bonuses-title">' . esc_html( $atts['title'] ) . '</h2>';
    }
    
    // List layout
    if ( $atts['layout'] === 'list' ) {
        $output .= '<div class="bonuses-list">';
        
        while ( $bonuses_query->have_posts() ) {
            $bonuses_query->the_post();
            $bonus_id = get_the_ID();
            
            // Get bonus meta data
            $bonus_value = get_post_meta( $bonus_id, '_bonus_value', true );
            $bonus_code = get_post_meta( $bonus_id, '_bonus_code', true );
            $bonus_casino = get_post_meta( $bonus_id, '_bonus_casino', true );
            $bonus_exclusive = get_post_meta( $bonus_id, '_bonus_exclusive', true );
            
            // Get casino data
            $casino_name = '';
            $casino_url = '';
            
            if ( $bonus_casino ) {
                $casino_name = get_the_title( $bonus_casino );
                $casino_url = get_post_meta( $bonus_casino, '_casino_website_url', true );
            }
            
            $output .= '<div class="bonus-list-item">';
            
            if ( $bonus_exclusive ) {
                $output .= '<div class="bonus-exclusive-tag">' . __( 'Exclusive', 'casino-review-pro' ) . '</div>';
            }
            
            $output .= '<div class="bonus-list-content">';
            $output .= '<h3 class="bonus-title"><a href="' . get_permalink() . '">' . get_the_title() . '</a></h3>';
            
            if ( $casino_name ) {
                $output .= '<div class="bonus-casino">' . __( 'From: ', 'casino-review-pro' ) . '<a href="' . get_permalink( $bonus_casino ) . '">' . esc_html( $casino_name ) . '</a></div>';
            }
            
            if ( $bonus_value ) {
                $output .= '<div class="bonus-value">' . esc_html( $bonus_value ) . '</div>';
            }
            
            $output .= '<div class="bonus-excerpt">' . get_the_excerpt() . '</div>';
            
            if ( $bonus_code ) {
                $output .= '<div class="bonus-code-box">';
                $output .= '<span class="bonus-code-label">' . __( 'Bonus Code:', 'casino-review-pro' ) . '</span>';
                $output .= '<span class="bonus-code">' . esc_html( $bonus_code ) . '</span>';
                $output .= '</div>';
            }
            
            $output .= '<div class="bonus-actions">';
            $output .= '<a href="' . get_permalink() . '" class="btn btn-outline">' . __( 'View Details', 'casino-review-pro' ) . '</a>';
            
            if ( $casino_url ) {
                $output .= '<a href="' . esc_url( $casino_url ) . '" class="btn btn-primary" target="_blank">' . __( 'Claim Bonus', 'casino-review-pro' ) . '</a>';
            }
            
            $output .= '</div>'; // .bonus-actions
            
            $output .= '</div>'; // .bonus-list-content
            $output .= '</div>'; // .bonus-list-item
        }
        
        $output .= '</div>'; // .bonuses-list
    }
    // Grid layout (default)
    else {
        $output .= '<div class="bonuses-grid columns-' . intval( $atts['columns'] ) . '">';
        
        while ( $bonuses_query->have_posts() ) {
            $bonuses_query->the_post();
            $bonus_id = get_the_ID();
            
            // Get bonus meta data
            $bonus_value = get_post_meta( $bonus_id, '_bonus_value', true );
            $bonus_code = get_post_meta( $bonus_id, '_bonus_code', true );
            $bonus_casino = get_post_meta( $bonus_id, '_bonus_casino', true );
            $bonus_exclusive = get_post_meta( $bonus_id, '_bonus_exclusive', true );
            
            // Get casino data
            $casino_name = '';
            $casino_url = '';
            
            if ( $bonus_casino ) {
                $casino_name = get_the_title( $bonus_casino );
                $casino_url = get_post_meta( $bonus_casino, '_casino_website_url', true );
            }
            
            $output .= '<div class="bonus-card">';
            
            if ( $bonus_exclusive ) {
                $output .= '<div class="bonus-exclusive-tag">' . __( 'Exclusive', 'casino-review-pro' ) . '</div>';
            }
            
            $output .= '<div class="bonus-card-header">';
            $output .= '<h3 class="bonus-title"><a href="' . get_permalink() . '">' . get_the_title() . '</a></h3>';
            
            if ( $bonus_value ) {
                $output .= '<div class="bonus-value">' . esc_html( $bonus_value ) . '</div>';
            }
            
            $output .= '</div>'; // .bonus-card-header
            
            if ( $casino_name ) {
                $output .= '<div class="bonus-casino">' . __( 'From: ', 'casino-review-pro' ) . '<a href="' . get_permalink( $bonus_casino ) . '">' . esc_html( $casino_name ) . '</a></div>';
            }
            
            $output .= '<div class="bonus-description">' . get_the_excerpt() . '</div>';
            
            if ( $bonus_code ) {
                $output .= '<div class="bonus-code-box">';
                $output .= '<span class="bonus-code-label">' . __( 'Bonus Code:', 'casino-review-pro' ) . '</span>';
                $output .= '<span class="bonus-code">' . esc_html( $bonus_code ) . '</span>';
                $output .= '</div>';
            }
            
            $output .= '<div class="bonus-actions">';
            $output .= '<a href="' . get_permalink() . '" class="btn btn-outline">' . __( 'View Details', 'casino-review-pro' ) . '</a>';
            
            if ( $casino_url ) {
                $output .= '<a href="' . esc_url( $casino_url ) . '" class="btn btn-primary" target="_blank">' . __( 'Claim Bonus', 'casino-review-pro' ) . '</a>';
            }
            
            $output .= '</div>'; // .bonus-actions
            
            $output .= '</div>'; // .bonus-card
        }
        
        $output .= '</div>'; // .bonuses-grid
    }
    
    $output .= '</div>'; // .latest-bonuses-wrapper
    
    wp_reset_postdata();
    
    return $output;
}
add_shortcode( 'latest_bonuses', 'casino_review_latest_bonuses_shortcode' );
