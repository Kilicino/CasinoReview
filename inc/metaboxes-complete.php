<?php
/**
 * Custom metaboxes for Casino Review Pro Theme
 *
 * @package Casino_Review_Pro
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

/**
 * Casino Rating Meta Box Callback
 */
function casino_review_rating_meta_callback( $post ) {
    wp_nonce_field( 'casino_review_rating_meta', 'casino_review_rating_meta_nonce' );

    $overall_rating = get_post_meta( $post->ID, '_casino_overall_rating', true );
    $games_rating = get_post_meta( $post->ID, '_casino_games_rating', true );
    $bonuses_rating = get_post_meta( $post->ID, '_casino_bonuses_rating', true );
    $support_rating = get_post_meta( $post->ID, '_casino_support_rating', true );
    $payments_rating = get_post_meta( $post->ID, '_casino_payments_rating', true );
    $mobile_rating = get_post_meta( $post->ID, '_casino_mobile_rating', true );
    ?>
    <p>
        <label for="casino_overall_rating"><?php _e( 'Overall Rating (0-10)', 'casino-review-pro' ); ?></label>
        <input type="number" id="casino_overall_rating" name="casino_overall_rating" value="<?php echo esc_attr( $overall_rating ); ?>" min="0" max="10" step="0.1" style="width: 100%;">
    </p>
    <p>
        <label for="casino_games_rating"><?php _e( 'Games Rating (0-10)', 'casino-review-pro' ); ?></label>
        <input type="number" id="casino_games_rating" name="casino_games_rating" value="<?php echo esc_attr( $games_rating ); ?>" min="0" max="10" step="0.1" style="width: 100%;">
    </p>
    <p>
        <label for="casino_bonuses_rating"><?php _e( 'Bonuses Rating (0-10)', 'casino-review-pro' ); ?></label>
        <input type="number" id="casino_bonuses_rating" name="casino_bonuses_rating" value="<?php echo esc_attr( $bonuses_rating ); ?>" min="0" max="10" step="0.1" style="width: 100%;">
    </p>
    <p>
        <label for="casino_support_rating"><?php _e( 'Support Rating (0-10)', 'casino-review-pro' ); ?></label>
        <input type="number" id="casino_support_rating" name="casino_support_rating" value="<?php echo esc_attr( $support_rating ); ?>" min="0" max="10" step="0.1" style="width: 100%;">
    </p>
    <p>
        <label for="casino_payments_rating"><?php _e( 'Payments Rating (0-10)', 'casino-review-pro' ); ?></label>
        <input type="number" id="casino_payments_rating" name="casino_payments_rating" value="<?php echo esc_attr( $payments_rating ); ?>" min="0" max="10" step="0.1" style="width: 100%;">
    </p>
    <p>
        <label for="casino_mobile_rating"><?php _e( 'Mobile Rating (0-10)', 'casino-review-pro' ); ?></label>
        <input type="number" id="casino_mobile_rating" name="casino_mobile_rating" value="<?php echo esc_attr( $mobile_rating ); ?>" min="0" max="10" step="0.1" style="width: 100%;">
    </p>
    <?php
}

/**
 * Casino Details Meta Box Callback
 */
