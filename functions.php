<?php
/**
 * Casino Review Pro functions and definitions
 *
 * @package Casino_Review_Pro
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

// Define theme constants
define( 'CASINO_REVIEW_VERSION', '1.0.0' );
define( 'CASINO_REVIEW_DIR', get_template_directory() );
define( 'CASINO_REVIEW_URI', get_template_directory_uri() );

/**
 * Setup theme
 */
function casino_review_setup() {
    // Add default posts and comments RSS feed links to head
    add_theme_support( 'automatic-feed-links' );

    // Let WordPress manage the document title
    add_theme_support( 'title-tag' );

    // Enable support for Post Thumbnails on posts and pages
    add_theme_support( 'post-thumbnails' );

    // Register nav menus
    register_nav_menus(
        array(
            'primary' => esc_html__( 'Primary Menu', 'casino-review-pro' ),
            'footer'  => esc_html__( 'Footer Menu', 'casino-review-pro' ),
        )
    );

    // Switch default core markup to output valid HTML5
    add_theme_support(
        'html5',
        array(
            'search-form',
            'comment-form',
            'comment-list',
            'gallery',
            'caption',
            'style',
            'script',
        )
    );

    // Add theme support for selective refresh for widgets
    add_theme_support( 'customize-selective-refresh-widgets' );

    // Add support for full and wide align images
    add_theme_support( 'align-wide' );

    // Add support for responsive embeds
    add_theme_support( 'responsive-embeds' );

    // Add support for custom logo
    add_theme_support(
        'custom-logo',
        array(
            'height'      => 250,
            'width'       => 250,
            'flex-width'  => true,
            'flex-height' => true,
        )
    );

    // Add image sizes
    add_image_size( 'casino-logo', 300, 200, false );
    add_image_size( 'casino-thumbnail', 150, 100, false );
    add_image_size( 'game-thumbnail', 400, 300, true );
}
add_action( 'after_setup_theme', 'casino_review_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 */
function casino_review_content_width() {
    $GLOBALS['content_width'] = apply_filters( 'casino_review_content_width', 1140 );
}
add_action( 'after_setup_theme', 'casino_review_content_width', 0 );

/**
 * Register widget area.
 */
function casino_review_widgets_init() {
    register_sidebar(
        array(
            'name'          => esc_html__( 'Sidebar', 'casino-review-pro' ),
            'id'            => 'sidebar-1',
            'description'   => esc_html__( 'Add widgets here.', 'casino-review-pro' ),
            'before_widget' => '<section id="%1$s" class="widget %2$s">',
            'after_widget'  => '</section>',
            'before_title'  => '<h2 class="widget-title">',
            'after_title'   => '</h2>',
        )
    );

    register_sidebar(
        array(
            'name'          => esc_html__( 'Footer 1', 'casino-review-pro' ),
            'id'            => 'footer-1',
            'description'   => esc_html__( 'First footer widget area', 'casino-review-pro' ),
            'before_widget' => '<div id="%1$s" class="footer-widget %2$s">',
            'after_widget'  => '</div>',
            'before_title'  => '<h3 class="footer-widget-title">',
            'after_title'   => '</h3>',
        )
    );

    register_sidebar(
        array(
            'name'          => esc_html__( 'Footer 2', 'casino-review-pro' ),
            'id'            => 'footer-2',
            'description'   => esc_html__( 'Second footer widget area', 'casino-review-pro' ),
            'before_widget' => '<div id="%1$s" class="footer-widget %2$s">',
            'after_widget'  => '</div>',
            'before_title'  => '<h3 class="footer-widget-title">',
            'after_title'   => '</h3>',
        )
    );

    register_sidebar(
        array(
            'name'          => esc_html__( 'Footer 3', 'casino-review-pro' ),
            'id'            => 'footer-3',
            'description'   => esc_html__( 'Third footer widget area', 'casino-review-pro' ),
            'before_widget' => '<div id="%1$s" class="footer-widget %2$s">',
            'after_widget'  => '</div>',
            'before_title'  => '<h3 class="footer-widget-title">',
            'after_title'   => '</h3>',
        )
    );

    register_sidebar(
        array(
            'name'          => esc_html__( 'Footer 4', 'casino-review-pro' ),
            'id'            => 'footer-4',
            'description'   => esc_html__( 'Fourth footer widget area', 'casino-review-pro' ),
            'before_widget' => '<div id="%1$s" class="footer-widget %2$s">',
            'after_widget'  => '</div>',
            'before_title'  => '<h3 class="footer-widget-title">',
            'after_title'   => '</h3>',
        )
    );
}
add_action( 'widgets_init', 'casino_review_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function casino_review_scripts() {
    // Enqueue Google Fonts
    wp_enqueue_style( 'casino-review-fonts', 'https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap', array(), null );
    
    // Enqueue Font Awesome
    wp_enqueue_style( 'font-awesome', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css', array(), '6.0.0' );
    
    // Main stylesheet
    wp_enqueue_style( 'casino-review-style', get_stylesheet_uri(), array(), CASINO_REVIEW_VERSION );
    
    // Main JavaScript
    wp_enqueue_script( 'casino-review-navigation', CASINO_REVIEW_URI . '/assets/js/navigation.js', array(), CASINO_REVIEW_VERSION, true );
    
    // Custom scripts
    wp_enqueue_script( 'casino-review-scripts', CASINO_REVIEW_URI . '/assets/js/scripts.js', array('jquery'), CASINO_REVIEW_VERSION, true );
    
    // Localize script for AJAX
    wp_localize_script( 
        'casino-review-scripts', 
        'casinoReviewVars', 
        array(
            'ajaxurl' => admin_url( 'admin-ajax.php' ),
            'nonce'   => wp_create_nonce( 'casino-review-nonce' ),
        )
    );

    if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
        wp_enqueue_script( 'comment-reply' );
    }
}
add_action( 'wp_enqueue_scripts', 'casino_review_scripts' );

/**
 * Custom template tags for this theme.
 */
require CASINO_REVIEW_DIR . '/inc/template-tags.php';

/**
 * Functions which enhance the theme by hooking into WordPress.
 */
require CASINO_REVIEW_DIR . '/inc/template-functions.php';

/**
 * Customizer additions.
 */
require CASINO_REVIEW_DIR . '/inc/customizer.php';

/**
 * Custom Widgets
 */
require CASINO_REVIEW_DIR . '/inc/widgets.php';

/**
 * Custom Post Types
 */
require CASINO_REVIEW_DIR . '/inc/post-types.php';

/**
 * Custom Taxonomies
 */
require CASINO_REVIEW_DIR . '/inc/taxonomies.php';

/**
 * Custom Metaboxes
 */
require CASINO_REVIEW_DIR . '/inc/metaboxes.php';

/**
 * AJAX handlers
 */
require CASINO_REVIEW_DIR . '/inc/ajax-handlers.php';

/**
 * Admin functions
 */
require CASINO_REVIEW_DIR . '/inc/admin-functions.php';

/**
 * Casino Review Options Framework
 */
require CASINO_REVIEW_DIR . '/inc/options-framework.php';

/**
 * Register Custom Post Types
 */
function casino_review_register_post_types() {
    // Casino Post Type
    $casino_labels = array(
        'name'               => _x( 'Casinos', 'post type general name', 'casino-review-pro' ),
        'singular_name'      => _x( 'Casino', 'post type singular name', 'casino-review-pro' ),
        'menu_name'          => _x( 'Casinos', 'admin menu', 'casino-review-pro' ),
        'name_admin_bar'     => _x( 'Casino', 'add new on admin bar', 'casino-review-pro' ),
        'add_new'            => _x( 'Add New', 'casino', 'casino-review-pro' ),
        'add_new_item'       => __( 'Add New Casino', 'casino-review-pro' ),
        'new_item'           => __( 'New Casino', 'casino-review-pro' ),
        'edit_item'          => __( 'Edit Casino', 'casino-review-pro' ),
        'view_item'          => __( 'View Casino', 'casino-review-pro' ),
        'all_items'          => __( 'All Casinos', 'casino-review-pro' ),
        'search_items'       => __( 'Search Casinos', 'casino-review-pro' ),
        'parent_item_colon'  => __( 'Parent Casinos:', 'casino-review-pro' ),
        'not_found'          => __( 'No casinos found.', 'casino-review-pro' ),
        'not_found_in_trash' => __( 'No casinos found in Trash.', 'casino-review-pro' )
    );

    $casino_args = array(
        'labels'             => $casino_labels,
        'description'        => __( 'Online Casino Reviews', 'casino-review-pro' ),
        'public'             => true,
        'publicly_queryable' => true,
        'show_ui'            => true,
        'show_in_menu'       => true,
        'query_var'          => true,
        'rewrite'            => array( 'slug' => 'casino' ),
        'capability_type'    => 'post',
        'has_archive'        => true,
        'hierarchical'       => false,
        'menu_position'      => 5,
        'menu_icon'          => 'dashicons-money-alt',
        'supports'           => array( 'title', 'editor', 'author', 'thumbnail', 'excerpt', 'comments', 'custom-fields' ),
        'show_in_rest'       => true,
    );

    register_post_type( 'casino', $casino_args );

    // Bonus Post Type
    $bonus_labels = array(
        'name'               => _x( 'Bonuses', 'post type general name', 'casino-review-pro' ),
        'singular_name'      => _x( 'Bonus', 'post type singular name', 'casino-review-pro' ),
        'menu_name'          => _x( 'Bonuses', 'admin menu', 'casino-review-pro' ),
        'name_admin_bar'     => _x( 'Bonus', 'add new on admin bar', 'casino-review-pro' ),
        'add_new'            => _x( 'Add New', 'bonus', 'casino-review-pro' ),
        'add_new_item'       => __( 'Add New Bonus', 'casino-review-pro' ),
        'new_item'           => __( 'New Bonus', 'casino-review-pro' ),
        'edit_item'          => __( 'Edit Bonus', 'casino-review-pro' ),
        'view_item'          => __( 'View Bonus', 'casino-review-pro' ),
        'all_items'          => __( 'All Bonuses', 'casino-review-pro' ),
        'search_items'       => __( 'Search Bonuses', 'casino-review-pro' ),
        'parent_item_colon'  => __( 'Parent Bonuses:', 'casino-review-pro' ),
        'not_found'          => __( 'No bonuses found.', 'casino-review-pro' ),
        'not_found_in_trash' => __( 'No bonuses found in Trash.', 'casino-review-pro' )
    );

    $bonus_args = array(
        'labels'             => $bonus_labels,
        'description'        => __( 'Casino Bonus Offers', 'casino-review-pro' ),
        'public'             => true,
        'publicly_queryable' => true,
        'show_ui'            => true,
        'show_in_menu'       => true,
        'query_var'          => true,
        'rewrite'            => array( 'slug' => 'bonus' ),
        'capability_type'    => 'post',
        'has_archive'        => true,
        'hierarchical'       => false,
        'menu_position'      => 6,
        'menu_icon'          => 'dashicons-tickets-alt',
        'supports'           => array( 'title', 'editor', 'author', 'thumbnail', 'excerpt', 'custom-fields' ),
        'show_in_rest'       => true,
    );

    register_post_type( 'bonus', $bonus_args );

    // Game Post Type
    $game_labels = array(
        'name'               => _x( 'Games', 'post type general name', 'casino-review-pro' ),
        'singular_name'      => _x( 'Game', 'post type singular name', 'casino-review-pro' ),
        'menu_name'          => _x( 'Games', 'admin menu', 'casino-review-pro' ),
        'name_admin_bar'     => _x( 'Game', 'add new on admin bar', 'casino-review-pro' ),
        'add_new'            => _x( 'Add New', 'game', 'casino-review-pro' ),
        'add_new_item'       => __( 'Add New Game', 'casino-review-pro' ),
        'new_item'           => __( 'New Game', 'casino-review-pro' ),
        'edit_item'          => __( 'Edit Game', 'casino-review-pro' ),
        'view_item'          => __( 'View Game', 'casino-review-pro' ),
        'all_items'          => __( 'All Games', 'casino-review-pro' ),
        'search_items'       => __( 'Search Games', 'casino-review-pro' ),
        'parent_item_colon'  => __( 'Parent Games:', 'casino-review-pro' ),
        'not_found'          => __( 'No games found.', 'casino-review-pro' ),
        'not_found_in_trash' => __( 'No games found in Trash.', 'casino-review-pro' )
    );

    $game_args = array(
        'labels'             => $game_labels,
        'description'        => __( 'Casino Games', 'casino-review-pro' ),
        'public'             => true,
        'publicly_queryable' => true,
        'show_ui'            => true,
        'show_in_menu'       => true,
        'query_var'          => true,
        'rewrite'            => array( 'slug' => 'game' ),
        'capability_type'    => 'post',
        'has_archive'        => true,
        'hierarchical'       => false,
        'menu_position'      => 7,
        'menu_icon'          => 'dashicons-games',
        'supports'           => array( 'title', 'editor', 'author', 'thumbnail', 'excerpt', 'custom-fields' ),
        'show_in_rest'       => true,
    );

    register_post_type( 'game', $game_args );

    // Payment Method Post Type
    $payment_labels = array(
        'name'               => _x( 'Payment Methods', 'post type general name', 'casino-review-pro' ),
        'singular_name'      => _x( 'Payment Method', 'post type singular name', 'casino-review-pro' ),
        'menu_name'          => _x( 'Payment Methods', 'admin menu', 'casino-review-pro' ),
        'name_admin_bar'     => _x( 'Payment Method', 'add new on admin bar', 'casino-review-pro' ),
        'add_new'            => _x( 'Add New', 'payment method', 'casino-review-pro' ),
        'add_new_item'       => __( 'Add New Payment Method', 'casino-review-pro' ),
        'new_item'           => __( 'New Payment Method', 'casino-review-pro' ),
        'edit_item'          => __( 'Edit Payment Method', 'casino-review-pro' ),
        'view_item'          => __( 'View Payment Method', 'casino-review-pro' ),
        'all_items'          => __( 'All Payment Methods', 'casino-review-pro' ),
        'search_items'       => __( 'Search Payment Methods', 'casino-review-pro' ),
        'parent_item_colon'  => __( 'Parent Payment Methods:', 'casino-review-pro' ),
        'not_found'          => __( 'No payment methods found.', 'casino-review-pro' ),
        'not_found_in_trash' => __( 'No payment methods found in Trash.', 'casino-review-pro' )
    );

    $payment_args = array(
        'labels'             => $payment_labels,
        'description'        => __( 'Casino Payment Methods', 'casino-review-pro' ),
        'public'             => true,
        'publicly_queryable' => true,
        'show_ui'            => true,
        'show_in_menu'       => true,
        'query_var'          => true,
        'rewrite'            => array( 'slug' => 'payment-method' ),
        'capability_type'    => 'post',
        'has_archive'        => true,
        'hierarchical'       => false,
        'menu_position'      => 8,
        'menu_icon'          => 'dashicons-money',
        'supports'           => array( 'title', 'editor', 'author', 'thumbnail', 'excerpt', 'custom-fields' ),
        'show_in_rest'       => true,
    );

    register_post_type( 'payment_method', $payment_args );
}
add_action( 'init', 'casino_review_register_post_types' );

/**
 * Register Custom Taxonomies
 */
function casino_review_register_taxonomies() {
    // Casino Categories
    $casino_cat_labels = array(
        'name'              => _x( 'Casino Categories', 'taxonomy general name', 'casino-review-pro' ),
        'singular_name'     => _x( 'Casino Category', 'taxonomy singular name', 'casino-review-pro' ),
        'search_items'      => __( 'Search Casino Categories', 'casino-review-pro' ),
        'all_items'         => __( 'All Casino Categories', 'casino-review-pro' ),
        'parent_item'       => __( 'Parent Casino Category', 'casino-review-pro' ),
        'parent_item_colon' => __( 'Parent Casino Category:', 'casino-review-pro' ),
        'edit_item'         => __( 'Edit Casino Category', 'casino-review-pro' ),
        'update_item'       => __( 'Update Casino Category', 'casino-review-pro' ),
        'add_new_item'      => __( 'Add New Casino Category', 'casino-review-pro' ),
        'new_item_name'     => __( 'New Casino Category Name', 'casino-review-pro' ),
        'menu_name'         => __( 'Categories', 'casino-review-pro' ),
    );

    $casino_cat_args = array(
        'hierarchical'      => true,
        'labels'            => $casino_cat_labels,
        'show_ui'           => true,
        'show_admin_column' => true,
        'query_var'         => true,
        'rewrite'           => array( 'slug' => 'casino-category' ),
        'show_in_rest'      => true,
    );

    register_taxonomy( 'casino_category', array( 'casino' ), $casino_cat_args );

    // Game Categories
    $game_cat_labels = array(
        'name'              => _x( 'Game Categories', 'taxonomy general name', 'casino-review-pro' ),
        'singular_name'     => _x( 'Game Category', 'taxonomy singular name', 'casino-review-pro' ),
        'search_items'      => __( 'Search Game Categories', 'casino-review-pro' ),
        'all_items'         => __( 'All Game Categories', 'casino-review-pro' ),
        'parent_item'       => __( 'Parent Game Category', 'casino-review-pro' ),
        'parent_item_colon' => __( 'Parent Game Category:', 'casino-review-pro' ),
        'edit_item'         => __( 'Edit Game Category', 'casino-review-pro' ),
        'update_item'       => __( 'Update Game Category', 'casino-review-pro' ),
        'add_new_item'      => __( 'Add New Game Category', 'casino-review-pro' ),
        'new_item_name'     => __( 'New Game Category Name', 'casino-review-pro' ),
        'menu_name'         => __( 'Categories', 'casino-review-pro' ),
    );

    $game_cat_args = array(
        'hierarchical'      => true,
        'labels'            => $game_cat_labels,
        'show_ui'           => true,
        'show_admin_column' => true,
        'query_var'         => true,
        'rewrite'           => array( 'slug' => 'game-category' ),
        'show_in_rest'      => true,
    );

    register_taxonomy( 'game_category', array( 'game' ), $game_cat_args );

    // Game Providers
    $provider_labels = array(
        'name'              => _x( 'Game Providers', 'taxonomy general name', 'casino-review-pro' ),
        'singular_name'     => _x( 'Game Provider', 'taxonomy singular name', 'casino-review-pro' ),
        'search_items'      => __( 'Search Game Providers', 'casino-review-pro' ),
        'all_items'         => __( 'All Game Providers', 'casino-review-pro' ),
        'parent_item'       => __( 'Parent Game Provider', 'casino-review-pro' ),
        'parent_item_colon' => __( 'Parent Game Provider:', 'casino-review-pro' ),
        'edit_item'         => __( 'Edit Game Provider', 'casino-review-pro' ),
        'update_item'       => __( 'Update Game Provider', 'casino-review-pro' ),
        'add_new_item'      => __( 'Add New Game Provider', 'casino-review-pro' ),
        'new_item_name'     => __( 'New Game Provider Name', 'casino-review-pro' ),
        'menu_name'         => __( 'Providers', 'casino-review-pro' ),
    );

    $provider_args = array(
        'hierarchical'      => false,
        'labels'            => $provider_labels,
        'show_ui'           => true,
        'show_admin_column' => true,
        'query_var'         => true,
        'rewrite'           => array( 'slug' => 'game-provider' ),
        'show_in_rest'      => true,
    );

    register_taxonomy( 'game_provider', array( 'game' ), $provider_args );

    // Payment Method Types
    $payment_type_labels = array(
        'name'              => _x( 'Payment Types', 'taxonomy general name', 'casino-review-pro' ),
        'singular_name'     => _x( 'Payment Type', 'taxonomy singular name', 'casino-review-pro' ),
        'search_items'      => __( 'Search Payment Types', 'casino-review-pro' ),
        'all_items'         => __( 'All Payment Types', 'casino-review-pro' ),
        'parent_item'       => __( 'Parent Payment Type', 'casino-review-pro' ),
        'parent_item_colon' => __( 'Parent Payment Type:', 'casino-review-pro' ),
        'edit_item'         => __( 'Edit Payment Type', 'casino-review-pro' ),
        'update_item'       => __( 'Update Payment Type', 'casino-review-pro' ),
        'add_new_item'      => __( 'Add New Payment Type', 'casino-review-pro' ),
        'new_item_name'     => __( 'New Payment Type Name', 'casino-review-pro' ),
        'menu_name'         => __( 'Payment Types', 'casino-review-pro' ),
    );

    $payment_type_args = array(
        'hierarchical'      => true,
        'labels'            => $payment_type_labels,
        'show_ui'           => true,
        'show_admin_column' => true,
        'query_var'         => true,
        'rewrite'           => array( 'slug' => 'payment-type' ),
        'show_in_rest'      => true,
    );

    register_taxonomy( 'payment_type', array( 'payment_method' ), $payment_type_args );

    // Bonus Types
    $bonus_type_labels = array(
        'name'              => _x( 'Bonus Types', 'taxonomy general name', 'casino-review-pro' ),
        'singular_name'     => _x( 'Bonus Type', 'taxonomy singular name', 'casino-review-pro' ),
        'search_items'      => __( 'Search Bonus Types', 'casino-review-pro' ),
        'all_items'         => __( 'All Bonus Types', 'casino-review-pro' ),
        'parent_item'       => __( 'Parent Bonus Type', 'casino-review-pro' ),
        'parent_item_colon' => __( 'Parent Bonus Type:', 'casino-review-pro' ),
        'edit_item'         => __( 'Edit Bonus Type', 'casino-review-pro' ),
        'update_item'       => __( 'Update Bonus Type', 'casino-review-pro' ),
        'add_new_item'      => __( 'Add New Bonus Type', 'casino-review-pro' ),
        'new_item_name'     => __( 'New Bonus Type Name', 'casino-review-pro' ),
        'menu_name'         => __( 'Bonus Types', 'casino-review-pro' ),
    );

    $bonus_type_args = array(
        'hierarchical'      => true,
        'labels'            => $bonus_type_labels,
        'show_ui'           => true,
        'show_admin_column' => true,
        'query_var'         => true,
        'rewrite'           => array( 'slug' => 'bonus-type' ),
        'show_in_rest'      => true,
    );

    register_taxonomy( 'bonus_type', array( 'bonus' ), $bonus_type_args );
}
add_action( 'init', 'casino_review_register_taxonomies' );

/**
 * Register custom meta boxes for the casino post type
 */
function casino_review_add_meta_boxes() {
    // Casino Rating Meta Box
    add_meta_box(
        'casino_rating_meta',
        __( 'Casino Rating', 'casino-review-pro' ),
        'casino_review_rating_meta_callback',
        'casino',
        'side',
        'high'
    );

    // Casino Details Meta Box
    add_meta_box(
        'casino_details_meta',
        __( 'Casino Details', 'casino-review-pro' ),
        'casino_review_details_meta_callback',
        'casino',
        'normal',
        'high'
    );

    // Casino Bonuses Meta Box
    add_meta_box(
        'casino_bonuses_meta',
        __( 'Casino Bonuses', 'casino-review-pro' ),
        'casino_review_bonuses_meta_callback',
        'casino',
        'normal',
        'high'
    );

    // Casino Payment Methods Meta Box
    add_meta_box(
        'casino_payments_meta',
        __( 'Casino Payment Methods', 'casino-review-pro' ),
        'casino_review_payments_meta_callback',
        'casino',
        'normal',
        'high'
    );

    // Game Details Meta Box
    add_meta_box(
        'game_details_meta',
        __( 'Game Details', 'casino-review-pro' ),
        'casino_review_game_details_meta_callback',
        'game',
        'normal',
        'high'
    );

    // Bonus Details Meta Box
    add_meta_box(
        'bonus_details_meta',
        __( 'Bonus Details', 'casino-review-pro' ),
        'casino_review_bonus_details_meta_callback',
        'bonus',
        'normal',
        'high'
    );

    // Payment Method Details Meta Box
    add_meta_box(
        'payment_method_details_meta',
        __( 'Payment Method Details', 'casino-review-pro' ),
        'casino_review_payment_method_details_meta_callback',
        'payment_method',
        'normal',
        'high'
    );
}
add_action( 'add_meta_boxes', 'casino_review_add_meta_boxes' );

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
 * Save the Casino meta box data
 */
function casino_review_save_meta_box_data( $post_id ) {
    // Check if our nonce is set for rating meta
    if ( ! isset( $_POST['casino_review_rating_meta_nonce'] ) ) {
        return;
    }

    // Verify that the nonce is valid
    if ( ! wp_verify_nonce( $_POST['casino_review_rating_meta_nonce'], 'casino_review_rating_meta' ) ) {
        return;
    }

    // Check if this is an autosave
    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
        return;
    }

    // Check the user's permissions
    if ( isset( $_POST['post_type'] ) && 'casino' == $_POST['post_type'] ) {
        if ( ! current_user_can( 'edit_post', $post_id ) ) {
            return;
        }
    }

    // Save rating fields
    if ( isset( $_POST['casino_overall_rating'] ) ) {
        $overall_rating = floatval( $_POST['casino_overall_rating'] );
        if ( $overall_rating >= 0 && $overall_rating <= 10 ) {
            update_post_meta( $post_id, '_casino_overall_rating', $overall_rating );
        }
    }

    if ( isset( $_POST['casino_games_rating'] ) ) {
        $games_rating = floatval( $_POST['casino_games_rating'] );
        if ( $games_rating >= 0 && $games_rating <= 10 ) {
            update_post_meta( $post_id, '_casino_games_rating', $games_rating );
        }
    }

    if ( isset( $_POST['casino_bonuses_rating'] ) ) {
        $bonuses_rating = floatval( $_POST['casino_bonuses_rating'] );
        if ( $bonuses_rating >= 0 && $bonuses_rating <= 10 ) {
            update_post_meta( $post_id, '_casino_bonuses_rating', $bonuses_rating );
        }
    }

    if ( isset( $_POST['casino_support_rating'] ) ) {
        $support_rating = floatval( $_POST['casino_support_rating'] );
        if ( $support_rating >= 0 && $support_rating <= 10 ) {
            update_post_meta( $post_id, '_casino_support_rating', $support_rating );
        }
    }

    if ( isset( $_POST['casino_payments_rating'] ) ) {
        $payments_rating = floatval( $_POST['casino_payments_rating'] );
        if ( $payments_rating >= 0 && $payments_rating <= 10 ) {
            update_post_meta( $post_id, '_casino_payments_rating', $payments_rating );
        }
    }

    if ( isset( $_POST['casino_mobile_rating'] ) ) {
        $mobile_rating = floatval( $_POST['casino_mobile_rating'] );
        if ( $mobile_rating >= 0 && $mobile_rating <= 10 ) {
            update_post_meta( $post_id, '_casino_mobile_rating', $mobile_rating );
        }
    }

    // Check if details nonce is set
    if ( ! isset( $_POST['casino_review_details_meta_nonce'] ) ) {
        return;
    }

    // Verify that the details nonce is valid
    if ( ! wp_verify_nonce( $_POST['casino_review_details_meta_nonce'], 'casino_review_details_meta' ) ) {
        return;
    }

    // Save casino details fields
    if ( isset( $_POST['casino_website_url'] ) ) {
        update_post_meta( $post_id, '_casino_website_url', esc_url_raw( $_POST['casino_website_url'] ) );
    }

    if ( isset( $_POST['casino_established'] ) ) {
        update_post_meta( $post_id, '_casino_established', intval( $_POST['casino_established'] ) );
    }

    if ( isset( $_POST['casino_license'] ) ) {
        update_post_meta( $post_id, '_casino_license', sanitize_text_field( $_POST['casino_license'] ) );
    }

    if ( isset( $_POST['casino_owner'] ) ) {
        update_post_meta( $post_id, '_casino_owner', sanitize_text_field( $_POST['casino_owner'] ) );
    }

    if ( isset( $_POST['casino_software'] ) ) {
        update_post_meta( $post_id, '_casino_software', sanitize_text_field( $_POST['casino_software'] ) );
    }

    if ( isset( $_POST['casino_languages'] ) ) {
        update_post_meta( $post_id, '_casino_languages', sanitize_text_field( $_POST['casino_languages'] ) );
    }

    if ( isset( $_POST['casino_currencies'] ) ) {
        update_post_meta( $post_id, '_casino_currencies', sanitize_text_field( $_POST['casino_currencies'] ) );
    }

    if ( isset( $_POST['casino_min_deposit'] ) ) {
        update_post_meta( $post_id, '_casino_min_deposit', sanitize_text_field( $_POST['casino_min_deposit'] ) );
    }

    if ( isset( $_POST['casino_min_withdrawal'] ) ) {
        update_post_meta( $post_id, '_casino_min_withdrawal', sanitize_text_field( $_POST['casino_min_withdrawal'] ) );
    }

    if ( isset( $_POST['casino_withdrawal_time'] ) ) {
        update_post_meta( $post_id, '_casino_withdrawal_time', sanitize_text_field( $_POST['casino_withdrawal_time'] ) );
    }

    if ( isset( $_POST['casino_pros'] ) ) {
        update_post_meta( $post_id, '_casino_pros', sanitize_textarea_field( $_POST['casino_pros'] ) );
    }

    if ( isset( $_POST['casino_cons'] ) ) {
        update_post_meta( $post_id, '_casino_cons', sanitize_textarea_field( $_POST['casino_cons'] ) );
    }
}
add_action( 'save_post', 'casino_review_save_meta_box_data' );

