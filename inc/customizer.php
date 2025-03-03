<?php
/**
 * Casino Review Pro Theme Customizer
 *
 * @package Casino_Review_Pro
 */

/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function casino_review_customize_register( $wp_customize ) {
	$wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';
	$wp_customize->get_setting( 'header_textcolor' )->transport = 'postMessage';

	if ( isset( $wp_customize->selective_refresh ) ) {
		$wp_customize->selective_refresh->add_partial(
			'blogname',
			array(
				'selector'        => '.site-title a',
				'render_callback' => 'casino_review_customize_partial_blogname',
			)
		);
		$wp_customize->selective_refresh->add_partial(
			'blogdescription',
			array(
				'selector'        => '.site-description',
				'render_callback' => 'casino_review_customize_partial_blogdescription',
			)
		);
	}
	
	// Theme Options Panel
	$wp_customize->add_panel( 'casino_review_theme_options', array(
		'title'    => __( 'Theme Options', 'casino-review-pro' ),
		'priority' => 130,
	) );
	
	// Hero Section
	$wp_customize->add_section( 'casino_review_hero_section', array(
		'title'    => __( 'Hero Section', 'casino-review-pro' ),
		'panel'    => 'casino_review_theme_options',
		'priority' => 10,
	) );
	
	$wp_customize->add_setting( 'casino_review_hero_title', array(
		'default'           => __( 'Find the Best Online Casinos', 'casino-review-pro' ),
		'sanitize_callback' => 'sanitize_text_field',
		'transport'         => 'postMessage',
	) );
	
	$wp_customize->add_control( 'casino_review_hero_title', array(
		'label'    => __( 'Hero Title', 'casino-review-pro' ),
		'section'  => 'casino_review_hero_section',
		'type'     => 'text',
	) );
	
	$wp_customize->add_setting( 'casino_review_hero_description', array(
		'default'           => __( 'Expert Reviews, Exclusive Bonuses & Top-Rated Casinos', 'casino-review-pro' ),
		'sanitize_callback' => 'sanitize_text_field',
		'transport'         => 'postMessage',
	) );
	
	$wp_customize->add_control( 'casino_review_hero_description', array(
		'label'    => __( 'Hero Description', 'casino-review-pro' ),
		'section'  => 'casino_review_hero_section',
		'type'     => 'text',
	) );
	
	$wp_customize->add_setting( 'casino_review_hero_background', array(
		'default'           => '',
		'sanitize_callback' => 'esc_url_raw',
	) );
	
	$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'casino_review_hero_background', array(
		'label'    => __( 'Hero Background Image', 'casino-review-pro' ),
		'section'  => 'casino_review_hero_section',
	) ) );
	
	// Colors Section
	$wp_customize->add_section( 'casino_review_colors', array(
		'title'    => __( 'Theme Colors', 'casino-review-pro' ),
		'panel'    => 'casino_review_theme_options',
		'priority' => 20,
	) );
	
	$wp_customize->add_setting( 'casino_review_primary_color', array(
		'default'           => '#ff5722',
		'sanitize_callback' => 'sanitize_hex_color',
	) );
	
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'casino_review_primary_color', array(
		'label'    => __( 'Primary Color', 'casino-review-pro' ),
		'section'  => 'casino_review_colors',
	) ) );
	
	$wp_customize->add_setting( 'casino_review_secondary_color', array(
		'default'           => '#3498db',
		'sanitize_callback' => 'sanitize_hex_color',
	) );
	
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'casino_review_secondary_color', array(
		'label'    => __( 'Secondary Color', 'casino-review-pro' ),
		'section'  => 'casino_review_colors',
	) ) );
	
	$wp_customize->add_setting( 'casino_review_dark_mode', array(
		'default'           => false,
		'sanitize_callback' => 'casino_review_sanitize_checkbox',
	) );
	
	$wp_customize->add_control( 'casino_review_dark_mode', array(
		'label'    => __( 'Enable Dark Mode', 'casino-review-pro' ),
		'section'  => 'casino_review_colors',
		'type'     => 'checkbox',
	) );
	
	// Footer Section
	$wp_customize->add_section( 'casino_review_footer', array(
		'title'    => __( 'Footer Options', 'casino-review-pro' ),
		'panel'    => 'casino_review_theme_options',
		'priority' => 30,
	) );
	
	$wp_customize->add_setting( 'casino_review_footer_text', array(
		'default'           => '',
		'sanitize_callback' => 'wp_kses_post',
	) );
	
	$wp_customize->add_control( 'casino_review_footer_text', array(
		'label'    => __( 'Footer Text', 'casino-review-pro' ),
		'section'  => 'casino_review_footer',
		'type'     => 'textarea',
	) );
	
	$wp_customize->add_setting( 'casino_review_responsible_gambling_text', array(
		'default'           => __( 'Please gamble responsibly. Only for adults 18+.', 'casino-review-pro' ),
		'sanitize_callback' => 'sanitize_text_field',
	) );
	
	$wp_customize->add_control( 'casino_review_responsible_gambling_text', array(
		'label'    => __( 'Responsible Gambling Text', 'casino-review-pro' ),
		'section'  => 'casino_review_footer',
		'type'     => 'text',
	) );
	
	// Payment Methods
	$wp_customize->add_setting( 'casino_review_payment_methods', array(
		'default'           => array(),
		'sanitize_callback' => 'casino_review_sanitize_payment_methods',
	) );
	
	$wp_customize->add_control( new Casino_Review_Payment_Methods_Control( $wp_customize, 'casino_review_payment_methods', array(
		'label'    => __( 'Payment Method Logos', 'casino-review-pro' ),
		'section'  => 'casino_review_footer',
		'type'     => 'payment_methods',
	) ) );
	
	// Social Media Section
	$wp_customize->add_section( 'casino_review_social', array(
		'title'    => __( 'Social Media', 'casino-review-pro' ),
		'panel'    => 'casino_review_theme_options',
		'priority' => 40,
	) );
	
	$social_networks = array(
		'facebook'  => __( 'Facebook', 'casino-review-pro' ),
		'twitter'   => __( 'Twitter', 'casino-review-pro' ),
		'instagram' => __( 'Instagram', 'casino-review-pro' ),
		'linkedin'  => __( 'LinkedIn', 'casino-review-pro' ),
		'youtube'   => __( 'YouTube', 'casino-review-pro' ),
		'pinterest' => __( 'Pinterest', 'casino-review-pro' ),
	);
	
	foreach ( $social_networks as $network => $label ) {
		$wp_customize->add_setting( 'casino_review_social_' . $network, array(
			'default'           => '',
			'sanitize_callback' => 'esc_url_raw',
		) );
		
		$wp_customize->add_control( 'casino_review_social_' . $network, array(
			'label'    => $label,
			'section'  => 'casino_review_social',
			'type'     => 'url',
		) );
	}
	
	// Casino Display Options
	$wp_customize->add_section( 'casino_review_casino_options', array(
		'title'    => __( 'Casino Display Options', 'casino-review-pro' ),
		'panel'    => 'casino_review_theme_options',
		'priority' => 50,
	) );
	
	$wp_customize->add_setting( 'casino_review_casino_per_page', array(
		'default'           => 10,
		'sanitize_callback' => 'absint',
	) );
	
	$wp_customize->add_control( 'casino_review_casino_per_page', array(
		'label'    => __( 'Casinos Per Page', 'casino-review-pro' ),
		'section'  => 'casino_review_casino_options',
		'type'     => 'number',
		'input_attrs' => array(
			'min' => 1,
			'max' => 50,
			'step' => 1,
		),
	) );
	
	$wp_customize->add_setting( 'casino_review_casino_layout', array(
		'default'           => 'list',
		'sanitize_callback' => 'casino_review_sanitize_select',
	) );
	
	$wp_customize->add_control( 'casino_review_casino_layout', array(
		'label'    => __( 'Default Casino Layout', 'casino-review-pro' ),
		'section'  => 'casino_review_casino_options',
		'type'     => 'select',
		'choices'  => array(
			'list' => __( 'List View', 'casino-review-pro' ),
			'grid' => __( 'Grid View', 'casino-review-pro' ),
		),
	) );
	
	$wp_customize->add_setting( 'casino_review_show_pros_cons', array(
		'default'           => true,
		'sanitize_callback' => 'casino_review_sanitize_checkbox',
	) );
	
	$wp_customize->add_control( 'casino_review_show_pros_cons', array(
		'label'    => __( 'Show Pros & Cons', 'casino-review-pro' ),
		'section'  => 'casino_review_casino_options',
		'type'     => 'checkbox',
	) );
}
add_action( 'customize_register', 'casino_review_customize_register' );