function casino_review_details_meta_callback( $post ) {
    wp_nonce_field( 'casino_review_details_meta', 'casino_review_details_meta_nonce' );

    $website_url = get_post_meta( $post->ID, '_casino_website_url', true );
    $established = get_post_meta( $post->ID, '_casino_established', true );
    $license = get_post_meta( $post->ID, '_casino_license', true );
    $owner = get_post_meta( $post->ID, '_casino_owner', true );
    $software = get_post_meta( $post->ID, '_casino_software', true );
    $languages = get_post_meta( $post->ID, '_casino_languages', true );
    $currencies = get_post_meta( $post->ID, '_casino_currencies', true );
    $min_deposit = get_post_meta( $post->ID, '_casino_min_deposit', true );
    $min_withdrawal = get_post_meta( $post->ID, '_casino_min_withdrawal', true );
    $withdrawal_time = get_post_meta( $post->ID, '_casino_withdrawal_time', true );
    $pros = get_post_meta( $post->ID, '_casino_pros', true );
    $cons = get_post_meta( $post->ID, '_casino_cons', true );
    ?>
    <div class="casino-details-wrapper" style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
        <div class="casino-details-left">
            <p>
                <label for="casino_website_url"><?php _e( 'Website URL', 'casino-review-pro' ); ?></label>
                <input type="url" id="casino_website_url" name="casino_website_url" value="<?php echo esc_url( $website_url ); ?>" style="width: 100%;">
            </p>
            <p>
                <label for="casino_established"><?php _e( 'Established Year', 'casino-review-pro' ); ?></label>
                <input type="number" id="casino_established" name="casino_established" value="<?php echo esc_attr( $established ); ?>" min="1990" max="<?php echo date('Y'); ?>" style="width: 100%;">
            </p>
            <p>
                <label for="casino_license"><?php _e( 'License', 'casino-review-pro' ); ?></label>
                <input type="text" id="casino_license" name="casino_license" value="<?php echo esc_attr( $license ); ?>" style="width: 100%;">
            </p>
            <p>
                <label for="casino_owner"><?php _e( 'Owner/Operator', 'casino-review-pro' ); ?></label>
                <input type="text" id="casino_owner" name="casino_owner" value="<?php echo esc_attr( $owner ); ?>" style="width: 100%;">
            </p>
            <p>
                <label for="casino_software"><?php _e( 'Software Providers', 'casino-review-pro' ); ?></label>
                <input type="text" id="casino_software" name="casino_software" value="<?php echo esc_attr( $software ); ?>" style="width: 100%;">
                <small><?php _e( 'Comma-separated list of software providers', 'casino-review-pro' ); ?></small>
            </p>
        </div>
        <div class="casino-details-right">
            <p>
                <label for="casino_languages"><?php _e( 'Languages', 'casino-review-pro' ); ?></label>
                <input type="text" id="casino_languages" name="casino_languages" value="<?php echo esc_attr( $languages ); ?>" style="width: 100%;">
                <small><?php _e( 'Comma-separated list of supported languages', 'casino-review-pro' ); ?></small>
            </p>
            <p>
                <label for="casino_currencies"><?php _e( 'Currencies', 'casino-review-pro' ); ?></label>
                <input type="text" id="casino_currencies" name="casino_currencies" value="<?php echo esc_attr( $currencies ); ?>" style="width: 100%;">
                <small><?php _e( 'Comma-separated list of accepted currencies', 'casino-review-pro' ); ?></small>
            </p>
            <p>
                <label for="casino_min_deposit"><?php _e( 'Minimum Deposit', 'casino-review-pro' ); ?></label>
                <input type="text" id="casino_min_deposit" name="casino_min_deposit" value="<?php echo esc_attr( $min_deposit ); ?>" style="width: 100%;">
            </p>
            <p>
                <label for="casino_min_withdrawal"><?php _e( 'Minimum Withdrawal', 'casino-review-pro' ); ?></label>
                <input type="text" id="casino_min_withdrawal" name="casino_min_withdrawal" value="<?php echo esc_attr( $min_withdrawal ); ?>" style="width: 100%;">
            </p>
            <p>
                <label for="casino_withdrawal_time"><?php _e( 'Withdrawal Time', 'casino-review-pro' ); ?></label>
                <input type="text" id="casino_withdrawal_time" name="casino_withdrawal_time" value="<?php echo esc_attr( $withdrawal_time ); ?>" style="width: 100%;">
            </p>
        </div>
    </div>
    
    <div class="casino-pros-cons" style="margin-top: 20px;">
        <div class="casino-pros" style="margin-bottom: 20px;">
            <label for="casino_pros"><?php _e( 'Pros (one per line)', 'casino-review-pro' ); ?></label>
            <textarea id="casino_pros" name="casino_pros" rows="5" style="width: 100%;"><?php echo esc_textarea( $pros ); ?></textarea>
        </div>
        <div class="casino-cons">
            <label for="casino_cons"><?php _e( 'Cons (one per line)', 'casino-review-pro' ); ?></label>
            <textarea id="casino_cons" name="casino_cons" rows="5" style="width: 100%;"><?php echo esc_textarea( $cons ); ?></textarea>
        </div>
    </div>
    <?php
}