/**
 * Add custom admin columns for Casino post type
 */
function casino_review_add_casino_columns( $columns ) {
    $new_columns = array();
    
    // Insert columns after title
    foreach ( $columns as $key => $value ) {
        $new_columns[ $key ] = $value;
        
        if ( $key === 'title' ) {
            $new_columns['casino_rating'] = __( 'Rating', 'casino-review-pro' );
            $new_columns['casino_established'] = __( 'Established', 'casino-review-pro' );
            $new_columns['casino_license'] = __( 'License', 'casino-review-pro' );
        }
    }
    
    return $new_columns;
}
add_filter( 'manage_casino_posts_columns', 'casino_review_add_casino_columns' );

/**
 * Display data in custom admin columns for Casino post type
 */
function casino_review_casino_column_data( $column, $post_id ) {
    switch ( $column ) {
        case 'casino_rating':
            $rating = get_post_meta( $post_id, '_casino_overall_rating', true );
            if ( $rating ) {
                echo '<div style="font-weight: bold; color: #ff5722;">' . esc_html( $rating ) . '/10</div>';
            } else {
                echo '—';
            }
            break;
            
        case 'casino_established':
            $established = get_post_meta( $post_id, '_casino_established', true );
            if ( $established ) {
                echo esc_html( $established );
            } else {
                echo '—';
            }
            break;
            
        case 'casino_license':
            $license = get_post_meta( $post_id, '_casino_license', true );
            if ( $license ) {
                echo esc_html( $license );
            } else {
                echo '—';
            }
            break;
    }
}
add_action( 'manage_casino_posts_custom_column', 'casino_review_casino_column_data', 10, 2 );

