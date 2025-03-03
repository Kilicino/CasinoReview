<?php
/**
 * Template Name: Casino Comparison
 *
 * A template for comparing multiple casinos side by side
 *
 * @package Casino_Review_Pro
 */

get_header();

// Get selected casino IDs from query parameters
$casino_ids = isset( $_GET['casinos'] ) ? explode( ',', sanitize_text_field( $_GET['casinos'] ) ) : array();

// Make sure we have valid IDs
$valid_casino_ids = array();
foreach ( $casino_ids as $id ) {
    $id = absint( $id );
    if ( $id > 0 && get_post_type( $id ) === 'casino' ) {
        $valid_casino_ids[] = $id;
    }
}

// Prepare comparison data for each casino
$comparison_data = array();
if ( ! empty( $valid_casino_ids ) ) {
    foreach ( $valid_casino_ids as $casino_id ) {
        $casino = get_post( $casino_id );
        
        if ( $casino && $casino->post_status === 'publish' ) {
            // Get casino meta data
            $rating = get_post_meta( $casino_id, '_casino_overall_rating', true );
            $games_rating = get_post_meta( $casino_id, '_casino_games_rating', true );
            $bonuses_rating = get_post_meta( $casino_id, '_casino_bonuses_rating', true );
            $support_rating = get_post_meta( $casino_id, '_casino_support_rating', true );
            $payments_rating = get_post_meta( $casino_id, '_casino_payments_rating', true );
            $mobile_rating = get_post_meta( $casino_id, '_casino_mobile_rating', true );
            
            $website_url = get_post_meta( $casino_id, '_casino_website_url', true );
            $established = get_post_meta( $casino_id, '_casino_established', true );
            $license = get_post_meta( $casino_id, '_casino_license', true );
            $owner = get_post_meta( $casino_id, '_casino_owner', true );
            $software = get_post_meta( $casino_id, '_casino_software', true );
            $languages = get_post_meta( $casino_id, '_casino_languages', true );
            $currencies = get_post_meta( $casino_id, '_casino_currencies', true );
            $min_deposit = get_post_meta( $casino_id, '_casino_min_deposit', true );
            $min_withdrawal = get_post_meta( $casino_id, '_casino_min_withdrawal', true );
            $withdrawal_time = get_post_meta( $casino_id, '_casino_withdrawal_time', true );
            
            // Get pros and cons
            $pros = get_post_meta( $casino_id, '_casino_pros', true );
            $cons = get_post_meta( $casino_id, '_casino_cons', true );
            
            $pros_array = ! empty( $pros ) ? explode( "\n", $pros ) : array();
            $cons_array = ! empty( $cons ) ? explode( "\n", $cons ) : array();
            
            // Get bonuses
            $bonuses = get_posts( array(
                'post_type' => 'bonus',
                'posts_per_page' => 3,
                'meta_query' => array(
                    array(
                        'key' => '_bonus_casino',
                        'value' => $casino_id,
                        'compare' => '=',
                    ),
                ),
            ) );
            
            // Build comparison data array
            $comparison_data[ $casino_id ] = array(
                'id' => $casino_id,
                'title' => $casino->post_title,
                'permalink' => get_permalink( $casino_id ),
                'thumbnail' => has_post_thumbnail( $casino_id ) ? get_the_post_thumbnail_url( $casino_id, 'casino-logo' ) : '',
                'rating' => $rating,
                'games_rating' => $games_rating,
                'bonuses_rating' => $bonuses_rating,
                'support_rating' => $support_rating,
                'payments_rating' => $payments_rating,
                'mobile_rating' => $mobile_rating,
                'website_url' => $website_url,
                'established' => $established,
                'license' => $license,
                'owner' => $owner,
                'software' => $software,
                'languages' => $languages,
                'currencies' => $currencies,
                'min_deposit' => $min_deposit,
                'min_withdrawal' => $min_withdrawal,
                'withdrawal_time' => $withdrawal_time,
                'pros' => $pros_array,
                'cons' => $cons_array,
                'bonuses' => $bonuses,
            );
        }
    }
}