/**
 * Casino Bonuses Meta Box Callback
 */
function casino_review_bonuses_meta_callback( $post ) {
    wp_nonce_field( 'casino_review_bonuses_meta', 'casino_review_bonuses_meta_nonce' );
    
    $bonuses = get_posts(array(
        'post_type' => 'bonus',
        'posts_per_page' => -1,
        'meta_query' => array(
            array(
                'key' => '_bonus_casino',
                'value' => $post->ID,
                'compare' => '='
            )
        )
    ));
    
    echo '<div class="casino-bonuses-wrapper">';
    
    if (!empty($bonuses)) {
        echo '<h4>' . __('Associated Bonuses', 'casino-review-pro') . '</h4>';
        echo '<table class="widefat striped">';
        echo '<thead><tr>';
        echo '<th>' . __('Bonus Name', 'casino-review-pro') . '</th>';
        echo '<th>' . __('Value', 'casino-review-pro') . '</th>';
        echo '<th>' . __('Code', 'casino-review-pro') . '</th>';
        echo '<th>' . __('Actions', 'casino-review-pro') . '</th>';
        echo '</tr></thead>';
        echo '<tbody>';
        
        foreach ($bonuses as $bonus) {
            $bonus_value = get_post_meta($bonus->ID, '_bonus_value', true);
            $bonus_code = get_post_meta($bonus->ID, '_bonus_code', true);
            
            echo '<tr>';
            echo '<td><a href="' . get_edit_post_link($bonus->ID) . '">' . esc_html($bonus->post_title) . '</a></td>';
            echo '<td>' . esc_html($bonus_value) . '</td>';
            echo '<td>' . esc_html($bonus_code) . '</td>';
            echo '<td><a href="' . get_edit_post_link($bonus->ID) . '" class="button">' . __('Edit', 'casino-review-pro') . '</a></td>';
            echo '</tr>';
        }
        
        echo '</tbody></table>';
    } else {
        echo '<p>' . __('No bonuses associated with this casino.', 'casino-review-pro') . '</p>';
    }
    
    echo '<p><a href="' . admin_url('post-new.php?post_type=bonus&casino_id=' . $post->ID) . '" class="button button-primary">' . __('Add New Bonus', 'casino-review-pro') . '</a></p>';
    
    echo '</div>';
}

/**
 * Casino Payment Methods Meta Box Callback
 */
function casino_review_payments_meta_callback( $post ) {
    wp_nonce_field( 'casino_review_payments_meta', 'casino_review_payments_meta_nonce' );
    
    // Get all available payment methods
    $all_payment_methods = get_posts(array(
        'post_type' => 'payment_method',
        'posts_per_page' => -1,
        'orderby' => 'title',
        'order' => 'ASC'
    ));
    
    // Get the current casino's payment methods
    $casino_payment_methods = get_post_meta($post->ID, '_casino_payment_methods', true);
    if (!is_array($casino_payment_methods)) {
        $casino_payment_methods = array();
    }
    
    echo '<div class="casino-payments-wrapper">';
    echo '<p>' . __('Select the payment methods accepted by this casino:', 'casino-review-pro') . '</p>';
    
    if (!empty($all_payment_methods)) {
        echo '<div class="payment-methods-grid" style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 10px;">';
        
        foreach ($all_payment_methods as $method) {
            $checked = in_array($method->ID, $casino_payment_methods) ? 'checked="checked"' : '';
            
            echo '<div class="payment-method-item">';
            echo '<label>';
            echo '<input type="checkbox" name="casino_payment_methods[]" value="' . $method->ID . '" ' . $checked . '>';
            echo ' ' . esc_html($method->post_title);
            echo '</label>';
            echo '</div>';
        }
        
        echo '</div>';
    } else {
        echo '<p>' . __('No payment methods available. Please create some payment methods first.', 'casino-review-pro') . '</p>';
    }
    
    echo '</div>';
}