/**
 * Make custom columns sortable
 */
function casino_review_sortable_columns( $columns ) {
    $columns['casino_rating'] = 'casino_rating';
    $columns['casino_established'] = 'casino_established';
    $columns['casino_license'] = 'casino_license';
    return $columns;
}
add_filter( 'manage_edit-casino_sortable_columns', 'casino_review_sortable_columns' );

/**
 * Add order logic for custom sortable columns
 */
function casino_review_posts_orderby( $vars ) {
    if ( ! is_admin() ) {
        return $vars;
    }

    if ( isset( $vars['orderby'] ) && 'casino_rating' === $vars['orderby'] ) {
        $vars = array_merge(
            $vars,
            array(
                'meta_key' => '_casino_overall_rating',
                'orderby'  => 'meta_value_num',
            )
        );
    }

    if ( isset( $vars['orderby'] ) && 'casino_established' === $vars['orderby'] ) {
        $vars = array_merge(
            $vars,
            array(
                'meta_key' => '_casino_established',
                'orderby'  => 'meta_value_num',
            )
        );
    }

    return $vars;
}
add_filter( 'request', 'casino_review_posts_orderby' );

/**
 * Add shortcode for displaying casino comparison table
 */
function casino_review_comparison_shortcode( $atts ) {
    $atts = shortcode_atts(
        array(
            'casinos' => '',
            'compare' => 'rating,games,bonuses,support,payments,mobile',
            'title'   => __( 'Casino Comparison', 'casino-review-pro' ),
            'limit'   => 10,
        ),
        $atts,
        'casino_comparison'
    );

    // Get casino IDs from attributes or get top rated casinos
    if ( ! empty( $atts['casinos'] ) ) {
        $casino_ids = explode( ',', $atts['casinos'] );
    } else {
        // Get top rated casinos
        $args = array(
            'post_type'      => 'casino',
            'posts_per_page' => intval( $atts['limit'] ),
            'meta_key'       => '_casino_overall_rating',
            'orderby'        => 'meta_value_num',
            'order'          => 'DESC',
        );

        $casinos_query = new WP_Query( $args );
        $casino_ids = wp_list_pluck( $casinos_query->posts, 'ID' );
    }

    if ( empty( $casino_ids ) ) {
        return '<p>' . __( 'No casinos found for comparison.', 'casino-review-pro' ) . '</p>';
    }

    // Get comparison fields
    $compare_fields = explode( ',', $atts['compare'] );

    // Start building the output
    $output = '<div class="casino-comparison-wrapper">';
    $output .= '<h2 class="comparison-title">' . esc_html( $atts['title'] ) . '</h2>';
    $output .= '<div class="comparison-table-responsive">';
    $output .= '<table class="comparison-table">';
    
    // Table header
    $output .= '<thead><tr>';
    $output .= '<th>' . __( 'Casino', 'casino-review-pro' ) . '</th>';
    
    if ( in_array( 'rating', $compare_fields ) ) {
        $output .= '<th>' . __( 'Rating', 'casino-review-pro' ) . '</th>';
    }
    
    if ( in_array( 'games', $compare_fields ) ) {
        $output .= '<th>' . __( 'Games', 'casino-review-pro' ) . '</th>';
    }
    
    if ( in_array( 'bonuses', $compare_fields ) ) {
        $output .= '<th>' . __( 'Bonuses', 'casino-review-pro' ) . '</th>';
    }
    
    if ( in_array( 'support', $compare_fields ) ) {
        $output .= '<th>' . __( 'Support', 'casino-review-pro' ) . '</th>';
    }
    
    if ( in_array( 'payments', $compare_fields ) ) {
        $output .= '<th>' . __( 'Payments', 'casino-review-pro' ) . '</th>';
    }
    
    if ( in_array( 'mobile', $compare_fields ) ) {
        $output .= '<th>' . __( 'Mobile', 'casino-review-pro' ) . '</th>';
    }
    
    $output .= '<th>' . __( 'Action', 'casino-review-pro' ) . '</th>';
    $output .= '</tr></thead>';

    // Table body
    $output .= '<tbody>';
    
    foreach ( $casino_ids as $casino_id ) {
        $casino = get_post( $casino_id );
        
        if ( ! $casino || 'publish' !== $casino->post_status ) {
            continue;
        }
        
        $output .= '<tr>';
        
        // Casino name and logo
        $output .= '<td>';
        if ( has_post_thumbnail( $casino_id ) ) {
            $output .= '<div class="casino-logo-small">' . get_the_post_thumbnail( $casino_id, 'casino-thumbnail' ) . '</div>';
        }
        $output .= '<div class="casino-name"><a href="' . get_permalink( $casino_id ) . '">' . get_the_title( $casino_id ) . '</a></div>';
        $output .= '</td>';
        
        // Overall rating
        if ( in_array( 'rating', $compare_fields ) ) {
            $rating = get_post_meta( $casino_id, '_casino_overall_rating', true );
            $output .= '<td><div class="rating-score">' . esc_html( $rating ) . '</div></td>';
        }
        
        // Games rating
        if ( in_array( 'games', $compare_fields ) ) {
            $games_rating = get_post_meta( $casino_id, '_casino_games_rating', true );
            $output .= '<td><div class="rating-score">' . esc_html( $games_rating ) . '</div></td>';
        }
        
        // Bonuses rating
        if ( in_array( 'bonuses', $compare_fields ) ) {
            $bonuses_rating = get_post_meta( $casino_id, '_casino_bonuses_rating', true );
            $output .= '<td><div class="rating-score">' . esc_html( $bonuses_rating ) . '</div></td>';
        }
        
        // Support rating
        if ( in_array( 'support', $compare_fields ) ) {
            $support_rating = get_post_meta( $casino_id, '_casino_support_rating', true );
            $output .= '<td><div class="rating-score">' . esc_html( $support_rating ) . '</div></td>';
        }
        
        // Payments rating
        if ( in_array( 'payments', $compare_fields ) ) {
            $payments_rating = get_post_meta( $casino_id, '_casino_payments_rating', true );
            $output .= '<td><div class="rating-score">' . esc_html( $payments_rating ) . '</div></td>';
        }
        
        // Mobile rating
        if ( in_array( 'mobile', $compare_fields ) ) {
            $mobile_rating = get_post_meta( $casino_id, '_casino_mobile_rating', true );
            $output .= '<td><div class="rating-score">' . esc_html( $mobile_rating ) . '</div></td>';
        }
        
        // Action button (Visit / Review)
        $website_url = get_post_meta( $casino_id, '_casino_website_url', true );
        $output .= '<td class="casino-actions">';
        $output .= '<a href="' . get_permalink( $casino_id ) . '" class="btn btn-sm btn-outline">' . __( 'Review', 'casino-review-pro' ) . '</a>';
        if ( $website_url ) {
            $output .= ' <a href="' . esc_url( $website_url ) . '" class="btn btn-sm btn-primary" target="_blank">' . __( 'Visit', 'casino-review-pro' ) . '</a>';
        }
        $output .= '</td>';
        
        $output .= '</tr>';
    }
    
    $output .= '</tbody>';
    $output .= '</table>';
    $output .= '</div>'; // .comparison-table-responsive
    $output .= '</div>'; // .casino-comparison-wrapper

    return $output;
}
add_shortcode( 'casino_comparison', 'casino_review_comparison_shortcode' );