// Get all casinos for selection
$all_casinos = get_posts( array(
    'post_type' => 'casino',
    'posts_per_page' => 100,
    'orderby' => 'title',
    'order' => 'ASC',
) );

?>

<main id="primary" class="site-main">
    <div class="container">
        <div class="casino-compare-header">
            <h1 class="page-title"><?php the_title(); ?></h1>
            <?php the_content(); ?>
        </div>
        
        <div class="compare-selection-form-wrapper">
            <form class="compare-selection-form" method="get" action="<?php echo esc_url( get_permalink() ); ?>">
                <div class="form-group">
                    <label for="compare-casinos"><?php esc_html_e( 'Select Casinos to Compare:', 'casino-review-pro' ); ?></label>
                    <div class="casino-select-wrapper">
                        <select id="compare-casinos" name="casinos_select[]" class="casino-select" multiple="multiple">
                            <?php foreach ( $all_casinos as $casino ) : ?>
                                <option value="<?php echo esc_attr( $casino->ID ); ?>" <?php selected( in_array( $casino->ID, $valid_casino_ids ) ); ?>><?php echo esc_html( $casino->post_title ); ?></option>
                            <?php endforeach; ?>
                        </select>
                        <input type="hidden" name="casinos" id="casinos-hidden" value="<?php echo esc_attr( implode( ',', $valid_casino_ids ) ); ?>">
                    </div>
                </div>
                
                <div class="form-actions">
                    <button type="submit" class="btn btn-primary"><?php esc_html_e( 'Compare Casinos', 'casino-review-pro' ); ?></button>
                    <a href="<?php echo esc_url( get_permalink() ); ?>" class="btn btn-outline"><?php esc_html_e( 'Reset', 'casino-review-pro' ); ?></a>
                </div>
            </form>
        </div>
        
        <?php if ( empty( $valid_casino_ids ) ) : ?>
            <div class="compare-empty-state">
                <div class="empty-state-icon">
                    <i class="fa-solid fa-scale-balanced"></i>
                </div>
                <h2><?php esc_html_e( 'Select Casinos to Compare', 'casino-review-pro' ); ?></h2>
                <p><?php esc_html_e( 'Please select at least two casinos from the dropdown above to start the comparison.', 'casino-review-pro' ); ?></p>
                <div class="top-casinos-suggestion">
                    <h3><?php esc_html_e( 'Our Top Rated Casinos', 'casino-review-pro' ); ?></h3>
                    
                    <?php
                    $top_casinos = get_posts( array(
                        'post_type' => 'casino',
                        'posts_per_page' => 3,
                        'meta_key' => '_casino_overall_rating',
                        'orderby' => 'meta_value_num',
                        'order' => 'DESC',
                    ) );
                    
                    if ( ! empty( $top_casinos ) ) :
                    ?>
                        <div class="top-casinos-grid">
                            <?php foreach ( $top_casinos as $casino ) : ?>
                                <?php
                                $rating = get_post_meta( $casino->ID, '_casino_overall_rating', true );
                                $website_url = get_post_meta( $casino->ID, '_casino_website_url', true );
                                $add_to_compare_url = add_query_arg( 'casinos', $casino->ID, get_permalink() );
                                ?>
                                <div class="top-casino-card">
                                    <?php if ( has_post_thumbnail( $casino->ID ) ) : ?>
                                        <div class="casino-logo-wrapper">
                                            <a href="<?php echo esc_url( get_permalink( $casino->ID ) ); ?>">
                                                <?php echo get_the_post_thumbnail( $casino->ID, 'casino-logo', array( 'class' => 'casino-logo' ) ); ?>
                                            </a>
                                        </div>
                                    <?php endif; ?>
                                    
                                    <h3 class="casino-title"><a href="<?php echo esc_url( get_permalink( $casino->ID ) ); ?>"><?php echo esc_html( $casino->post_title ); ?></a></h3>
                                    
                                    <?php if ( $rating ) : ?>
                                        <div class="casino-rating">
                                            <?php echo casino_review_rating_stars( $rating, 10 ); ?>
                                            <span class="rating-text"><?php echo esc_html( $rating ); ?>/10</span>
                                        </div>
                                    <?php endif; ?>
                                    
                                    <div class="casino-actions">
                                        <a href="<?php echo esc_url( $add_to_compare_url ); ?>" class="btn btn-sm btn-outline"><?php esc_html_e( 'Add to Compare', 'casino-review-pro' ); ?></a>
                                        
                                        <?php if ( $website_url ) : ?>
                                            <a href="<?php echo esc_url( $website_url ); ?>" class="btn btn-sm btn-primary" target="_blank"><?php esc_html_e( 'Visit Casino', 'casino-review-pro' ); ?></a>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        <?php elseif ( count( $valid_casino_ids ) === 1 ) : ?>
            <div class="compare-not-enough">
                <div class="notice-icon">
                    <i class="fa-solid fa-circle-info"></i>
                </div>
                <p><?php esc_html_e( 'Please select at least one more casino to compare. Casino comparison requires at least two casinos.', 'casino-review-pro' ); ?></p>
                
                <?php
                // Get similar casinos
                $current_casino = reset( $comparison_data );
                $similar_casinos = get_posts( array(
                    'post_type' => 'casino',
                    'posts_per_page' => 3,
                    'post__not_in' => $valid_casino_ids,
                    'orderby' => 'rand',
                ) );
                
                if ( ! empty( $similar_casinos ) ) :
                ?>
                    <div class="similar-casinos-suggestion">
                        <h3><?php esc_html_e( 'Suggestions to Compare With', 'casino-review-pro' ); ?></h3>
                        
                        <div class="similar-casinos-grid">
                            <?php foreach ( $similar_casinos as $casino ) : ?>
                                <?php
                                $rating = get_post_meta( $casino->ID, '_casino_overall_rating', true );
                                $website_url = get_post_meta( $casino->ID, '_casino_website_url', true );
                                $add_to_compare_url = add_query_arg( 'casinos', implode( ',', array_merge( $valid_casino_ids, array( $casino->ID ) ) ), get_permalink() );
                                ?>
                                <div class="similar-casino-card">
                                    <?php if ( has_post_thumbnail( $casino->ID ) ) : ?>
                                        <div class="casino-logo-wrapper">
                                            <a href="<?php echo esc_url( get_permalink( $casino->ID ) ); ?>">
                                                <?php echo get_the_post_thumbnail( $casino->ID, 'casino-thumbnail', array( 'class' => 'casino-logo' ) ); ?>
                                            </a>
                                        </div>
                                    <?php endif; ?>
                                    
                                    <div class="casino-info">
                                        <h4 class="casino-title"><a href="<?php echo esc_url( get_permalink( $casino->ID ) ); ?>"><?php echo esc_html( $casino->post_title ); ?></a></h4>
                                        
                                        <?php if ( $rating ) : ?>
                                            <div class="casino-rating-small">
                                                <?php echo casino_review_rating_stars( $rating, 10 ); ?>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                    
                                    <div class="casino-action">
                                        <a href="<?php echo esc_url( $add_to_compare_url ); ?>" class="btn btn-sm btn-primary"><?php esc_html_e( 'Add to Compare', 'casino-review-pro' ); ?></a>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        <?php else : ?>
            <!-- Comparison Tables -->
            <div class="comparison-container">
                <div class="comparison-controls">
                    <div class="comparison-tabs">
                        <button class="tab-button active" data-tab="overview"><?php esc_html_e( 'Overview', 'casino-review-pro' ); ?></button>
                        <button class="tab-button" data-tab="ratings"><?php esc_html_e( 'Ratings', 'casino-review-pro' ); ?></button>
                        <button class="tab-button" data-tab="banking"><?php esc_html_e( 'Banking', 'casino-review-pro' ); ?></button>
                        <button class="tab-button" data-tab="bonuses"><?php esc_html_e( 'Bonuses', 'casino-review-pro' ); ?></button>
                        <button class="tab-button" data-tab="features"><?php esc_html_e( 'Features', 'casino-review-pro' ); ?></button>
                    </div>
                </div>
                
                <!-- Overview Tab -->
                <div class="comparison-tab-content active" id="overview-tab">
                    <table class="comparison-table overview-table">
                        <thead>
                            <tr>
                                <th class="feature-col"><?php esc_html_e( 'Casino', 'casino-review-pro' ); ?></th>
                                <?php foreach ( $comparison_data as $casino ) : ?>
                                    <th class="casino-col">
                                        <?php if ( $casino['thumbnail'] ) : ?>
                                            <div class="casino-logo-wrapper">
                                                <a href="<?php echo esc_url( $casino['permalink'] ); ?>">
                                                    <img src="<?php echo esc_url( $casino['thumbnail'] ); ?>" alt="<?php echo esc_attr( $casino['title'] ); ?>" class="casino-logo">
                                                </a>
                                            </div>
                                        <?php endif; ?>
                                        <h3 class="casino-title"><a href="<?php echo esc_url( $casino['permalink'] ); ?>"><?php echo esc_html( $casino['title'] ); ?></a></h3>
                                    </th>
                                <?php endforeach; ?>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="feature-name"><?php esc_html_e( 'Overall Rating', 'casino-review-pro' ); ?></td>
                                <?php foreach ( $comparison_data as $casino ) : ?>
                                    <td class="feature-value">
                                        <?php if ( $casino['rating'] ) : ?>
                                            <div class="rating-score"><?php echo esc_html( $casino['rating'] ); ?></div>
                                            <div class="rating-stars">
                                                <?php echo casino_review_rating_stars( $casino['rating'], 10 ); ?>
                                            </div>
                                        <?php else : ?>
                                            <span class="not-available">—</span>
                                        <?php endif; ?>
                                    </td>
                                <?php endforeach; ?>
                            </tr>
                            <tr>
                                <td class="feature-name"><?php esc_html_e( 'Established', 'casino-review-pro' ); ?></td>
                                <?php foreach ( $comparison_data as $casino ) : ?>
                                    <td class="feature-value">
                                        <?php if ( ! empty( $casino['established'] ) ) : ?>
                                            <?php echo esc_html( $casino['established'] ); ?>
                                        <?php else : ?>
                                            <span class="not-available">—</span>
                                        <?php endif; ?>
                                    </td>
                                <?php endforeach; ?>
                            </tr>
                            <tr>
                                <td class="feature-name"><?php esc_html_e( 'License', 'casino-review-pro' ); ?></td>
                                <?php foreach ( $comparison_data as $casino ) : ?>
                                    <td class="feature-value">
                                        <?php if ( ! empty( $casino['license'] ) ) : ?>
                                            <?php echo esc_html( $casino['license'] ); ?>
                                        <?php else : ?>
                                            <span class="not-available">—</span>
                                        <?php endif; ?>
                                    </td>
                                <?php endforeach; ?>
                            </tr>
                            <tr>
                                <td class="feature-name"><?php esc_html_e( 'Owner', 'casino-review-pro' ); ?></td>
                                <?php foreach ( $comparison_data as $casino ) : ?>
                                    <td class="feature-value">
                                        <?php if ( ! empty( $casino['owner'] ) ) : ?>
                                            <?php echo esc_html( $casino['owner'] ); ?>
                                        <?php else : ?>
                                            <span class="not-available">—</span>
                                        <?php endif; ?>
                                    </td>
                                <?php endforeach; ?>
                            </tr>
                            <tr>
                                <td class="feature-name"><?php esc_html_e( 'Software', 'casino-review-pro' ); ?></td>
                                <?php foreach ( $comparison_data as $casino ) : ?>
                                    <td class="feature-value">
                                        <?php if ( ! empty( $casino['software'] ) ) : ?>
                                            <?php echo esc_html( $casino['software'] ); ?>
                                        <?php else : ?>
                                            <span class="not-available">—</span>
                                        <?php endif; ?>
                                    </td>
                                <?php endforeach; ?>
                            </tr>
                            <tr>
                                <td class="feature-name"><?php esc_html_e( 'Languages', 'casino-review-pro' ); ?></td>
                                <?php foreach ( $comparison_data as $casino ) : ?>
                                    <td class="feature-value">
                                        <?php if ( ! empty( $casino['languages'] ) ) : ?>
                                            <?php echo esc_html( $casino['languages'] ); ?>
                                        <?php else : ?>
                                            <span class="not-available">—</span>
                                        <?php endif; ?>
                                    </td>
                                <?php endforeach; ?>
                            </tr>
                            <tr>
                                <td class="feature-name"><?php esc_html_e( 'Action', 'casino-review-pro' ); ?></td>
                                <?php foreach ( $comparison_data as $casino ) : ?>
                                    <td class="feature-value action-buttons">
                                        <a href="<?php echo esc_url( $casino['permalink'] ); ?>" class="btn btn-sm btn-outline"><?php esc_html_e( 'Read Review', 'casino-review-pro' ); ?></a>
                                        
                                        <?php if ( ! empty( $casino['website_url'] ) ) : ?>
                                            <a href="<?php echo esc_url( $casino['website_url'] ); ?>" class="btn btn-sm btn-primary" target="_blank"><?php esc_html_e( 'Visit Casino', 'casino-review-pro' ); ?></a>
                                        <?php endif; ?>
                                    </td>
                                <?php endforeach; ?>
                            </tr>
                        </tbody>
                    </table>
                </div>
                
                <!-- Ratings Tab -->
                <div class="comparison-tab-content" id="ratings-tab">
                    <table class="comparison-table ratings-table">
                        <thead>
                            <tr>
                                <th class="feature-col"><?php esc_html_e( 'Rating Category', 'casino-review-pro' ); ?></th>
                                <?php foreach ( $comparison_data as $casino ) : ?>
                                    <th class="casino-col">
                                        <h3 class="casino-title"><?php echo esc_html( $casino['title'] ); ?></h3>
                                    </th>
                                <?php endforeach; ?>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="feature-name"><?php esc_html_e( 'Overall Rating', 'casino-review-pro' ); ?></td>
                                <?php foreach ( $comparison_data as $casino ) : ?>
                                    <td class="feature-value">
                                        <?php if ( ! empty( $casino['rating'] ) ) : ?>
                                            <div class="rating-meter">
                                                <div class="rating-progress" style="width: <?php echo esc_attr( $casino['rating'] * 10 ); ?>%"></div>
                                                <span class="rating-value"><?php echo esc_html( $casino['rating'] ); ?>/10</span>
                                            </div>
                                        <?php else : ?>
                                            <span class="not-available">—</span>
                                        <?php endif; ?>
                                    </td>
                                <?php endforeach; ?>
                            </tr>
                            <tr>
                                <td class="feature-name"><?php esc_html_e( 'Games Selection', 'casino-review-pro' ); ?></td>
                                <?php foreach ( $comparison_data as $casino ) : ?>
                                    <td class="feature-value">
                                        <?php if ( ! empty( $casino['games_rating'] ) ) : ?>
                                            <div class="rating-meter">
                                                <div class="rating-progress" style="width: <?php echo esc_attr( $casino['games_rating'] * 10 ); ?>%"></div>
                                                <span class="rating-value"><?php echo esc_html( $casino['games_rating'] ); ?>/10</span>
                                            </div>
                                        <?php else : ?>
                                            <span class="not-available">—</span>
                                        <?php endif; ?>
                                    </td>
                                <?php endforeach; ?>
                            </tr>
                            <tr>
                                <td class="feature-name"><?php esc_html_e( 'Bonuses & Promotions', 'casino-review-pro' ); ?></td>
                                <?php foreach ( $comparison_data as $casino ) : ?>
                                    <td class="feature-value">
                                        <?php if ( ! empty( $casino['bonuses_rating'] ) ) : ?>
                                            <div class="rating-meter">
                                                <div class="rating-progress" style="width: <?php echo esc_attr( $casino['bonuses_rating'] * 10 ); ?>%"></div>
                                                <span class="rating-value"><?php echo esc_html( $casino['bonuses_rating'] ); ?>/10</span>
                                            </div>
                                        <?php else : ?>
                                            <span class="not-available">—</span>
                                        <?php endif; ?>
                                    </td>
                                <?php endforeach; ?>
                            </tr>
                            <tr>
                                <td class="feature-name"><?php esc_html_e( 'Customer Support', 'casino-review-pro' ); ?></td>
                                <?php foreach ( $comparison_data as $casino ) : ?>
                                    <td class="feature-value">
                                        <?php if ( ! empty( $casino['support_rating'] ) ) : ?>
                                            <div class="rating-meter">
                                                <div class="rating-progress" style="width: <?php echo esc_attr( $casino['support_rating'] * 10 ); ?>%"></div>
                                                <span class="rating-value"><?php echo esc_html( $casino['support_rating'] ); ?>/10</span>
                                            </div>
                                        <?php else : ?>
                                            <span class="not-available">—</span>
                                        <?php endif; ?>
                                    </td>
                                <?php endforeach; ?>
                            </tr>
                            <tr>
                                <td class="feature-name"><?php esc_html_e( 'Banking Options', 'casino-review-pro' ); ?></td>
                                <?php foreach ( $comparison_data as $casino ) : ?>
                                    <td class="feature-value">
                                        <?php if ( ! empty( $casino['payments_rating'] ) ) : ?>
                                            <div class="rating-meter">
                                                <div class="rating-progress" style="width: <?php echo esc_attr( $casino['payments_rating'] * 10 ); ?>%"></div>
                                                <span class="rating-value"><?php echo esc_html( $casino['payments_rating'] ); ?>/10</span>
                                            </div>
                                        <?php else : ?>
                                            <span class="not-available">—</span>
                                        <?php endif; ?>
                                    </td>
                                <?php endforeach; ?>
                            </tr>
                            <tr>
                                <td class="feature-name"><?php esc_html_e( 'Mobile Experience', 'casino-review-pro' ); ?></td>
                                <?php foreach ( $comparison_data as $casino ) : ?>
                                    <td class="feature-value">
                                        <?php if ( ! empty( $casino['mobile_rating'] ) ) : ?>
                                            <div class="rating-meter">
                                                <div class="rating-progress" style="width: <?php echo esc_attr( $casino['mobile_rating'] * 10 ); ?>%"></div>
                                                <span class="rating-value"><?php echo esc_html( $casino['mobile_rating'] ); ?>/10</span>
                                            </div>
                                        <?php else : ?>
                                            <span class="not-available">—</span>
                                        <?php endif; ?>
                                    </td>
                                <?php endforeach; ?>
                            </tr>
                        </tbody>
                    </table>
                </div>
                
                <!-- Banking Tab -->
                <div class="comparison-tab-content" id="banking-tab">
                    <table class="comparison-table banking-table">
                        <thead>
                            <tr>
                                <th class="feature-col"><?php esc_html_e( 'Banking Options', 'casino-review-pro' ); ?></th>
                                <?php foreach ( $comparison_data as $casino ) : ?>
                                    <th class="casino-col">
                                        <h3 class="casino-title"><?php echo esc_html( $casino['title'] ); ?></h3>
                                    </th>
                                <?php endforeach; ?>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="feature-name"><?php esc_html_e( 'Currencies', 'casino-review-pro' ); ?></td>
                                <?php foreach ( $comparison_data as $casino ) : ?>
                                    <td class="feature-value">
                                        <?php if ( ! empty( $casino['currencies'] ) ) : ?>
                                            <?php echo esc_html( $casino['currencies'] ); ?>
                                        <?php else : ?>
                                            <span class="not-available">—</span>
                                        <?php endif; ?>
                                    </td>
                                <?php endforeach; ?>
                            </tr>
                            <tr>
                                <td class="feature-name"><?php esc_html_e( 'Min. Deposit', 'casino-review-pro' ); ?></td>
                                <?php foreach ( $comparison_data as $casino ) : ?>
                                    <td class="feature-value">
                                        <?php if ( ! empty( $casino['min_deposit'] ) ) : ?>
                                            <?php echo esc_html( $casino['min_deposit'] ); ?>
                                        <?php else : ?>
                                            <span class="not-available">—</span>
                                        <?php endif; ?>
                                    </td>
                                <?php endforeach; ?>
                            </tr>
                            <tr>
                                <td class="feature-name"><?php esc_html_e( 'Min. Withdrawal', 'casino-review-pro' ); ?></td>
                                <?php foreach ( $comparison_data as $casino ) : ?>
                                    <td class="feature-value">
                                        <?php if ( ! empty( $casino['min_withdrawal'] ) ) : ?>
                                            <?php echo esc_html( $casino['min_withdrawal'] ); ?>
                                        <?php else : ?>
                                            <span class="not-available">—</span>
                                        <?php endif; ?>
                                    </td>
                                <?php endforeach; ?>
                            </tr>
                            <tr>
                                <td class="feature-name"><?php esc_html_e( 'Withdrawal Time', 'casino-review-pro' ); ?></td>
                                <?php foreach ( $comparison_data as $casino ) : ?>
                                    <td class="feature-value">
                                        <?php if ( ! empty( $casino['withdrawal_time'] ) ) : ?>
                                            <?php echo esc_html( $casino['withdrawal_time'] ); ?>
                                        <?php else : ?>
                                            <span class="not-available">—</span>
                                        <?php endif; ?>
                                    </td>
                                <?php endforeach; ?>
                            </tr>
                            <tr>
                                <td class="feature-name"><?php esc_html_e( 'Banking Rating', 'casino-review-pro' ); ?></td>
                                <?php foreach ( $comparison_data as $casino ) : ?>
                                    <td class="feature-value">
                                        <?php if ( ! empty( $casino['payments_rating'] ) ) : ?>
                                            <div class="rating-score"><?php echo esc_html( $casino['payments_rating'] ); ?></div>
                                            <div class="rating-stars">
                                                <?php echo casino_review_rating_stars( $casino['payments_rating'], 10 ); ?>
                                            </div>
                                        <?php else : ?>
                                            <span class="not-available">—</span>
                                        <?php endif; ?>
                                    </td>
                                <?php endforeach; ?>
                            </tr>
                        </tbody>
                    </table>
                </div>
                
                <!-- Bonuses Tab -->
                <div class="comparison-tab-content" id="bonuses-tab">
                    <table class="comparison-table bonuses-table">
                        <thead>
                            <tr>
                                <th class="feature-col"><?php esc_html_e( 'Bonuses', 'casino-review-pro' ); ?></th>
                                <?php foreach ( $comparison_data as $casino ) : ?>
                                    <th class="casino-col">
                                        <h3 class="casino-title"><?php echo esc_html( $casino['title'] ); ?></h3>
                                    </th>
                                <?php endforeach; ?>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="feature-name"><?php esc_html_e( 'Available Bonuses', 'casino-review-pro' ); ?></td>
                                <?php foreach ( $comparison_data as $casino ) : ?>
                                    <td class="feature-value">
                                        <?php if ( ! empty( $casino['bonuses'] ) ) : ?>
                                            <ul class="bonuses-list-comparison">
                                                <?php foreach ( $casino['bonuses'] as $bonus ) : ?>
                                                    <?php $bonus_value = get_post_meta( $bonus->ID, '_bonus_value', true ); ?>
                                                    <li class="bonus-item">
                                                        <a href="<?php echo esc_url( get_permalink( $bonus->ID ) ); ?>" class="bonus-title"><?php echo esc_html( $bonus->post_title ); ?></a>
                                                        <?php if ( $bonus_value ) : ?>
                                                            <div class="bonus-value"><?php echo esc_html( $bonus_value ); ?></div>
                                                        <?php endif; ?>
                                                    </li>
                                                <?php endforeach; ?>
                                            </ul>
                                        <?php else : ?>
                                            <span class="not-available"><?php esc_html_e( 'No bonuses found', 'casino-review-pro' ); ?></span>
                                        <?php endif; ?>
                                    </td>
                                <?php endforeach; ?>
                            </tr>
                            <tr>
                                <td class="feature-name"><?php esc_html_e( 'Bonuses Rating', 'casino-review-pro' ); ?></td>
                                <?php foreach ( $comparison_data as $casino ) : ?>
                                    <td class="feature-value">
                                        <?php if ( ! empty( $casino['bonuses_rating'] ) ) : ?>
                                            <div class="rating-score"><?php echo esc_html( $casino['bonuses_rating'] ); ?></div>
                                            <div class="rating-stars">
                                                <?php echo casino_review_rating_stars( $casino['bonuses_rating'], 10 ); ?>
                                            </div>
                                        <?php else : ?>
                                            <span class="not-available">—</span>
                                        <?php endif; ?>
                                    </td>
                                <?php endforeach; ?>
                            </tr>
                        </tbody>
                    </table>
                </div>
                
                <!-- Features Tab -->
                <div class="comparison-tab-content" id="features-tab">
                    <table class="comparison-table features-table">
                        <thead>
                            <tr>
                                <th class="feature-col"><?php esc_html_e( 'Casino Features', 'casino-review-pro' ); ?></th>
                                <?php foreach ( $comparison_data as $casino ) : ?>
                                    <th class="casino-col">
                                        <h3 class="casino-title"><?php echo esc_html( $casino['title'] ); ?></h3>
                                    </th>
                                <?php endforeach; ?>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="feature-name"><?php esc_html_e( 'Pros', 'casino-review-pro' ); ?></td>
                                <?php foreach ( $comparison_data as $casino ) : ?>
                                    <td class="feature-value">
                                        <?php if ( ! empty( $casino['pros'] ) ) : ?>
                                            <ul class="pros-list-comparison">
                                                <?php foreach ( $casino['pros'] as $pro ) : ?>
                                                    <?php if ( ! empty( trim( $pro ) ) ) : ?>
                                                        <li><i class="fa-solid fa-check"></i> <?php echo esc_html( trim( $pro ) ); ?></li>
                                                    <?php endif; ?>
                                                <?php endforeach; ?>
                                            </ul>
                                        <?php else : ?>
                                            <span class="not-available"><?php esc_html_e( 'No pros listed', 'casino-review-pro' ); ?></span>
                                        <?php endif; ?>
                                    </td>
                                <?php endforeach; ?>
                            </tr>
                            <tr>
                                <td class="feature-name"><?php esc_html_e( 'Cons', 'casino-review-pro' ); ?></td>
                                <?php foreach ( $comparison_data as $casino ) : ?>
                                    <td class="feature-value">
                                        <?php if ( ! empty( $casino['cons'] ) ) : ?>
                                            <ul class="cons-list-comparison">
                                                <?php foreach ( $casino['cons'] as $con ) : ?>
                                                    <?php if ( ! empty( trim( $con ) ) ) : ?>
                                                        <li><i class="fa-solid fa-xmark"></i> <?php echo esc_html( trim( $con ) ); ?></li>
                                                    <?php endif; ?>
                                                <?php endforeach; ?>
                                            </ul>
                                        <?php else : ?>
                                            <span class="not-available"><?php esc_html_e( 'No cons listed', 'casino-review-pro' ); ?></span>
                                        <?php endif; ?>
                                    </td>
                                <?php endforeach; ?>
                            </tr>
                            <tr>
                                <td class="feature-name"><?php esc_html_e( 'Action', 'casino-review-pro' ); ?></td>
                                <?php foreach ( $comparison_data as $casino ) : ?>
                                    <td class="feature-value action-buttons">
                                        <a href="<?php echo esc_url( $casino['permalink'] ); ?>" class="btn btn-sm btn-outline"><?php esc_html_e( 'Read Review', 'casino-review-pro' ); ?></a>
                                        
                                        <?php if ( ! empty( $casino['website_url'] ) ) : ?>
                                            <a href="<?php echo esc_url( $casino['website_url'] ); ?>" class="btn btn-sm btn-primary" target="_blank"><?php esc_html_e( 'Visit Casino', 'casino-review-pro' ); ?></a>
                                        <?php endif; ?>
                                    </td>
                                <?php endforeach; ?>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        <?php endif; ?>
    </div>
</main><!-- #main -->

<?php
get_footer();