/**
 * Render the site title for the selective refresh partial.
 *
 * @return void
 */
function casino_review_customize_partial_blogname() {
	bloginfo( 'name' );
}

/**
 * Render the site tagline for the selective refresh partial.
 *
 * @return void
 */
function casino_review_customize_partial_blogdescription() {
	bloginfo( 'description' );
}

/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
function casino_review_customize_preview_js() {
	wp_enqueue_script( 'casino-review-customizer', get_template_directory_uri() . '/assets/js/customizer.js', array( 'customize-preview' ), CASINO_REVIEW_VERSION, true );
}
add_action( 'customize_preview_init', 'casino_review_customize_preview_js' );

/**
 * Custom control for payment methods
 */
if ( class_exists( 'WP_Customize_Control' ) ) {
	class Casino_Review_Payment_Methods_Control extends WP_Customize_Control {
		public $type = 'payment_methods';
		
		public function render_content() {
			$payment_methods = $this->value();
			
			if ( ! is_array( $payment_methods ) ) {
				$payment_methods = array();
			}
			?>
			<label>
				<?php if ( ! empty( $this->label ) ) : ?>
					<span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
				<?php endif; ?>
				
				<?php if ( ! empty( $this->description ) ) : ?>
					<span class="description customize-control-description"><?php echo esc_html( $this->description ); ?></span>
				<?php endif; ?>
				
				<div class="payment-methods-control">
					<div class="payment-methods-list">
						<?php foreach ( $payment_methods as $index => $image_url ) : ?>
							<div class="payment-method-item">
								<img src="<?php echo esc_url( $image_url ); ?>" alt="">
								<input type="hidden" name="<?php echo esc_attr( $this->id ); ?>[]" value="<?php echo esc_url( $image_url ); ?>">
								<button class="button-link payment-method-remove"><?php esc_html_e( 'Remove', 'casino-review-pro' ); ?></button>
							</div>
						<?php endforeach; ?>
					</div>
					
					<button class="button payment-method-add"><?php esc_html_e( 'Add Payment Method Logo', 'casino-review-pro' ); ?></button>
				</div>
			</label>
			
			<script>
				jQuery(document).ready(function($) {
					var frame;
					
					$('.payment-method-add').on('click', function(e) {
						e.preventDefault();
						
						if ( frame ) {
							frame.open();
							return;
						}
						
						frame = wp.media({
							title: '<?php esc_html_e( 'Select or Upload Payment Method Logo', 'casino-review-pro' ); ?>',
							button: {
								text: '<?php esc_html_e( 'Add Logo', 'casino-review-pro' ); ?>'
							},
							multiple: false
						});
						
						frame.on('select', function() {
							var attachment = frame.state().get('selection').first().toJSON();
							var item = $('<div class="payment-method-item"></div>');
							item.append('<img src="' + attachment.url + '" alt="">');
							item.append('<input type="hidden" name="<?php echo esc_attr( $this->id ); ?>[]" value="' + attachment.url + '">');
							item.append('<button class="button-link payment-method-remove"><?php esc_html_e( 'Remove', 'casino-review-pro' ); ?></button>');
							
							$('.payment-methods-list').append(item);
							updateValue();
						});
						
						frame.open();
					});
					
					$(document).on('click', '.payment-method-remove', function(e) {
						e.preventDefault();
						$(this).parent().remove();
						updateValue();
					});
					
					function updateValue() {
						var values = [];
						
						$('.payment-methods-list input').each(function() {
							values.push($(this).val());
						});
						
						wp.customize('<?php echo esc_js( $this->id ); ?>').set(values);
					}
				});
			</script>
			
			<style>
				.payment-methods-list {
					margin-bottom: 10px;
				}
				
				.payment-method-item {
					display: flex;
					align-items: center;
					margin-bottom: 10px;
					padding: 5px;
					border: 1px solid #ddd;
					background-color: #f9f9f9;
				}
				
				.payment-method-item img {
					max-width: 100px;
					max-height: 50px;
					margin-right: 10px;
				}
			</style>
			<?php
		}
	}
}

