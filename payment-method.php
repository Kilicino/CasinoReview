<?php
/**
 * The template for displaying single payment method posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package Casino_Review_Pro
 */

get_header();

while ( have_posts() ) :
	the_post();
	
	// Get payment method meta data
	$payment_id = get_the_ID();
	$deposit_time = get_post_meta( $payment_id, '_payment_deposit_time', true );
	$withdrawal_time = get_post_meta( $payment_id, '_payment_withdrawal_time', true );
	$min_deposit = get_post_meta( $payment_id, '_payment_min_deposit', true );
	$max_deposit = get_post_meta( $payment_id, '_payment_max_deposit', true );
	$min_withdrawal = get_post_meta( $payment_id, '_payment_min_withdrawal', true );
	$max_withdrawal = get_post_meta( $payment_id, '_payment_max_withdrawal', true );
	$fees = get_post_meta( $payment_id, '_payment_fees', true );
	$currencies = get_post_meta( $payment_id, '_payment_currencies', true );
	$website_url = get_post_meta( $payment_id, '_payment_website', true );
	$pros = get_post_meta( $payment_id, '_payment_pros', true );
	$cons = get_post_meta( $payment_id, '_payment_cons', true );
	
	// Convert pros and cons to arrays if they are strings
	if ( is_string( $pros ) ) {
		$pros = explode( "\n", $pros );
	}
	
	if ( is_string( $cons ) ) {
		$cons = explode( "\n", $cons );
	}
	?>

	<div class="payment-header">
		<div class="container">
			<div class="payment-header-inner">
				<div class="payment-header-content">
					<h1 class="payment-title"><?php the_title(); ?></h1>
					
					<?php
					// Get payment type terms
					$payment_types = get_the_terms( $payment_id, 'payment_type' );
					if ( ! empty( $payment_types ) && ! is_wp_error( $payment_types ) ) :
						$type_names = array();
						foreach ( $payment_types as $type ) {
							$type_names[] = $type->name;
						}
					?>
						<div class="payment-type-badge">
							<i class="fa-solid fa-credit-card"></i> <?php echo esc_html( implode( ', ', $type_names ) ); ?>
						</div>
					<?php endif; ?>
					
					<div class="payment-meta-header">
						<?php if ( $deposit_time ) : ?>
							<div class="meta-item">
								<i class="fa-solid fa-arrow-down"></i>
								<span><?php esc_html_e( 'Deposit Time:', 'casino-review-pro' ); ?> <?php echo esc_html( $deposit_time ); ?></span>
							</div>
						<?php endif; ?>
						
						<?php if ( $withdrawal_time ) : ?>
							<div class="meta-item">
								<i class="fa-solid fa-arrow-up"></i>
								<span><?php esc_html_e( 'Withdrawal Time:', 'casino-review-pro' ); ?> <?php echo esc_html( $withdrawal_time ); ?></span>
							</div>
						<?php endif; ?>
						
						<?php if ( $fees ) : ?>
							<div class="meta-item">
								<i class="fa-solid fa-percent"></i>
								<span><?php esc_html_e( 'Fees:', 'casino-review-pro' ); ?> <?php echo esc_html( $fees ); ?></span>
							</div>
						<?php endif; ?>
					</div>
					
					<?php if ( $website_url ) : ?>
						<div class="payment-actions-header">
							<a href="<?php echo esc_url( $website_url ); ?>" class="btn btn-primary btn-lg" target="_blank">
								<i class="fa-solid fa-external-link"></i> <?php esc_html_e( 'Visit Website', 'casino-review-pro' ); ?>
							</a>
						</div>
					<?php endif; ?>
				</div>
				
				<div class="payment-logo-large">
					<?php 
					if ( has_post_thumbnail() ) {
						the_post_thumbnail( 'large', array( 'class' => 'payment-logo' ) );
					}
					?>
				</div>
			</div>
		</div>
	</div>

	<main id="primary" class="site-main">
		<div class="container">
			<div class="row">
				<div class="col-lg-8 main-content">
					<div class="payment-content">
						<?php if ( ! empty( $pros ) || ! empty( $cons ) ) : ?>
							<div class="payment-pros-cons-box">
								<?php if ( ! empty( $pros ) ) : ?>
									<div class="payment-pros-box">
										<h3><?php esc_html_e( 'PROS', 'casino-review-pro' ); ?></h3>
										<ul>
											<?php foreach ( $pros as $pro ) : ?>
												<?php if ( ! empty( trim( $pro ) ) ) : ?>
													<li><i class="fa-solid fa-check"></i> <?php echo esc_html( trim( $pro ) ); ?></li>
												<?php endif; ?>
											<?php endforeach; ?>
										</ul>
									</div>
								<?php endif; ?>
								
								<?php if ( ! empty( $cons ) ) : ?>
									<div class="payment-cons-box">
										<h3><?php esc_html_e( 'CONS', 'casino-review-pro' ); ?></h3>
										<ul>
											<?php foreach ( $cons as $con ) : ?>
												<?php if ( ! empty( trim( $con ) ) ) : ?>
													<li><i class="fa-solid fa-xmark"></i> <?php echo esc_html( trim( $con ) ); ?></li>
												<?php endif; ?>
											<?php endforeach; ?>
										</ul>
									</div>
								<?php endif; ?>
							</div>
						<?php endif; ?>
						
						<div class="payment-description">
							<?php the_content(); ?>
						</div>
						
						<div class="payment-details">
							<h3><?php esc_html_e( 'Payment Method Details', 'casino-review-pro' ); ?></h3>
							<div class="payment-details-grid">
								<?php if ( $min_deposit ) : ?>
									<div class="detail-item">
										<div class="detail-label"><?php esc_html_e( 'Min. Deposit', 'casino-review-pro' ); ?></div>
										<div class="detail-value"><?php echo esc_html( $min_deposit ); ?></div>
									</div>
								<?php endif; ?>
								
								<?php if ( $max_deposit ) : ?>
									<div class="detail-item">
										<div class="detail-label"><?php esc_html_e( 'Max. Deposit', 'casino-review-pro' ); ?></div>
										<div class="detail-value"><?php echo esc_html( $max_deposit ); ?></div>
									</div>
								<?php endif; ?>
								
								<?php if ( $min_withdrawal ) : ?>
									<div class="detail-item">
										<div class="detail-label"><?php esc_html_e( 'Min. Withdrawal', 'casino-review-pro' ); ?></div>
										<div class="detail-value"><?php echo esc_html( $min_withdrawal ); ?></div>
									</div>
								<?php endif; ?>
								
								<?php if ( $max_withdrawal ) : ?>
									<div class="detail-item">
										<div class="detail-label"><?php esc_html_e( 'Max. Withdrawal', 'casino-review-pro' ); ?></div>
										<div class="detail-value"><?php echo esc_html( $max_withdrawal ); ?></div>
									</div>
								<?php endif; ?>
								
								<?php if ( $deposit_time ) : ?>
									<div class="detail-item">
										<div class="detail-label"><?php esc_html_e( 'Deposit Time', 'casino-review-pro' ); ?></div>
										<div class="detail-value"><?php echo esc_html( $deposit_time ); ?></div>
									</div>
								<?php endif; ?>
								
								<?php if ( $withdrawal_time ) : ?>
									<div class="detail-item">
										<div class="detail-label"><?php esc_html_e( 'Withdrawal Time', 'casino-review-pro' ); ?></div>
										<div class="detail-value"><?php echo esc_html( $withdrawal_time ); ?></div>
									</div>
								<?php endif; ?>
								
								<?php if ( $fees ) : ?>
									<div class="detail-item">
										<div class="detail-label"><?php esc_html_e( 'Fees', 'casino-review-pro' ); ?></div>
										<div class="detail-value"><?php echo esc_html( $fees ); ?></div>
									</div>
								<?php endif; ?>
								
								<?php if ( $currencies ) : ?>
									<div class="detail-item">
										<div class="detail-label"><?php esc_html_e( 'Currencies', 'casino-review-pro' ); ?></div>
										<div class="detail-value"><?php echo esc_html( $currencies ); ?></div>
									</div>
								<?php endif; ?>
							</div>
						</div>
						
						<?php
						// Get casinos that support this payment method
						$casinos_query = new WP_Query( array(
							'post_type'      => 'casino',
							'posts_per_page' => -1,
							'meta_query'     => array(
								array(
									'key'     => '_casino_payment_methods',
									'value'   => $payment_id,
									'compare' => 'LIKE',
								),
							),
						) );
						
						if ( $casinos_query->have_posts() ) :
						?>
							<div class="payment-casinos">
								<h3><?php esc_html_e( 'Casinos that accept', 'casino-review-pro' ); ?> <?php the_title(); ?></h3>
								<div class="casino-list-medium">
									<?php while ( $casinos_query->have_posts() ) : $casinos_query->the_post(); ?>
										<?php
										$casino_id = get_the_ID();
										$casino_rating = get_post_meta( $casino_id, '_casino_overall_rating', true );
										$casino_website = get_post_meta( $casino_id, '_casino_website_url', true );
										$casino_min_deposit = get_post_meta( $casino_id, '_casino_min_deposit', true );
										$casino_withdrawal_time = get_post_meta( $casino_id, '_casino_withdrawal_time', true );
										?>
										
										<div class="casino-item-medium">
											<div class="casino-logo-col">
												<?php if ( has_post_thumbnail() ) : ?>
													<a href="<?php the_permalink(); ?>">
														<?php the_post_thumbnail( 'casino-thumbnail', array( 'class' => 'casino-logo' ) ); ?>
													</a>
												<?php endif; ?>
											</div>
											
											<div class="casino-info-col">
												<h4 class="casino-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>
												
												<?php if ( $casino_rating ) : ?>
													<div class="casino-rating-medium">
														<?php echo casino_review_rating_stars( $casino_rating, 10 ); ?>
														<span class="rating-text"><?php echo esc_html( $casino_rating ); ?>/10</span>
													</div>
												<?php endif; ?>
												
												<div class="casino-meta-medium">
													<?php if ( $casino_min_deposit ) : ?>
														<div class="meta-item">
															<i class="fa-solid fa-money-bill-1"></i> <?php esc_html_e( 'Min. Deposit:', 'casino-review-pro' ); ?> <?php echo esc_html( $casino_min_deposit ); ?>
														</div>
													<?php endif; ?>
													
													<?php if ( $casino_withdrawal_time ) : ?>
														<div class="meta-item">
															<i class="fa-solid fa-clock"></i> <?php esc_html_e( 'Withdrawal Time:', 'casino-review-pro' ); ?> <?php echo esc_html( $casino_withdrawal_time ); ?>
														</div>
													<?php endif; ?>
												</div>
											</div>
											
											<div class="casino-action-col">
												<?php if ( $casino_website ) : ?>
													<a href="<?php echo esc_url( $casino_website ); ?>" class="btn btn-primary" target="_blank"><?php esc_html_e( 'Visit Casino', 'casino-review-pro' ); ?></a>
												<?php endif; ?>
												
												<a href="<?php the_permalink(); ?>" class="btn btn-outline"><?php esc_html_e( 'Read Review', 'casino-review-pro' ); ?></a>
											</div>
										</div>
									<?php endwhile; wp_reset_postdata(); ?>
								</div>
							</div>
						<?php endif; ?>
						
						<?php
						// Get similar payment methods
						$payment_types = get_the_terms( $payment_id, 'payment_type' );
						if ( ! empty( $payment_types ) && ! is_wp_error( $payment_types ) ) {
							$type_ids = wp_list_pluck( $payment_types, 'term_id' );
							
							$similar_methods = new WP_Query( array(
								'post_type'      => 'payment_method',
								'posts_per_page' => 4,
								'post__not_in'   => array( $payment_id ),
								'tax_query'      => array(
									array(
										'taxonomy' => 'payment_type',
										'field'    => 'term_id',
										'terms'    => $type_ids,
									),
								),
								'orderby'        => 'rand',
							) );
							
							if ( $similar_methods->have_posts() ) :
							?>
								<div class="similar-payment-methods">
									<h3><?php esc_html_e( 'Similar Payment Methods', 'casino-review-pro' ); ?></h3>
									
									<div class="payment-methods-grid">
										<?php while ( $similar_methods->have_posts() ) : $similar_methods->the_post(); ?>
											<div class="payment-method-card">
												<a href="<?php the_permalink(); ?>" class="payment-method-link">
													<?php if ( has_post_thumbnail() ) : ?>
														<?php the_post_thumbnail( 'medium', array( 'class' => 'payment-method-logo' ) ); ?>
													<?php endif; ?>
													<h4 class="payment-method-title"><?php the_title(); ?></h4>
												</a>
											</div>
										<?php endwhile; wp_reset_postdata(); ?>
									</div>
								</div>
							<?php endif; ?>
						<?php } ?>
					</div><!-- .payment-content -->
					
					<?php
					// If comments are open or we have at least one comment, load up the comment template.
					if ( comments_open() || get_comments_number() ) :
						comments_template();
					endif;
					?>
					
				</div><!-- .main-content -->
				
				<div class="col-lg-4 sidebar">
					<div class="payment-sidebar">
						<div class="widget payment-info-widget">
							<h3 class="widget-title"><?php esc_html_e( 'Payment Information', 'casino-review-pro' ); ?></h3>
							
							<ul class="payment-info-list">
								<?php if ( $deposit_time ) : ?>
									<li>
										<strong><?php esc_html_e( 'Deposit Time:', 'casino-review-pro' ); ?></strong>
										<?php echo esc_html( $deposit_time ); ?>
									</li>
								<?php endif; ?>
								
								<?php if ( $withdrawal_time ) : ?>
									<li>
										<strong><?php esc_html_e( 'Withdrawal Time:', 'casino-review-pro' ); ?></strong>
										<?php echo esc_html( $withdrawal_time ); ?>
									</li>
								<?php endif; ?>
								
								<?php if ( $min_deposit ) : ?>
									<li>
										<strong><?php esc_html_e( 'Min. Deposit:', 'casino-review-pro' ); ?></strong>
										<?php echo esc_html( $min_deposit ); ?>
									</li>
								<?php endif; ?>
								
								<?php if ( $max_deposit ) : ?>
									<li>
										<strong><?php esc_html_e( 'Max. Deposit:', 'casino-review-pro' ); ?></strong>
										<?php echo esc_html( $max_deposit ); ?>
									</li>
								<?php endif; ?>
								
								<?php if ( $min_withdrawal ) : ?>
									<li>
										<strong><?php esc_html_e( 'Min. Withdrawal:', 'casino-review-pro' ); ?></strong>
										<?php echo esc_html( $min_withdrawal ); ?>
									</li>
								<?php endif; ?>
								
								<?php if ( $max_withdrawal ) : ?>
									<li>
										<strong><?php esc_html_e( 'Max. Withdrawal:', 'casino-review-pro' ); ?></strong>
										<?php echo esc_html( $max_withdrawal ); ?>
									</li>
								<?php endif; ?>
								
								<?php if ( $fees ) : ?>
									<li>
										<strong><?php esc_html_e( 'Fees:', 'casino-review-pro' ); ?></strong>
										<?php echo esc_html( $fees ); ?>
									</li>
								<?php endif; ?>
								
								<?php if ( $currencies ) : ?>
									<li>
										<strong><?php esc_html_e( 'Currencies:', 'casino-review-pro' ); ?></strong>
										<?php echo esc_html( $currencies ); ?>
									</li>
								<?php endif; ?>
								
								<?php if ( $website_url ) : ?>
									<li>
										<strong><?php esc_html_e( 'Website:', 'casino-review-pro' ); ?></strong>
										<a href="<?php echo esc_url( $website_url ); ?>" target="_blank"><?php echo esc_url( $website_url ); ?></a>
									</li>
								<?php endif; ?>
							</ul>
							
							<?php if ( $website_url ) : ?>
								<a href="<?php echo esc_url( $website_url ); ?>" class="btn btn-primary btn-block" target="_blank">
									<?php esc_html_e( 'Visit Website', 'casino-review-pro' ); ?>
								</a>
							<?php endif; ?>
						</div>
						
						<div class="widget payment-types-widget">
							<h3 class="widget-title"><?php esc_html_e( 'Payment Categories', 'casino-review-pro' ); ?></h3>
							<?php
							$payment_types = get_terms( array(
								'taxonomy' => 'payment_type',
								'hide_empty' => true,
							) );
							
							if ( ! empty( $payment_types ) && ! is_wp_error( $payment_types ) ) :
							?>
								<div class="widget-content">
									<ul class="payment-types-list">
										<?php foreach ( $payment_types as $type ) : ?>
											<li>
												<a href="<?php echo esc_url( get_term_link( $type ) ); ?>">
													<?php echo esc_html( $type->name ); ?>
													<span class="count">(<?php echo esc_html( $type->count ); ?>)</span>
												</a>
											</li>
										<?php endforeach; ?>
									</ul>
								</div>
							<?php else : ?>
								<div class="widget-content">
									<p><?php esc_html_e( 'No payment types found.', 'casino-review-pro' ); ?></p>
								</div>
							<?php endif; ?>
						</div>
						
						<div class="widget top-casinos-widget">
							<h3 class="widget-title"><?php esc_html_e( 'Top Rated Casinos', 'casino-review-pro' ); ?></h3>
							<?php
							$top_casinos = new WP_Query( array(
								'post_type' => 'casino',
								'posts_per_page' => 3,
								'meta_key' => '_casino_overall_rating',
								'orderby' => 'meta_value_num',
								'order' => 'DESC',
							) );
							
							if ( $top_casinos->have_posts() ) :
							?>
								<div class="widget-content">
									<div class="top-casinos-list">
										<?php while ( $top_casinos->have_posts() ) : $top_casinos->the_post(); ?>
											<?php
											$casino_id = get_the_ID();
											$casino_rating = get_post_meta( $casino_id, '_casino_overall_rating', true );
											$casino_url = get_post_meta( $casino_id, '_casino_website_url', true );
											?>
											<div class="top-casino-item">
												<?php if ( has_post_thumbnail() ) : ?>
													<div class="casino-logo-small">
														<a href="<?php the_permalink(); ?>">
															<?php the_post_thumbnail( 'thumbnail' ); ?>
														</a>
													</div>
												<?php endif; ?>
												
												<div class="casino-info">
													<h4 class="casino-name"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>
													
													<?php if ( $casino_rating ) : ?>
														<div class="casino-rating">
															<?php echo casino_review_rating_stars( $casino_rating, 10 ); ?>
														</div>
													<?php endif; ?>
													
													<?php if ( $casino_url ) : ?>
														<a href="<?php echo esc_url( $casino_url ); ?>" class="btn btn-sm btn-primary" target="_blank">
															<?php esc_html_e( 'Visit Casino', 'casino-review-pro' ); ?>
														</a>
													<?php endif; ?>
												</div>
											</div>
										<?php endwhile; wp_reset_postdata(); ?>
									</div>
								</div>
							<?php else : ?>
								<div class="widget-content">
									<p><?php esc_html_e( 'No casinos found.', 'casino-review-pro' ); ?></p>
								</div>
							<?php endif; ?>
						</div>
						
						<?php get_sidebar(); ?>
					</div><!-- .payment-sidebar -->
				</div><!-- .sidebar -->
			</div><!-- .row -->
		</div><!-- .container -->
	</main><!-- #main -->

<?php
endwhile; // End of the loop.

get_footer();