/**
 * Game Details Meta Box Callback
 */
function casino_review_game_details_meta_callback( $post ) {
    wp_nonce_field( 'casino_review_game_details_meta', 'casino_review_game_details_meta_nonce' );
    
    $game_provider = get_post_meta( $post->ID, '_game_provider', true );
    $game_type = get_post_meta( $post->ID, '_game_type', true );
    $game_rtp = get_post_meta( $post->ID, '_game_rtp', true );
    $game_volatility = get_post_meta( $post->ID, '_game_volatility', true );
    $game_min_bet = get_post_meta( $post->ID, '_game_min_bet', true );
    $game_max_bet = get_post_meta( $post->ID, '_game_max_bet', true );
    $game_features = get_post_meta( $post->ID, '_game_features', true );
    $game_rating = get_post_meta( $post->ID, '_game_rating', true );
    $game_play_url = get_post_meta( $post->ID, '_game_play_url', true );
    $game_casinos = get_post_meta( $post->ID, '_game_casinos', true );
    
    if (!is_array($game_casinos)) {
        $game_casinos = array();
    }
    ?>
    <div class="game-details-wrapper" style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
        <div class="game-details-left">
            <p>
                <label for="game_provider"><?php _e( 'Game Provider', 'casino-review-pro' ); ?></label>
                <input type="text" id="game_provider" name="game_provider" value="<?php echo esc_attr( $game_provider ); ?>" style="width: 100%;">
            </p>
            <p>
                <label for="game_type"><?php _e( 'Game Type', 'casino-review-pro' ); ?></label>
                <input type="text" id="game_type" name="game_type" value="<?php echo esc_attr( $game_type ); ?>" style="width: 100%;">
            </p>
            <p>
                <label for="game_rtp"><?php _e( 'RTP (%)', 'casino-review-pro' ); ?></label>
                <input type="text" id="game_rtp" name="game_rtp" value="<?php echo esc_attr( $game_rtp ); ?>" style="width: 100%;">
            </p>
            <p>
                <label for="game_volatility"><?php _e( 'Volatility', 'casino-review-pro' ); ?></label>
                <select id="game_volatility" name="game_volatility" style="width: 100%;">
                    <option value="" <?php selected( $game_volatility, '' ); ?>><?php _e( 'Select Volatility', 'casino-review-pro' ); ?></option>
                    <option value="Low" <?php selected( $game_volatility, 'Low' ); ?>><?php _e( 'Low', 'casino-review-pro' ); ?></option>
                    <option value="Medium" <?php selected( $game_volatility, 'Medium' ); ?>><?php _e( 'Medium', 'casino-review-pro' ); ?></option>
                    <option value="High" <?php selected( $game_volatility, 'High' ); ?>><?php _e( 'High', 'casino-review-pro' ); ?></option>
                    <option value="Very High" <?php selected( $game_volatility, 'Very High' ); ?>><?php _e( 'Very High', 'casino-review-pro' ); ?></option>
                </select>
            </p>
        </div>
        <div class="game-details-right">
            <p>
                <label for="game_min_bet"><?php _e( 'Minimum Bet', 'casino-review-pro' ); ?></label>
                <input type="text" id="game_min_bet" name="game_min_bet" value="<?php echo esc_attr( $game_min_bet ); ?>" style="width: 100%;">
            </p>
            <p>
                <label for="game_max_bet"><?php _e( 'Maximum Bet', 'casino-review-pro' ); ?></label>
                <input type="text" id="game_max_bet" name="game_max_bet" value="<?php echo esc_attr( $game_max_bet ); ?>" style="width: 100%;">
            </p>
            <p>
                <label for="game_rating"><?php _e( 'Game Rating (0-10)', 'casino-review-pro' ); ?></label>
                <input type="number" id="game_rating" name="game_rating" value="<?php echo esc_attr( $game_rating ); ?>" min="0" max="10" step="0.1" style="width: 100%;">
            </p>
            <p>
                <label for="game_play_url"><?php _e( 'Play Game URL', 'casino-review-pro' ); ?></label>
                <input type="url" id="game_play_url" name="game_play_url" value="<?php echo esc_url( $game_play_url ); ?>" style="width: 100%;">
            </p>
        </div>
    </div>
    
    <div class="game-features-wrapper" style="margin-top: 20px;">
        <label for="game_features"><?php _e( 'Game Features (one per line)', 'casino-review-pro' ); ?></label>
        <textarea id="game_features" name="game_features" rows="5" style="width: 100%;"><?php echo esc_textarea( $game_features ); ?></textarea>
    </div>
    
    <div class="game-casinos-wrapper" style="margin-top: 20px;">
        <label><?php _e( 'Casinos offering this game:', 'casino-review-pro' ); ?></label>
        
        <?php
        // Get all casinos
        $all_casinos = get_posts(array(
            'post_type' => 'casino',
            'posts_per_page' => -1,
            'orderby' => 'title',
            'order' => 'ASC'
        ));
        
        if (!empty($all_casinos)) {
            echo '<div class="casinos-grid" style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 10px; margin-top: 10px;">';
            
            foreach ($all_casinos as $casino) {
                $checked = in_array($casino->ID, $game_casinos) ? 'checked="checked"' : '';
                
                echo '<div class="casino-item">';
                echo '<label>';
                echo '<input type="checkbox" name="game_casinos[]" value="' . $casino->ID . '" ' . $checked . '>';
                echo ' ' . esc_html($casino->post_title);
                echo '</label>';
                echo '</div>';
            }
            
            echo '</div>';
        } else {
            echo '<p>' . __('No casinos available. Please create some casinos first.', 'casino-review-pro') . '</p>';
        }
        ?>
    </div>
    <?php
}