/**
 * Sanitize checkbox
 */
function casino_review_sanitize_checkbox( $input ) {
	return ( isset( $input ) && true == $input ) ? true : false;
}

/**
 * Sanitize select
 */
function casino_review_sanitize_select( $input, $setting ) {
	$choices = $setting->manager->get_control( $setting->id )->choices;
	
	return ( array_key_exists( $input, $choices ) ? $input : $setting->default );
}

/**
 * Sanitize payment methods
 */
function casino_review_sanitize_payment_methods( $input ) {
	$output = array();
	
	if ( is_array( $input ) ) {
		foreach ( $input as $url ) {
			$output[] = esc_url_raw( $url );
		}
	}
	
	return $output;
}

/**
 * Generates CSS from customizer settings
 */
function casino_review_customizer_css() {
	$primary_color = get_theme_mod( 'casino_review_primary_color', '#ff5722' );
	$secondary_color = get_theme_mod( 'casino_review_secondary_color', '#3498db' );
	$hero_background = get_theme_mod( 'casino_review_hero_background', '' );
	
	$css = '';
	
	if ( $primary_color != '#ff5722' ) {
		$css .= ':root { --primary: ' . esc_attr( $primary_color ) . '; --primary-dark: ' . esc_attr( casino_review_darken_color( $primary_color, 10 ) ) . '; }';
	}
	
	if ( $secondary_color != '#3498db' ) {
		$css .= ':root { --secondary: ' . esc_attr( $secondary_color ) . '; --secondary-dark: ' . esc_attr( casino_review_darken_color( $secondary_color, 10 ) ) . '; }';
	}
	
	if ( $hero_background ) {
		$css .= '.hero-section { background-image: url(' . esc_url( $hero_background ) . '); background-size: cover; background-position: center; }';
	}
	
	if ( ! empty( $css ) ) {
		echo '<style type="text/css">' . $css . '</style>';
	}
}
add_action( 'wp_head', 'casino_review_customizer_css' );

/**
 * Darken a color
 */
function casino_review_darken_color( $hex, $amount ) {
	$hex = ltrim( $hex, '#' );
	
	$r = hexdec( substr( $hex, 0, 2 ) );
	$g = hexdec( substr( $hex, 2, 2 ) );
	$b = hexdec( substr( $hex, 4, 2 ) );
	
	$r = max( 0, min( 255, $r - $amount ) );
	$g = max( 0, min( 255, $g - $amount ) );
	$b = max( 0, min( 255, $b - $amount ) );
	
	return sprintf( '#%02x%02x%02x', $r, $g, $b );
}
