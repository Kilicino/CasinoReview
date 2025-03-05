<?php
/**
 * Custom post types for Casino Review Pro Theme
 *
 * @package Casino_Review_Pro
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

/**
 * Register Custom Post Types
 * 
 * Note: The post type registration is already handled in functions.php
 * This file is kept for consistency and future expansions
 */
function casino_review_register_additional_post_types() {
    // Post types are registered in functions.php
    // This function can be used for any additional post types
}
add_action( 'init', 'casino_review_register_additional_post_types', 11 );

/**
 * Customize admin columns for Casino post type
 */
function casino_review_customize_casino_admin() {
    // Add admin customizations for casino post type
    // Note: Basic customizations are already in functions.php
}
add_action( 'admin_init', 'casino_review_customize_casino_admin' );

/**
 * Customize admin columns for Bonus post type
 */
function casino_review_customize_bonus_admin() {
    // Add custom admin columns for bonus post type
}
add_action( 'admin_init', 'casino_review_customize_bonus_admin' );

/**
 * Customize admin columns for Game post type
 */
function casino_review_customize_game_admin() {
    // Add custom admin columns for game post type
}
add_action( 'admin_init', 'casino_review_customize_game_admin' );

/**
 * Customize admin columns for Payment Method post type
 */
function casino_review_customize_payment_method_admin() {
    // Add custom admin columns for payment method post type
}
add_action( 'admin_init', 'casino_review_customize_payment_method_admin' );