/**
 * Bonus Details Meta Box Callback
 */
function casino_review_bonus_details_meta_callback( $post ) {
    wp_nonce_field( 'casino_review_bonus_details_meta', 'casino_review_bonus_details_meta_nonce' );
    
    $bonus_value = get_post_meta( $post->ID, '_bonus_value', true );
    $bonus_code = get_post_meta( $post->ID, '_bonus_code', true );
    $bonus_expiry = get_post_meta( $post->ID, '_bonus_expiry', true );
    $bonus_terms = get_post_meta( $post->ID, '_bonus_terms', true );
    $bonus_casino = get_post_meta( $post->ID, '_bonus_casino', true );
    $bonus_exclusive = get_post_meta( $post->ID, '_bonus_exclusive', true );
    
    // Check if we're coming from a casino page
    $casino_id = isset($_GET['casino_id']) ? intval($_GET['casino_id']) : 0;
    if ($casino_id > 0 && empty($bonus_casino)) {
        $bonus_casino = $casino_id;
    }
    ?>
    <div class="bonus-details-wrapper" style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
        <div class="bonus-details-left">
            <p>
                <label for="bonus_value"><?php _e( 'Bonus Value', 'casino-review-pro' ); ?></label>
                <input type="text" id="bonus_value" name="bonus_value" value="<?php echo esc_attr( $bonus_value ); ?>" style="width: 100%;">
                <small><?php _e( 'E.g., "100% up to $200", "$10 Free", etc.', 'casino-review-pro' ); ?></small>
            </p>
            <p>
                <label for="bonus_code"><?php _e( 'Bonus Code', 'casino-review-pro' ); ?></label>
                <input type="text" id="bonus_code" name="bonus_code" value="<?php echo esc_attr( $bonus_code ); ?>" style="width: 100%;">
                <small><?php _e( 'Leave empty if no code is required', 'casino-review-pro' ); ?></small>
            </p>
            <p>
                <label for="bonus_expiry"><?php _e( 'Expiry Date', 'casino-review-pro' ); ?></label>
                <input type="text" id="bonus_expiry" name="bonus_expiry" value="<?php echo esc_attr( $bonus_expiry ); ?>" style="width: 100%;">
                <small><?php _e( 'E.g., "31/12/2023", "No Expiry", etc.', 'casino-review-pro' ); ?></small>
            </p>
            <p>
                <label for="bonus_exclusive">
                    <input type="checkbox" id="bonus_exclusive" name="bonus_exclusive" value="1" <?php checked( $bonus_exclusive, '1' ); ?>>
                    <?php _e( 'Exclusive Bonus Offer', 'casino-review-pro' ); ?>
                </label>
            </p>
        </div>
        <div class="bonus-details-right">
            <p>
                <label for="bonus_casino"><?php _e( 'Associated Casino', 'casino-review-pro' ); ?></label>
                <select id="bonus_casino" name="bonus_casino" style="width: 100%;">
                    <option value=""><?php _e( 'Select Casino', 'casino-review-pro' ); ?></option>
                    <?php
                    // Get all casinos
                    $casinos = get_posts(array(
                        'post_type' => 'casino',
                        'posts_per_page' => -1,
                        'orderby' => 'title',
                        'order' => 'ASC'
                    ));
                    
                    foreach ($casinos as $casino) {
                        echo '<option value="' . $casino->ID . '" ' . selected($bonus_casino, $casino->ID, false) . '>' . esc_html($casino->post_title) . '</option>';
                    }
                    ?>
                </select>
            </p>
        </div>
    </div>
    
    <div class="bonus-terms-wrapper" style="margin-top: 20px;">
        <label for="bonus_terms"><?php _e( 'Bonus Terms & Conditions', 'casino-review-pro' ); ?></label>
        <textarea id="bonus_terms" name="bonus_terms" rows="10" style="width: 100%;"><?php echo esc_textarea( $bonus_terms ); ?></textarea>
    </div>
    <?php
}

