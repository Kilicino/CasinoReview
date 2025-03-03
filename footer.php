<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Casino_Review_Pro
 */

?>

	<footer id="colophon" class="site-footer">
		<div class="container">
			<div class="footer-widgets">
				<?php if ( is_active_sidebar( 'footer-1' ) ) : ?>
					<div class="footer-widget-area">
						<?php dynamic_sidebar( 'footer-1' ); ?>
					</div>
				<?php endif; ?>
				
				<?php if ( is_active_sidebar( 'footer-2' ) ) : ?>
					<div class="footer-widget-area">
						<?php dynamic_sidebar( 'footer-2' ); ?>
					</div>
				<?php endif; ?>
				
				<?php if ( is_active_sidebar( 'footer-3' ) ) : ?>
					<div class="footer-widget-area">
						<?php dynamic_sidebar( 'footer-3' ); ?>
					</div>
				<?php endif; ?>
				
				<?php if ( is_active_sidebar( 'footer-4' ) ) : ?>
					<div class="footer-widget-area">
						<?php dynamic_sidebar( 'footer-4' ); ?>
					</div>
				<?php endif; ?>
			</div><!-- .footer-widgets -->
			
			<div class="footer-bottom">
				<div class="copyright">
					<?php
					$site_name = get_bloginfo( 'name' );
					/* translators: %1$s: current year, %2$s: site name */
					printf( esc_html__( '&copy; %1$s %2$s. All Rights Reserved.', 'casino-review-pro' ), date_i18n( 'Y' ), esc_html( $site_name ) );
					?>
				</div>
				
				<div class="footer-links">
					<?php
					wp_nav_menu(
						array(
							'theme_location' => 'footer',
							'menu_id'        => 'footer-menu',
							'depth'          => 1,
							'container'      => false,
							'fallback_cb'    => false,
						)
					);
					?>
				</div>
				
				<div class="responsible-gambling">
					<p><?php esc_html_e( 'Please gamble responsibly. Only for adults 18+.', 'casino-review-pro' ); ?></p>
				</div>
				
				<div class="payment-methods-footer">
					<?php
					// Display payment method logos
					$payment_methods = get_theme_mod( 'casino_review_payment_methods', array() );
					if ( ! empty( $payment_methods ) ) :
					?>
						<div class="payment-methods">
							<?php foreach ( $payment_methods as $method ) : ?>
								<div class="payment-method">
									<img src="<?php echo esc_url( $method ); ?>" alt="<?php esc_attr_e( 'Payment Method', 'casino-review-pro' ); ?>">
								</div>
							<?php endforeach; ?>
						</div>
					<?php endif; ?>
				</div>
			</div><!-- .footer-bottom -->
		</div><!-- .container -->
	</footer><!-- #colophon -->
</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>