/**
 * Add shortcode for displaying casino list
 */
function casino_review_list_shortcode( $atts ) {
    $atts = shortcode_atts(
        array(
            'category' => '',
            'limit'    => 10,
            'orderby'  => 'rating', // rating, date, title
            'order'    => 'DESC',
            'layout'   => 'list', // list, grid
            'title'    => __( 'Top Online Casinos', 'casino-review-pro' ),
        ),
        $atts,
        'casino_list'
    );

    // Set up the query arguments
    $args = array(
        'post_type'      => 'casino',
        'posts_per_page' => intval( $atts['limit'] ),
        'order'          => $atts['order'],
    );

    // Add category filter if provided
    if ( ! empty( $atts['category'] ) ) {
        $args['tax_query'] = array(
            array(
                'taxonomy' => 'casino_category',
                'field'    => 'slug',
                'terms'    => explode( ',', $atts['category'] ),
            ),
        );
    }

    // Set orderby parameter
    switch ( $atts['orderby'] ) {
        case 'rating':
            $args['meta_key'] = '_casino_overall_rating';
            $args['orderby']  = 'meta_value_num';
            break;
        case 'date':
            $args['orderby'] = 'date';
            break;
        case 'title':
            $args['orderby'] = 'title';
            break;
        default:
            $args['meta_key'] = '_casino_overall_rating';
            $args['orderby']  = 'meta_value_num';
    }

    // Get casinos
    $casinos_query = new WP_Query( $args );

    if ( ! $casinos_query->have_posts() ) {
        return '<p>' . __( 'No casinos found.', 'casino-review-pro' ) . '</p>';
    }

    // Start building the output
    $output = '<div class="casino-list-wrapper">';
    
    if ( ! empty( $atts['title'] ) ) {
        $output .= '<h2 class="casino-list-title">' . esc_html( $atts['title'] ) . '</h2>';
    }
    
    // Choose layout
    $layout_class = ( 'grid' === $atts['layout'] ) ? 'casino-grid' : 'casino-list';
    
    $output .= '<div class="' . $layout_class . '">';
    
    $counter = 1;
    while ( $casinos_query->have_posts() ) {
        $casinos_query->the_post();
        $casino_id = get_the_ID();
        
        // Get casino meta data
        $rating = get_post_meta( $casino_id, '_casino_overall_rating', true );
        $website_url = get_post_meta( $casino_id, '_casino_website_url', true );
        $established = get_post_meta( $casino_id, '_casino_established', true );
        $min_deposit = get_post_meta( $casino_id, '_casino_min_deposit', true );
        $withdrawal_time = get_post_meta( $casino_id, '_casino_withdrawal_time', true );
        
        // Get pros and cons
        $pros = get_post_meta( $casino_id, '_casino_pros', true );
        $cons = get_post_meta( $casino_id, '_casino_cons', true );
        
        $pros_array = ! empty( $pros ) ? explode( "\n", $pros ) : array();
        $cons_array = ! empty( $cons ) ? explode( "\n", $cons ) : array();
        
        // Build casino card
        $output .= '<div class="casino-card">';
        
        // Add rank number for list layout
        if ( 'grid' !== $atts['layout'] ) {
            $output .= '<div class="casino-rank">' . $counter . '</div>';
        }
        
        // Logo
        $output .= '<div class="casino-logo-wrapper">';
        if ( has_post_thumbnail() ) {
            $output .= get_the_post_thumbnail( $casino_id, 'casino-logo', array( 'class' => 'casino-logo' ) );
        } else {
            $output .= '<div class="casino-logo-placeholder">' . get_the_title() . '</div>';
        }
        $output .= '</div>';
        
        // Content
        $output .= '<div class="casino-content">';
        $output .= '<h3 class="casino-title"><a href="' . get_permalink() . '">' . get_the_title() . '</a></h3>';
        
        // Rating
        if ( $rating ) {
            $output .= '<div class="rating-box">';
            $output .= '<div class="rating-score">' . esc_html( $rating ) . '</div>';
            $output .= '<div class="rating-text">';
            
            // Generate star rating (1-5 scale converted from 1-10)
            $stars = round( $rating / 2, 1 );
            $output .= '<div class="rating-stars">';
            for ( $i = 1; $i <= 5; $i++ ) {
                if ( $i <= floor( $stars ) ) {
                    $output .= '<span class="star filled"><i class="fa-solid fa-star"></i></span>';
                } elseif ( $i - $stars < 1 && $i - $stars > 0 ) {
                    $output .= '<span class="star filled"><i class="fa-solid fa-star-half-stroke"></i></span>';
                } else {
                    $output .= '<span class="star"><i class="fa-regular fa-star"></i></span>';
                }
            }
            $output .= '</div>';
            
            $output .= '<div class="rating-title">' . __( 'Overall Rating', 'casino-review-pro' ) . '</div>';
            $output .= '</div>'; // .rating-text
            $output .= '</div>'; // .rating-box
        }
        
        // Casino meta information
        $output .= '<div class="casino-meta">';
        
        if ( $established ) {
            $output .= '<div class="meta-item"><i class="fa-solid fa-calendar-days"></i> ' . __( 'Established:', 'casino-review-pro' ) . ' ' . esc_html( $established ) . '</div>';
        }
        
        if ( $min_deposit ) {
            $output .= '<div class="meta-item"><i class="fa-solid fa-money-bill-1"></i> ' . __( 'Min. Deposit:', 'casino-review-pro' ) . ' ' . esc_html( $min_deposit ) . '</div>';
        }
        
        if ( $withdrawal_time ) {
            $output .= '<div class="meta-item"><i class="fa-solid fa-clock"></i> ' . __( 'Withdrawal Time:', 'casino-review-pro' ) . ' ' . esc_html( $withdrawal_time ) . '</div>';
        }
        
        $output .= '</div>'; // .casino-meta
        
        // Pros and Cons (show only in list layout)
        if ( 'grid' !== $atts['layout'] && ( ! empty( $pros_array ) || ! empty( $cons_array ) ) ) {
            $output .= '<div class="casino-pros-cons">';
            
            if ( ! empty( $pros_array ) ) {
                $output .= '<div class="casino-pros-list">';
                $output .= '<h4>' . __( 'Pros', 'casino-review-pro' ) . '</h4>';
                $output .= '<ul>';
                foreach ( array_slice( $pros_array, 0, 3 ) as $pro ) {
                    if ( ! empty( trim( $pro ) ) ) {
                        $output .= '<li>' . esc_html( trim( $pro ) ) . '</li>';
                    }
                }
                $output .= '</ul>';
                $output .= '</div>';
            }
            
            if ( ! empty( $cons_array ) ) {
                $output .= '<div class="casino-cons-list">';
                $output .= '<h4>' . __( 'Cons', 'casino-review-pro' ) . '</h4>';
                $output .= '<ul>';
                foreach ( array_slice( $cons_array, 0, 3 ) as $con ) {
                    if ( ! empty( trim( $con ) ) ) {
                        $output .= '<li>' . esc_html( trim( $con ) ) . '</li>';
                    }
                }
                $output .= '</ul>';
                $output .= '</div>';
            }
            
            $output .= '</div>'; // .casino-pros-cons
        }
        
        // Action buttons
        $output .= '<div class="casino-actions">';
        $output .= '<a href="' . get_permalink() . '" class="btn btn-outline">' . __( 'Read Review', 'casino-review-pro' ) . '</a>';
        
        if ( $website_url ) {
            $output .= '<a href="' . esc_url( $website_url ) . '" class="btn btn-primary" target="_blank">' . __( 'Visit Casino', 'casino-review-pro' ) . '</a>';
        }
        
        $output .= '</div>'; // .casino-actions
        
        $output .= '</div>'; // .casino-content
        $output .= '</div>'; // .casino-card
        
        $counter++;
    }
    
    $output .= '</div>'; // .casino-list or .casino-grid
    $output .= '</div>'; // .casino-list-wrapper
    
    wp_reset_postdata();
    
    return $output;
}
add_shortcode( 'casino_list', 'casino_review_list_shortcode' );

