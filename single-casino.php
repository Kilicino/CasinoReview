<?php
/**
 * The template for displaying single casino reviews
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package Casino_Review_Pro
 */

get_header();

while ( have_posts() ) :
	the_post();
	
	// Get casino meta data
	$rating = get_post_meta( get_the_ID(), '_casino_overall_rating', true );
	$games_rating = get_post_meta( get_the_ID(), '_casino_games_rating', true );
	$bonuses_rating = get_post_meta( get_the_ID(), '_casino_bonuses_rating', true );
	$support_rating = get_post_meta( get_the_ID(), '_casino_support_rating', true );
	$payments_rating = get_post_meta( get_the_ID(), '_casino_payments_rating', true );
	$mobile_rating = get_post_meta( get_the_ID(), '_casino_mobile_rating', true );
	
	$website_url = get_post_meta( get_the_ID(), '_casino_website_url', true );
	$established = get_post_meta( get_the_ID(), '_casino_established', true );
	$license = get_post_meta( get_the_ID(), '_casino_license', true );
	$owner = get_post_meta( get_the_ID(), '_casino_owner', true );
	$software = get_post_meta( get_the_ID(), '_casino_software', true );
	$languages = get_post_meta( get_the_ID(), '_casino_languages', true );
	$currencies = get_post_meta( get_the_ID(), '_casino_currencies', true );
	$min_deposit = get_post_meta( get_the_ID(), '_casino_min_deposit', true );
	$min_withdrawal = get_post_meta( get_the_ID(), '_casino_min_withdrawal', true );
	$withdrawal_time = get_post_meta( get_the_ID(), '_casino_withdrawal_time', true );
	
	$pros = get_post_meta( get_the_ID(), '_casino_pros', true );
	$cons = get_post_meta( get_the_ID(), '_casino_cons', true );
	
	$pros_array = ! empty( $pros ) ? explode( "\n", $pros ) : array();
	$cons_array = ! empty( $cons ) ? explode( "\n", $cons ) : array();
	?>

	<div class="casino-header">
		<div class="container">
			<div class="casino-header-inner">
				<div class="casino-logo-large">
					<?php 
					if ( has_post_thumbnail() ) {
						the_post_thumbnail( 'casino-logo', array( 'class' => 'casino-logo' ) );
					}
					?>
				</div>
				
				<div class="casino-header-content">
					<h1 class="casino-title"><?php the_title(); ?></h1>
					
					<?php if ( $rating ) : ?>
						<div class="casino-rating">
							<div class="rating-score"><?php echo esc_html( $rating ); ?></div>
							<div class="rating-stars">
								<?php 
								$stars = round( $rating / 2, 1 );
								for ( $i = 1; $i <= 5; $i++ ) :
									if ( $i <= floor( $stars ) ) :
										echo '<span class="star filled"><i class="fa-solid fa-star"></i></span>';
									elseif ( $i - $stars < 1 && $i - $stars > 0 ) :
										echo '<span class="star filled"><i class="fa-solid fa-star-half-stroke"></i></span>';
									else :
										echo '<span class="star"><i class="fa-regular fa-star"></i></span>';
									endif;
								endfor;
								?>
								<span class="rating-text"><?php echo esc_html( $rating ); ?>/10</span>
							</div>
						</div>
					<?php endif; ?>
					
					<div class="casino-meta-header">
						<?php if ( $established ) : ?>
							<div class="meta-item">
								<i class="fa-solid fa-calendar-days"></i>
								<span><?php esc_html_e( 'Established:', 'casino-review-pro' ); ?> <?php echo esc_html( $established ); ?></span>
							</div>
						<?php endif; ?>
						
						<?php if ( $license ) : ?>
							<div class="meta-item">
								<i class="fa-solid fa-certificate"></i>
								<span><?php esc_html_e( 'License:', 'casino-review-pro' ); ?> <?php echo esc_html( $license ); ?></span>
							</div>
						<?php endif; ?>
						
						<?php if ( $owner ) : ?>
							<div class="meta-item">
								<i class="fa-solid fa-building"></i>
								<span><?php esc_html_e( 'Owner:', 'casino-review-pro' ); ?> <?php echo esc_html( $owner ); ?></span>
							</div>
						<?php endif; ?>
					</div>
					
					<div class="casino-actions-header">
						<?php if ( $website_url ) : ?>
							<a href="<?php echo esc_url( $website_url ); ?>" class="btn btn-primary" target="_blank">
								<i class="fa-solid fa-play"></i> <?php esc_html_e( 'Visit Casino', 'casino-review-pro' ); ?>
							</a>
						<?php endif; ?>
						
						<button class="btn btn-outline casino-claim-bonus">
							<i class="fa-solid fa-gift"></i> <?php esc_html_e( 'Claim Bonus', 'casino-review-pro' ); ?>
						</button>
					</div>
				</div>
			</div>
		</div>
	</div>

	<main id="primary" class="site-main">
		<div class="container">
			<div class="row">
				<div class="col-lg-8 main-content">
				
					<div class="casino-review-content">
						<div class="casino-toc">
							<h3><?php esc_html_e( 'Table of Contents', 'casino-review-pro' ); ?></h3>
							<ul>
								<li><a href="#overview"><?php esc_html_e( 'Casino Overview', 'casino-review-pro' ); ?></a></li>
								<li><a href="#bonuses"><?php esc_html_e( 'Bonuses & Promotions', 'casino-review-pro' ); ?></a></li>
								<li><a href="#games"><?php esc_html_e( 'Games & Software', 'casino-review-pro' ); ?></a></li>
								<li><a href="#banking"><?php esc_html_e( 'Banking Options', 'casino-review-pro' ); ?></a></li>
								<li><a href="#mobile"><?php esc_html_e( 'Mobile Experience', 'casino-review-pro' ); ?></a></li>
								<li><a href="#support"><?php esc_html_e( 'Customer Support', 'casino-review-pro' ); ?></a></li>
								<li><a href="#conclusion"><?php esc_html_e( 'Conclusion', 'casino-review-pro' ); ?></a></li>
								<li><a href="#faq"><?php esc_html_e( 'FAQ', 'casino-review-pro' ); ?></a></li>
							</ul>
						</div>
						
						<?php if ( ! empty( $pros_array ) || ! empty( $cons_array ) ) : ?>
							<div class="casino-pros-cons-box">
								<?php if ( ! empty( $pros_array ) ) : ?>
									<div class="casino-pros-box">
										<h3><?php esc_html_e( 'PROS', 'casino-review-pro' ); ?></h3>
										<ul>
											<?php foreach ( $pros_array as $pro ) : ?>
												<?php if ( ! empty( trim( $pro ) ) ) : ?>
													<li><i class="fa-solid fa-check"></i> <?php echo esc_html( trim( $pro ) ); ?></li>
												<?php endif; ?>
											<?php endforeach; ?>
										</ul>
									</div>
								<?php endif; ?>
								
								<?php if ( ! empty( $cons_array ) ) : ?>
									<div class="casino-cons-box">
										<h3><?php esc_html_e( 'CONS', 'casino-review-pro' ); ?></h3>
										<ul>
											<?php foreach ( $cons_array as $con ) : ?>
												<?php if ( ! empty( trim( $con ) ) ) : ?>
													<li><i class="fa-solid fa-xmark"></i> <?php echo esc_html( trim( $con ) ); ?></li>
												<?php endif; ?>
											<?php endforeach; ?>
										</ul>
									</div>
								<?php endif; ?>
							</div>
						<?php endif; ?>
						
						<div id="overview" class="casino-section">
							<h2><?php esc_html_e( 'Casino Overview', 'casino-review-pro' ); ?></h2>
							<?php the_content(); ?>
						</div>
						
						<div id="bonuses" class="casino-section">
							<h2><?php esc_html_e( 'Bonuses & Promotions', 'casino-review-pro' ); ?></h2>
							<div class="rating-detail">
								<div class="rating-detail-score">
									<?php echo esc_html( $bonuses_rating ); ?>/10
								</div>
								<div class="rating-detail-bar">
									<div class="rating-progress" style="width: <?php echo esc_attr( $bonuses_rating * 10 ); ?>%"></div>
								</div>
							</div>
							
							<?php
							// Get related bonuses
							$related_bonuses = new WP_Query( array(
								'post_type'      => 'bonus',
								'posts_per_page' => 3,
								'meta_query'     => array(
									array(
										'key'     => '_bonus_casino',
										'value'   => get_the_ID(),
										'compare' => '=',
									),
								),
							) );
							
							if ( $related_bonuses->have_posts() ) :
							?>
								<div class="related-bonuses">
									<?php while ( $related_bonuses->have_posts() ) : $related_bonuses->the_post(); ?>
										<div class="bonus-card">
											<div class="bonus-header">
												<h3 class="bonus-title"><?php the_title(); ?></h3>
												<?php 
												$bonus_value = get_post_meta( get_the_ID(), '_bonus_value', true );
												if ( $bonus_value ) : 
												?>
													<div class="bonus-value"><?php echo esc_html( $bonus_value ); ?></div>
												<?php endif; ?>
											</div>
											
											<div class="bonus-description">
												<?php the_excerpt(); ?>
											</div>
											
											<?php 
											$bonus_terms = get_post_meta( get_the_ID(), '_bonus_terms', true );
											if ( $bonus_terms ) : 
											?>
												<div class="bonus-terms">
													<strong><?php esc_html_e( 'Terms & Conditions:', 'casino-review-pro' ); ?></strong>
													<?php echo esc_html( $bonus_terms ); ?>
												</div>
											<?php endif; ?>
											
											<div class="bonus-cta">
												<?php if ( $website_url ) : ?>
													<a href="<?php echo esc_url( $website_url ); ?>" class="btn btn-primary" target="_blank">
														<?php esc_html_e( 'Claim Bonus', 'casino-review-pro' ); ?>
													</a>
												<?php endif; ?>
											</div>
										</div>
									<?php endwhile; wp_reset_postdata(); ?>
								</div>
							<?php endif; ?>
						</div>
						
						<div id="games" class="casino-section">
							<h2><?php esc_html_e( 'Games & Software', 'casino-review-pro' ); ?></h2>
							<div class="rating-detail">
								<div class="rating-detail-score">
									<?php echo esc_html( $games_rating ); ?>/10
								</div>
								<div class="rating-detail-bar">
									<div class="rating-progress" style="width: <?php echo esc_attr( $games_rating * 10 ); ?>%"></div>
								</div>
							</div>
							
							<?php if ( $software ) : ?>
								<div class="software-providers">
									<h3><?php esc_html_e( 'Software Providers', 'casino-review-pro' ); ?></h3>
									<div class="provider-list">
										<?php
										$providers = explode( ',', $software );
										foreach ( $providers as $provider ) :
											$provider = trim( $provider );
											if ( ! empty( $provider ) ) :
											?>
												<span class="provider-badge"><?php echo esc_html( $provider ); ?></span>
											<?php
											endif;
										endforeach;
										?>
									</div>
								</div>
							<?php endif; ?>
							
							<?php
							// Get related games
							$related_games = new WP_Query( array(
								'post_type'      => 'game',
								'posts_per_page' => 6,
								'meta_query'     => array(
									array(
										'key'     => '_game_casino',
										'value'   => get_the_ID(),
										'compare' => '=',
									),
								),
							) );
							
							if ( $related_games->have_posts() ) :
							?>
								<div class="related-games">
									<h3><?php esc_html_e( 'Popular Games', 'casino-review-pro' ); ?></h3>
									<div class="games-grid">
										<?php while ( $related_games->have_posts() ) : $related_games->the_post(); ?>
											<div class="game-card">
												<?php if ( has_post_thumbnail() ) : ?>
													<img src="<?php the_post_thumbnail_url( 'game-thumbnail' ); ?>" alt="<?php the_title_attribute(); ?>" class="game-image">
												<?php endif; ?>
												
												<div class="game-content">
													<h4 class="game-title"><?php the_title(); ?></h4>
													
													<?php 
													$game_provider = get_post_meta( get_the_ID(), '_game_provider', true );
													if ( $game_provider ) : 
													?>
														<div class="game-provider"><?php echo esc_html( $game_provider ); ?></div>
													<?php endif; ?>
													
													<div class="game-meta">
														<?php 
														$game_rating = get_post_meta( get_the_ID(), '_game_rating', true );
														if ( $game_rating ) : 
														?>
															<div class="game-rating">
																<?php 
																$game_stars = round( $game_rating / 2, 1 );
																for ( $i = 1; $i <= 5; $i++ ) :
																	if ( $i <= floor( $game_stars ) ) :
																		echo '<i class="fa-solid fa-star"></i>';
																	elseif ( $i - $game_stars < 1 && $i - $game_stars > 0 ) :
																		echo '<i class="fa-solid fa-star-half-stroke"></i>';
																	else :
																		echo '<i class="fa-regular fa-star"></i>';
																	endif;
																endfor;
																?>
															</div>
														<?php endif; ?>
														
														<?php 
														$game_rtp = get_post_meta( get_the_ID(), '_game_rtp', true );
														if ( $game_rtp ) : 
														?>
															<div class="game-rtp">RTP: <?php echo esc_html( $game_rtp ); ?>%</div>
														<?php endif; ?>
													</div>
													
													<div class="game-footer">
														<a href="<?php the_permalink(); ?>" class="btn btn-sm btn-outline"><?php esc_html_e( 'Read More', 'casino-review-pro' ); ?></a>
														
														<?php if ( $website_url ) : ?>
															<a href="<?php echo esc_url( $website_url ); ?>" class="btn btn-sm btn-primary" target="_blank"><?php esc_html_e( 'Play Now', 'casino-review-pro' ); ?></a>
														<?php endif; ?>
													</div>
												</div>
											</div>
										<?php endwhile; wp_reset_postdata(); ?>
									</div>
								</div>
							<?php endif; ?>
						</div>
						
						<div id="banking" class="casino-section">
							<h2><?php esc_html_e( 'Banking Options', 'casino-review-pro' ); ?></h2>
							<div class="rating-detail">
								<div class="rating-detail-score">
									<?php echo esc_html( $payments_rating ); ?>/10
								</div>
								<div class="rating-detail-bar">
									<div class="rating-progress" style="width: <?php echo esc_attr( $payments_rating * 10 ); ?>%"></div>
								</div>
							</div>
							
							<div class="banking-details">
								<div class="banking-item">
									<h4><?php esc_html_e( 'Currencies', 'casino-review-pro' ); ?></h4>
									<div class="banking-value"><?php echo esc_html( $currencies ); ?></div>
								</div>
								
								<div class="banking-item">
									<h4><?php esc_html_e( 'Min. Deposit', 'casino-review-pro' ); ?></h4>
									<div class="banking-value"><?php echo esc_html( $min_deposit ); ?></div>
								</div>
								
								<div class="banking-item">
									<h4><?php esc_html_e( 'Min. Withdrawal', 'casino-review-pro' ); ?></h4>
									<div class="banking-value"><?php echo esc_html( $min_withdrawal ); ?></div>
								</div>
								
								<div class="banking-item">
									<h4><?php esc_html_e( 'Withdrawal Time', 'casino-review-pro' ); ?></h4>
									<div class="banking-value"><?php echo esc_html( $withdrawal_time ); ?></div>
								</div>
							</div>
							
							<?php
							// Get payment methods
							$payment_methods = get_posts( array(
								'post_type'      => 'payment_method',
								'posts_per_page' => -1,
								'meta_query'     => array(
									array(
										'key'     => '_payment_method_casino',
										'value'   => get_the_ID(),
										'compare' => '=',
									),
								),
							) );
							
							if ( ! empty( $payment_methods ) ) :
							?>
								<div class="payment-methods-section">
									<h3><?php esc_html_e( 'Available Payment Methods', 'casino-review-pro' ); ?></h3>
									<div class="payment-methods">
										<?php foreach ( $payment_methods as $method ) : ?>
											<div class="payment-method">
												<?php if ( has_post_thumbnail( $method->ID ) ) : ?>
													<img src="<?php echo get_the_post_thumbnail_url( $method->ID, 'thumbnail' ); ?>" alt="<?php echo esc_attr( $method->post_title ); ?>">
												<?php else : ?>
													<div class="payment-method-name"><?php echo esc_html( $method->post_title ); ?></div>
												<?php endif; ?>
											</div>
										<?php endforeach; ?>
									</div>
								</div>
							<?php endif; ?>
						</div>
						
						<div id="mobile" class="casino-section">
							<h2><?php esc_html_e( 'Mobile Experience', 'casino-review-pro' ); ?></h2>
							<div class="rating-detail">
								<div class="rating-detail-score">
									<?php echo esc_html( $mobile_rating ); ?>/10
								</div>
								<div class="rating-detail-bar">
									<div class="rating-progress" style="width: <?php echo esc_attr( $mobile_rating * 10 ); ?>%"></div>
								</div>
							</div>
							
							<?php
							// Mobile compatibility content here
							?>
						</div>
						
						<div id="support" class="casino-section">
							<h2><?php esc_html_e( 'Customer Support', 'casino-review-pro' ); ?></h2>
							<div class="rating-detail">
								<div class="rating-detail-score">
									<?php echo esc_html( $support_rating ); ?>/10
								</div>
								<div class="rating-detail-bar">
									<div class="rating-progress" style="width: <?php echo esc_attr( $support_rating * 10 ); ?>%"></div>
								</div>
							</div>
							
							<?php
							// Support details content here
							?>
						</div>
						
						<div id="conclusion" class="casino-section">
							<h2><?php esc_html_e( 'Conclusion', 'casino-review-pro' ); ?></h2>
							<div class="casino-conclusion">
								<?php
								// Conclusion content here
								?>
							</div>
							
							<div class="final-rating">
								<div class="final-rating-box">
									<div class="final-rating-score"><?php echo esc_html( $rating ); ?></div>
									<div class="final-rating-label"><?php esc_html_e( 'Overall Rating', 'casino-review-pro' ); ?></div>
								</div>
								
								<div class="casino-cta">
									<?php if ( $website_url ) : ?>
										<a href="<?php echo esc_url( $website_url ); ?>" class="btn btn-lg btn-primary" target="_blank">
											<i class="fa-solid fa-play"></i> <?php esc_html_e( 'Visit Casino', 'casino-review-pro' ); ?>
										</a>
									<?php endif; ?>
								</div>
							</div>
						</div>
						
						<div id="faq" class="casino-section">
							<h2><?php esc_html_e( 'Frequently Asked Questions', 'casino-review-pro' ); ?></h2>
							<div class="casino-faq">
								<?php
								// FAQ content here - can be added via custom meta box or ACF
								// Example structure:
								?>
								<div class="faq-item">
									<div class="faq-question">
										<i class="fa-solid fa-circle-question"></i>
										<h3><?php esc_html_e( 'Is this casino safe and trustworthy?', 'casino-review-pro' ); ?></h3>
									</div>
									<div class="faq-answer">
										<p><?php esc_html_e( 'Sample answer about the casino\'s safety measures, licenses, and trustworthiness.', 'casino-review-pro' ); ?></p>
									</div>
								</div>
								
								<div class="faq-item">
									<div class="faq-question">
										<i class="fa-solid fa-circle-question"></i>
										<h3><?php esc_html_e( 'What payment methods are accepted?', 'casino-review-pro' ); ?></h3>
									</div>
									<div class="faq-answer">
										<p><?php esc_html_e( 'Sample answer about the casino\'s payment methods.', 'casino-review-pro' ); ?></p>
									</div>
								</div>
							</div>
						</div>
					</div><!-- .casino-review-content -->
					
					<?php
					// If comments are open or we have at least one comment, load up the comment template.
					if ( comments_open() || get_comments_number() ) :
						comments_template();
					endif;
					?>
					
				</div><!-- .main-content -->
				
				<div class="col-lg-4 sidebar">
					<div class="casino-sidebar">
						<div class="widget casino-rating-widget">
							<h2 class="widget-title"><?php esc_html_e( 'Casino Rating', 'casino-review-pro' ); ?></h2>
							
							<div class="rating-widget-overall">
								<div class="rating-widget-score"><?php echo esc_html( $rating ); ?></div>
								<div class="rating-widget-label"><?php esc_html_e( 'Overall Score', 'casino-review-pro' ); ?></div>
							</div>
							
							<div class="rating-widget-details">
								<div class="rating-widget-item">
									<span class="rating-label"><?php esc_html_e( 'Games', 'casino-review-pro' ); ?></span>
									<div class="rating-bar">
										<div class="rating-progress" style="width: <?php echo esc_attr( $games_rating * 10 ); ?>%"></div>
									</div>
									<span class="rating-value"><?php echo esc_html( $games_rating ); ?></span>
								</div>
								
								<div class="rating-widget-item">
									<span class="rating-label"><?php esc_html_e( 'Bonuses', 'casino-review-pro' ); ?></span>
									<div class="rating-bar">
										<div class="rating-progress" style="width: <?php echo esc_attr( $bonuses_rating * 10 ); ?>%"></div>
									</div>
									<span class="rating-value"><?php echo esc_html( $bonuses_rating ); ?></span>
								</div>
								
								<div class="rating-widget-item">
									<span class="rating-label"><?php esc_html_e( 'Support', 'casino-review-pro' ); ?></span>
									<div class="rating-bar">
										<div class="rating-progress" style="width: <?php echo esc_attr( $support_rating * 10 ); ?>%"></div>
									</div>
									<span class="rating-value"><?php echo esc_html( $support_rating ); ?></span>
								</div>
								
								<div class="rating-widget-item">
									<span class="rating-label"><?php esc_html_e( 'Payments', 'casino-review-pro' ); ?></span>
									<div class="rating-bar">
										<div class="rating-progress" style="width: <?php echo esc_attr( $payments_rating * 10 ); ?>%"></div>
									</div>
									<span class="rating-value"><?php echo esc_html( $payments_rating ); ?></span>
								</div>
								
								<div class="rating-widget-item">
									<span class="rating-label"><?php esc_html_e( 'Mobile', 'casino-review-pro' ); ?></span>
									<div class="rating-bar">
										<div class="rating-progress" style="width: <?php echo esc_attr( $mobile_rating * 10 ); ?>%"></div>
									</div>
									<span class="rating-value"><?php echo esc_html( $mobile_rating ); ?></span>
								</div>
							</div>
						</div><!-- .casino-rating-widget -->
						
						<div class="widget casino-info-widget">
							<h2 class="widget-title"><?php esc_html_e( 'Casino Information', 'casino-review-pro' ); ?></h2>
							
							<ul class="casino-info-list">
								<?php if ( $website_url ) : ?>
									<li>
										<strong><?php esc_html_e( 'Website:', 'casino-review-pro' ); ?></strong>
										<a href="<?php echo esc_url( $website_url ); ?>" target="_blank"><?php echo esc_url( $website_url ); ?></a>
									</li>
								<?php endif; ?>
								
								<?php if ( $established ) : ?>
									<li>
										<strong><?php esc_html_e( 'Established:', 'casino-review-pro' ); ?></strong>
										<?php echo esc_html( $established ); ?>
									</li>
								<?php endif; ?>
								
								<?php if ( $license ) : ?>
									<li>
										<strong><?php esc_html_e( 'License:', 'casino-review-pro' ); ?></strong>
										<?php echo esc_html( $license ); ?>
									</li>
								<?php endif; ?>
								
								<?php if ( $owner ) : ?>
									<li>
										<strong><?php esc_html_e( 'Owner:', 'casino-review-pro' ); ?></strong>
										<?php echo esc_html( $owner ); ?>
									</li>
								<?php endif; ?>
								
								<?php if ( $languages ) : ?>
									<li>
										<strong><?php esc_html_e( 'Languages:', 'casino-review-pro' ); ?></strong>
										<?php echo esc_html( $languages ); ?>
									</li>
								<?php endif; ?>
								
								<?php if ( $currencies ) : ?>
									<li>
										<strong><?php esc_html_e( 'Currencies:', 'casino-review-pro' ); ?></strong>
										<?php echo esc_html( $currencies ); ?>
									</li>
								<?php endif; ?>
								
								<?php if ( $min_deposit ) : ?>
									<li>
										<strong><?php esc_html_e( 'Min. Deposit:', 'casino-review-pro' ); ?></strong>
										<?php echo esc_html( $min_deposit ); ?>
									</li>
								<?php endif; ?>
								
								<?php if ( $min_withdrawal ) : ?>
									<li>
										<strong><?php esc_html_e( 'Min. Withdrawal:', 'casino-review-pro' ); ?></strong>
										<?php echo esc_html( $min_withdrawal ); ?>
									</li>
								<?php endif; ?>
								
								<?php if ( $withdrawal_time ) : ?>
									<li>
										<strong><?php esc_html_e( 'Withdrawal Time:', 'casino-review-pro' ); ?></strong>
										<?php echo esc_html( $withdrawal_time ); ?>
									</li>
								<?php endif; ?>
							</ul>
						</div><!-- .casino-info-widget -->
						
						<?php 
						// Get similar casinos
						$categories = get_the_terms( get_the_ID(), 'casino_category' );
						if ( ! empty( $categories ) && ! is_wp_error( $categories ) ) {
							$category_ids = wp_list_pluck( $categories, 'term_id' );
							
							$similar_casinos = new WP_Query( array(
								'post_type'      => 'casino',
								'posts_per_page' => 3,
								'post__not_in'   => array( get_the_ID() ),
								'tax_query'      => array(
									array(
										'taxonomy' => 'casino_category',
										'field'    => 'term_id',
										'terms'    => $category_ids,
									),
								),
								'meta_key'       => '_casino_overall_rating',
								'orderby'        => 'meta_value_num',
								'order'          => 'DESC',
							) );
							
							if ( $similar_casinos->have_posts() ) :
							?>
								<div class="widget similar-casinos-widget">
									<h2 class="widget-title"><?php esc_html_e( 'Similar Casinos', 'casino-review-pro' ); ?></h2>
									
									<div class="similar-casinos-list">
										<?php while ( $similar_casinos->have_posts() ) : $similar_casinos->the_post(); ?>
											<div class="similar-casino-item">
												<?php if ( has_post_thumbnail() ) : ?>
													<div class="casino-logo-wrapper">
														<a href="<?php the_permalink(); ?>">
															<?php the_post_thumbnail( 'casino-thumbnail', array( 'class' => 'casino-logo' ) ); ?>
														</a>
													</div>
												<?php endif; ?>
												
												<div class="casino-info">
													<h3 class="casino-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
													
													<?php 
													$rating = get_post_meta( get_the_ID(), '_casino_overall_rating', true );
													if ( $rating ) : 
													?>
														<div class="rating-stars">
															<?php 
															$stars = round( $rating / 2, 1 );
															for ( $i = 1; $i <= 5; $i++ ) :
																if ( $i <= floor( $stars ) ) :
																	echo '<span class="star filled"><i class="fa-solid fa-star"></i></span>';
																elseif ( $i - $stars < 1 && $i - $stars > 0 ) :
																	echo '<span class="star filled"><i class="fa-solid fa-star-half-stroke"></i></span>';
																else :
																	echo '<span class="star"><i class="fa-regular fa-star"></i></span>';
																endif;
															endfor;
															?>
															<span class="rating-text"><?php echo esc_html( $rating ); ?>/10</span>
														</div>
													<?php endif; ?>
													
													<?php 
													$website_url = get_post_meta( get_the_ID(), '_casino_website_url', true );
													if ( $website_url ) : 
													?>
														<a href="<?php echo esc_url( $website_url ); ?>" class="btn btn-sm btn-primary" target="_blank"><?php esc_html_e( 'Visit Casino', 'casino-review-pro' ); ?></a>
													<?php endif; ?>
												</div>
											</div>
										<?php endwhile; wp_reset_postdata(); ?>
									</div>
								</div>
							<?php endif; ?>
						<?php } ?>
						
						<?php get_sidebar(); ?>
					</div><!-- .casino-sidebar -->
				</div><!-- .sidebar -->
			</div><!-- .row -->
		</div><!-- .container -->
	</main><!-- #main -->

<?php
endwhile; // End of the loop.

get_footer();