/**
 * Payment Method Details Meta Box Callback
 */
function casino_review_payment_method_details_meta_callback( $post ) {
    wp_nonce_field( 'casino_review_payment_method_details_meta', 'casino_review_payment_method_details_meta_nonce' );
    
    $deposit_time = get_post_meta( $post->ID, '_payment_deposit_time', true );
    $withdrawal_time = get_post_meta( $post->ID, '_payment_withdrawal_time', true );
    $min_deposit = get_post_meta( $post->ID, '_payment_min_deposit', true );
    $max_deposit = get_post_meta( $post->ID, '_payment_max_deposit', true );
    $min_withdrawal = get_post_meta( $post->ID, '_payment_min_withdrawal', true );
    $max_withdrawal = get_post_meta( $post->ID, '_payment_max_withdrawal', true );
    $fees = get_post_meta( $post->ID, '_payment_fees', true );
    $currencies = get_post_meta( $post->ID, '_payment_currencies', true );
    $website_url = get_post_meta( $post->ID, '_payment_website', true );
    $pros = get_post_meta( $post->ID, '_payment_pros', true );
    $cons = get_post_meta( $post->ID, '_payment_cons', true );
    ?>
    <div class="payment-details-wrapper" style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
        <div class="payment-details-left">
            <p>
                <label for="payment_deposit_time"><?php _e( 'Deposit Time', 'casino-review-pro' ); ?></label>
                <input type="text" id="payment_deposit_time" name="payment_deposit_time" value="<?php echo esc_attr( $deposit_time ); ?>" style="width: 100%;">
                <small><?php _e( 'E.g., "Instant", "24 Hours", etc.', 'casino-review-pro' ); ?></small>
            </p>
            <p>
                <label for="payment_withdrawal_time"><?php _e( 'Withdrawal Time', 'casino-review-pro' ); ?></label>
                <input type="text" id="payment_withdrawal_time" name="payment_withdrawal_time" value="<?php echo esc_attr( $withdrawal_time ); ?>" style="width: 100%;">
                <small><?php _e( 'E.g., "1-3 Business Days", "24-48 Hours", etc.', 'casino-review-pro' ); ?></small>
            </p>
            <p>
                <label for="payment_min_deposit"><?php _e( 'Min. Deposit', 'casino-review-pro' ); ?></label>
                <input type="text" id="payment_min_deposit" name="payment_min_deposit" value="<?php echo esc_attr( $min_deposit ); ?>" style="width: 100%;">
            </p>
            <p>
                <label for="payment_max_deposit"><?php _e( 'Max. Deposit', 'casino-review-pro' ); ?></label>
                <input type="text" id="payment_max_deposit" name="payment_max_deposit" value="<?php echo esc_attr( $max_deposit ); ?>" style="width: 100%;">
            </p>
        </div>
        <div class="payment-details-right">
            <p>
                <label for="payment_min_withdrawal"><?php _e( 
<input type="text" id="payment_min_withdrawal" name="payment_min_withdrawal" value="<?php echo esc_attr( $min_withdrawal ); ?>" style="width: 100%;">
            </p>
            <p>
                <label for="payment_max_withdrawal"><?php _e( 'Max. Withdrawal', 'casino-review-pro' ); ?></label>
                <input type="text" id="payment_max_withdrawal" name="payment_max_withdrawal" value="<?php echo esc_attr( $max_withdrawal ); ?>" style="width: 100%;">
            </p>
            <p>
                <label for="payment_fees"><?php _e( 'Fees', 'casino-review-pro' ); ?></label>
                <input type="text" id="payment_fees" name="payment_fees" value="<?php echo esc_attr( $fees ); ?>" style="width: 100%;">
                <small><?php _e( 'E.g., "Free", "2%", "€5 per transaction", etc.', 'casino-review-pro' ); ?></small>
            </p>
            <p>
                <label for="payment_currencies"><?php _e( 'Supported Currencies', 'casino-review-pro' ); ?></label>
                <input type="text" id="payment_currencies" name="payment_currencies" value="<?php echo esc_attr( $currencies ); ?>" style="width: 100%;">
                <small><?php _e( 'Comma-separated list of currencies', 'casino-review-pro' ); ?></small>
            </p>
        </div>
    </div>
    
    <p style="margin-top: 20px;">
        <label for="payment_website"><?php _e( 'Website URL', 'casino-review-pro' ); ?></label>
        <input type="url" id="payment_website" name="payment_website" value="<?php echo esc_url( $website_url ); ?>" style="width: 100%;">
    </p>
    
    <div class="payment-pros-cons" style="margin-top: 20px; display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
        <div class="payment-pros">
            <label for="payment_pros"><?php _e( 'Pros (one per line)', 'casino-review-pro' ); ?></label>
            <textarea id="payment_pros" name="payment_pros" rows="5" style="width: 100%;"><?php echo esc_textarea( $pros ); ?></textarea>
        </div>
        <div class="payment-cons">
            <label for="payment_cons"><?php _e( 'Cons (one per line)', 'casino-review-pro' ); ?></label>
            <textarea id="payment_cons" name="payment_cons" rows="5" style="width: 100%;"><?php echo esc_textarea( $cons ); ?></textarea>
        </div>
    </div>
    <?php
}

/**
 * Save the meta box data
 * 
 * Note: This is handled in functions.php so we don't need to duplicate it here
 */
function casino_review_save_metabox_data($post_id) {
    // This function would handle saving all the meta box data
    // It's already defined in functions.php
}

// The hooks for saving metabox data are already in functions.php