/**
 * Add custom widget for Popular Casinos
 */
class Casino_Review_Popular_Casinos_Widget extends WP_Widget {

    public function __construct() {
        parent::__construct(
            'casino_review_popular_casinos',
            __( 'Popular Casinos', 'casino-review-pro' ),
            array(
                'description' => __( 'Display a list of popular casinos', 'casino-review-pro' ),
            )
        );
    }

    public function widget( $args, $instance ) {
        $title = ! empty( $instance['title'] ) ? $instance['title'] : __( 'Popular Casinos', 'casino-review-pro' );
        $number = ! empty( $instance['number'] ) ? absint( $instance['number'] ) : 5;
        
        $title = apply_filters( 'widget_title', $title, $instance, $this->id_base );
        
        echo $args['before_widget'];
        
        if ( $title ) {
            echo $args['before_title'] . $title . $args['after_title'];
        }
        
        // Get popular casinos
        $casinos_query = new WP_Query( array(
            'post_type'      => 'casino',
            'posts_per_page' => $number,
            'meta_key'       => '_casino_overall_rating',
            'orderby'        => 'meta_value_num',
            'order'          => 'DESC',
        ) );
        
        if ( $casinos_query->have_posts() ) {
            echo '<div class="popular-casinos-widget">';
            
            while ( $casinos_query->have_posts() ) {
                $casinos_query->the_post();
                $casino_id = get_the_ID();
                
                // Get casino data
                $rating = get_post_meta( $casino_id, '_casino_overall_rating', true );
                $website_url = get_post_meta( $casino_id, '_casino_website_url', true );
                
                echo '<div class="casino-item">';
                
                // Logo
                if ( has_post_thumbnail() ) {
                    echo '<img src="' . get_the_post_thumbnail_url( $casino_id, 'casino-thumbnail' ) . '" alt="' . get_the_title() . '" class="casino-logo-small">';
                }
                
                echo '<div class="casino-info">';
                echo '<div class="casino-name"><a href="' . get_permalink() . '">' . get_the_title() . '</a></div>';
                
                if ( $rating ) {
                    echo '<div class="casino-rating">';
                    // Generate star rating (1-5 scale converted from 1-10)
                    $stars = round( $rating / 2, 1 );
                    for ( $i = 1; $i <= 5; $i++ ) {
                        if ( $i <= floor( $stars ) ) {
                            echo '<i class="fa-solid fa-star"></i>';
                        } elseif ( $i - $stars < 1 && $i - $stars > 0 ) {
                            echo '<i class="fa-solid fa-star-half-stroke"></i>';
                        } else {
                            echo '<i class="fa-regular fa-star"></i>';
                        }
                    }
                    echo ' <span class="rating-text">' . $rating . '/10</span>';
                    echo '</div>';
                }
                
                echo '</div>'; // .casino-info
                
                echo '</div>'; // .casino-item
            }
            
            echo '</div>'; // .popular-casinos-widget
            
            wp_reset_postdata();
        } else {
            echo '<p>' . __( 'No casinos found.', 'casino-review-pro' ) . '</p>';
        }
        
        echo $args['after_widget'];
    }

