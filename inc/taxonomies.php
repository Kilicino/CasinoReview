<?php
/**
 * Custom taxonomies for Casino Review Pro Theme
 *
 * @package Casino_Review_Pro
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

/**
 * Register Custom Taxonomies
 * 
 * Note: The taxonomy registration is already handled in functions.php
 * This file is kept for consistency and future expansions
 */
function casino_review_register_additional_taxonomies() {
    // Taxonomies are registered in functions.php
    // This function can be used for any additional taxonomies
}
add_action( 'init', 'casino_review_register_additional_taxonomies', 11 );

/**
 * Add custom meta fields to Casino Category taxonomy
 */
function casino_review_casino_category_meta_fields() {
    // Add custom meta fields to casino category taxonomy if needed
}
add_action( 'casino_category_add_form_fields', 'casino_review_casino_category_meta_fields' );

/**
 * Add custom meta fields to Game Category taxonomy
 */
function casino_review_game_category_meta_fields() {
    // Add custom meta fields to game category taxonomy if needed
}
add_action( 'game_category_add_form_fields', 'casino_review_game_category_meta_fields' );

/**
 * Add custom meta fields to Bonus Type taxonomy
 */
function casino_review_bonus_type_meta_fields() {
    // Add custom meta fields to bonus type taxonomy if needed
}
add_action( 'bonus_type_add_form_fields', 'casino_review_bonus_type_meta_fields' );

/**
 * Add custom meta fields to Payment Type taxonomy
 */
function casino_review_payment_type_meta_fields() {
    // Add custom meta fields to payment type taxonomy if needed
}
add_action( 'payment_type_add_form_fields', 'casino_review_payment_type_meta_fields' );