    public function form( $instance ) {
        $title = ! empty( $instance['title'] ) ? $instance['title'] : __( 'Popular Casinos', 'casino-review-pro' );
        $number = ! empty( $instance['number'] ) ? absint( $instance['number'] ) : 5;
        ?>
        <p>
            <label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_html_e( 'Title:', 'casino-review-pro' ); ?></label>
            <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">
        </p>
        <p>
            <label for="<?php echo esc_attr( $this->get_field_id( 'number' ) ); ?>"><?php esc_html_e( 'Number of casinos to show:', 'casino-review-pro' ); ?></label>
            <input class="tiny-text" id="<?php echo esc_attr( $this->get_field_id( 'number' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'number' ) ); ?>" type="number" step="1" min="1" value="<?php echo esc_attr( $number ); ?>" size="3">
        </p>
        <?php
    }

    public function update( $new_instance, $old_instance ) {
        $instance = array();
        $instance['title'] = ( ! empty( $new_instance['title'] ) ) ? sanitize_text_field( $new_instance['title'] ) : '';
        $instance['number'] = ( ! empty( $new_instance['number'] ) ) ? absint( $new_instance['number'] ) : 5;
        
        return $instance;
    }
}

/**
 * Register Custom Widgets
 */
function casino_review_register_widgets() {
    register_widget( 'Casino_Review_Popular_Casinos_Widget' );
}
add_action( 'widgets_init', 'casino_review_register_widgets' );
