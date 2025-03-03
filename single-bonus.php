<?php
/**
 * The template for displaying single bonus offers
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package Casino_Review_Pro
 */

get_header();

while ( have_posts() ) :
	the_post();
	
	// Get bonus meta data
	$bonus_value = get_post_meta( get_the_ID(), '_bonus_value', true );
	$bonus_code = get_post_meta( get_the_ID(), '_bonus_code', true );
	$bonus_expiry = get_post_meta( get_the_ID(), '_bonus_expiry', true );
	$bonus_terms = get_post_meta( get_the_ID(), '_bonus_terms', true );
	$bonus_casino = get_post_meta( get_the_ID(), '_bonus_casino', true );
	$bonus_exclusive = get_post_meta( get_the_ID(), '_bonus_exclusive', true );
	
	// Get casino data if bonus is linked to a casino
	$casino_name = '';
	$casino_url = '';
	$casino_rating = '';
	
	if ( $bonus_casino ) {
		$casino_name = get_the_title( $bonus_casino );
		$casino_url = get_post_meta( $bonus_casino, '_casino_website_url', true );
		$casino_rating = get_post_meta( $bonus_casino, '_casino_overall_rating', true );
	}
	?>

	<div class="bonus-header">
		<div class="container">
			<div class="bonus-header-inner">
				<?php if ( $bonus_exclusive ) : ?>
					<div class="bonus-exclusive-badge">
						<i class="fa-solid fa-crown"></i> <?php esc_html_e( 'Exclusive Bonus', 'casino-review-pro' ); ?>
					</div>
				<?php endif; ?>
				
				<div class="bonus-header-content">
					<h1 class="bonus-title"><?php the_title(); ?></h1>
					
					<?php if ( $bonus_casino && $casino_name ) : ?>
						<div class="bonus-casino-info">
							<?php esc_html_e( 'From:', 'casino-review-pro' ); ?> 
							<a href="<?php echo esc_url( get_permalink( $bonus_casino ) ); ?>" class="bonus-casino-link">
								<?php echo esc_html( $casino_name ); ?>
							</a>
							
							<?php if ( $casino_rating ) : ?>
								<div class="rating-stars-small">
									<?php 
									$stars = round( $casino_rating / 2, 1 );
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
									<span class="rating-text"><?php echo esc_html( $casino_rating ); ?>/10</span>
								</div>
							<?php endif; ?>
						</div>
					<?php endif; ?>
					
					<?php if ( $bonus_value ) : ?>
						<div class="bonus-value-large">
							<?php echo esc_html( $bonus_value ); ?>
						</div>
					<?php endif; ?>
					
					<?php if ( $bonus_expiry ) : ?>
						<div class="bonus-expiry">
							<i class="fa-solid fa-clock"></i> <?php esc_html_e( 'Expires:', 'casino-review-pro' ); ?> <?php echo esc_html( $bonus_expiry ); ?>
						</div>
					<?php endif; ?>
					
					<div class="bonus-actions-header">
						<?php if ( $bonus_code ) : ?>
							<div class="bonus-code-box">
								<div class="bonus-code-label"><?php esc_html_e( 'Bonus Code:', 'casino-review-pro' ); ?></div>
								<div class="bonus-code-value">
									<span id="bonus-code-text"><?php echo esc_html( $bonus_code ); ?></span>
									<button class="copy-code-btn" data-clipboard-target="#bonus-code-text">
										<i class="fa-solid fa-copy"></i> <?php esc_html_e( 'Copy', 'casino-review-pro' ); ?>
									</button>
								</div>
							</div>
						<?php endif; ?>
						
						<?php if ( $casino_url ) : ?>
							<a href="<?php echo esc_url( $casino_url ); ?>" class="btn btn-primary btn-lg" target="_blank">
								<i class="fa-solid fa-gift"></i> <?php esc_html_e( 'Claim Bonus', 'casino-review-pro' ); ?>
							</a>
						<?php endif; ?>
					</div>
				</div>
				
				<?php if ( has_post_thumbnail() ) : ?>
					<div class="bonus-logo-large">
						<?php the_post_thumbnail( 'medium', array( 'class' => 'bonus-logo' ) ); ?>
					</div>
				<?php endif; ?>
			</div>
		</div>
	</div>

	<main id="primary" class="site-main">
		<div class="container">
			<div class="row">
				<div class="col-lg-8 main-content">
					<div class="bonus-content">
						<div class="bonus-description">
							<?php the_content(); ?>
						</div>
						
						<?php if ( $bonus_terms ) : ?>
							<div class="bonus-terms-box">
								<h3><?php esc_html_e( 'Terms & Conditions', 'casino-review-pro' ); ?></h3>
								<div class="bonus-terms-content">
									<?php echo wp_kses_post( wpautop( $bonus_terms ) ); ?>
								</div>
							</div>
						<?php endif; ?>
						
						<?php
						// Get bonus type terms
						$bonus_types = get_the_terms( get_the_ID(), 'bonus_type' );
						if ( ! empty( $bonus_types ) && ! is_wp_error( $bonus_types ) ) :
						?>
							<div class="bonus-types">
								<h3><?php esc_html_e( 'Bonus Type', 'casino-review-pro' ); ?></h3>
								<div class="bonus-types-list">
									<?php foreach ( $bonus_types as $type ) : ?>
										<a href="<?php echo esc_url( get_term_link( $type ) ); ?>" class="bonus-type-badge">
											<?php echo esc_html( $type->name ); ?>
										</a>
									<?php endforeach; ?>
								</div>
							</div>
						<?php endif; ?>
						
						<?php if ( $bonus_casino ) : ?>
							<div class="bonus-casino-box">
								<h3><?php esc_html_e( 'About the Casino', 'casino-review-pro' ); ?></h3>
								
								<?php 
								$casino_excerpt = get_post_field( 'post_excerpt', $bonus_casino );
								if ( ! empty( $casino_excerpt ) ) :
								?>
									<div class="casino-excerpt">
										<?php echo wp_kses_post( wpautop( $casino_excerpt ) ); ?>
									</div>
								<?php endif; ?>
								
								<?php if ( has_post_thumbnail( $bonus_casino ) ) : ?>
									<div class="casino-thumbnail">
										<?php echo get_the_post_thumbnail( $bonus_casino, 'casino-logo' ); ?>
									</div>
								<?php endif; ?>
								
								<div class="casino-meta-bonus">
									<?php
									// Get casino meta information
									$established = get_post_meta( $bonus_casino, '_casino_established', true );
									$min_deposit = get_post_meta( $bonus_casino, '_casino_min_deposit', true );
									$withdrawal_time = get_post_meta( $bonus_casino, '_casino_withdrawal_time', true );
									?>
									
									<?php if ( $established ) : ?>
										<div class="meta-item">
											<i class="fa-solid fa-calendar-days"></i>
											<span><?php esc_html_e( 'Established:', 'casino-review-pro' ); ?> <?php echo esc_html( $established ); ?></span>
										</div>
									<?php endif; ?>
									
									<?php if ( $min_deposit ) : ?>
										<div class="meta-item">
											<i class="fa-solid fa-money-bill-1"></i>
											<span><?php esc_html_e( 'Min. Deposit:', 'casino-review-pro' ); ?> <?php echo esc_html( $min_deposit ); ?></span>
										</div>
									<?php endif; ?>
									
									<?php if ( $withdrawal_time ) : ?>
										<div class="meta-item">
											<i class="fa-solid fa-clock"></i>
											<span><?php esc_html_e( 'Withdrawal Time:', 'casino-review-pro' ); ?> <?php echo esc_html( $withdrawal_time ); ?></span>
										</div>
									<?php endif; ?>
								</div>
								
								<div class="casino-actions">
									<a href="<?php echo esc_url( get_permalink( $bonus_casino ) ); ?>" class="btn btn-outline">
										<?php esc_html_e( 'Read Review', 'casino-review-pro' ); ?>
									</a>
									
									<?php if ( $casino_url ) : ?>
										<a href="<?php echo esc_url( $casino_url ); ?>" class="btn btn-primary" target="_blank">
											<?php esc_html_e( 'Visit Casino', 'casino-review-pro' ); ?>
										</a>
									<?php endif; ?>
								</div>
							</div>
						<?php endif; ?>
						
						<?php
						// Get similar bonuses
						if ( ! empty( $bonus_types ) && ! is_wp_error( $bonus_types ) ) {
							$type_ids = wp_list_pluck( $bonus_types, 'term_id' );
							
							$similar_bonuses = new WP_Query( array(
								'post_type'      => 'bonus',
								'posts_per_page' => 3,
								'post__not_in'   => array( get_the_ID() ),
								'tax_query'      => array(
									array(
										'taxonomy' => 'bonus_type',
										'field'    => 'term_id',
										'terms'    => $type_ids,
									),
								),
								'orderby'        => 'rand',
							) );
							
							if ( $similar_bonuses->have_posts() ) :
							?>
								<div class="similar-bonuses">
									<h3><?php esc_html_e( 'Similar Bonus Offers', 'casino-review-pro' ); ?></h3>
									
									<div class="bonus-cards">
										<?php while ( $similar_bonuses->have_posts() ) : $similar_bonuses->the_post(); ?>
											<?php
											$similar_bonus_value = get_post_meta( get_the_ID(), '_bonus_value', true );
											$similar_bonus_casino = get_post_meta( get_the_ID(), '_bonus_casino', true );
											$similar_casino_name = $similar_bonus_casino ? get_the_title( $similar_bonus_casino ) : '';
											$similar_casino_url = $similar_bonus_casino ? get_post_meta( $similar_bonus_casino, '_casino_website_url', true ) : '';
											?>
											
											<div class="bonus-card">
												<div class="bonus-header">
													<h4 class="bonus-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>
													
													<?php if ( $similar_bonus_value ) : ?>
														<div class="bonus-value"><?php echo esc_html( $similar_bonus_value ); ?></div>
													<?php endif; ?>
												</div>
												
												<?php if ( $similar_casino_name ) : ?>
													<div class="bonus-casino-name"><?php echo esc_html( $similar_casino_name ); ?></div>
												<?php endif; ?>
												
												<div class="bonus-description">
													<?php the_excerpt(); ?>
												</div>
												
												<div class="bonus-cta">
													<a href="<?php the_permalink(); ?>" class="btn btn-outline btn-sm"><?php esc_html_e( 'View Details', 'casino-review-pro' ); ?></a>
													
													<?php if ( $similar_casino_url ) : ?>
														<a href="<?php echo esc_url( $similar_casino_url ); ?>" class="btn btn-primary btn-sm" target="_blank">
															<?php esc_html_e( 'Claim Bonus', 'casino-review-pro' ); ?>
														</a>
													<?php endif; ?>
												</div>
											</div>
										<?php endwhile; wp_reset_postdata(); ?>
									</div>
								</div>
							<?php endif; ?>
						<?php } ?>
					</div><!-- .bonus-content -->
					
					<?php
					// If comments are open or we have at least one comment, load up the comment template.
					if ( comments_open() || get_comments_number() ) :
						comments_template();
					endif;
					?>
					
				</div><!-- .main-content -->
				
				<div class="col-lg-4 sidebar">
					<div class="bonus-sidebar">
						<?php if ( $bonus_terms ) : ?>
							<div class="widget bonus-terms-widget">
								<h3 class="widget-title"><?php esc_html_e( 'Key Terms', 'casino-review-pro' ); ?></h3>
								<div class="widget-content">
									<?php 
									// Display a summarized version of the terms
									$terms_excerpt = wp_trim_words( $bonus_terms, 40, '...' );
									echo wpautop( $terms_excerpt );
									?>
									<button class="btn btn-outline btn-sm read-full-terms"><?php esc_html_e( 'Read Full Terms', 'casino-review-pro' ); ?></button>
								</div>
							</div>
						<?php endif; ?>
						
						<?php if ( $bonus_casino ) : ?>
							<div class="widget bonus-casino-widget">
								<h3 class="widget-title"><?php esc_html_e( 'Casino Information', 'casino-review-pro' ); ?></h3>
								<div class="widget-content">
									<div class="casino-logo-medium">
										<?php echo get_the_post_thumbnail( $bonus_casino, 'medium' ); ?>
									</div>
									
									<h4 class="casino-name">
										<a href="<?php echo esc_url( get_permalink( $bonus_casino ) ); ?>">
											<?php echo esc_html( get_the_title( $bonus_casino ) ); ?>
										</a>
									</h4>
									
									<?php if ( $casino_rating ) : ?>
										<div class="casino-rating">
											<?php echo casino_review_rating_stars( $casino_rating, 10 ); ?>
											<span class="rating-text"><?php echo esc_html( $casino_rating ); ?>/10</span>
										</div>
									<?php endif; ?>
									
									<?php if ( $casino_url ) : ?>
										<a href="<?php echo esc_url( $casino_url ); ?>" class="btn btn-primary btn-block" target="_blank">
											<?php esc_html_e( 'Visit Casino', 'casino-review-pro' ); ?>
										</a>
									<?php endif; ?>
								</div>
							</div>
						<?php endif; ?>
						
						<div class="widget latest-bonuses-widget">
							<h3 class="widget-title"><?php esc_html_e( 'Latest Bonus Offers', 'casino-review-pro' ); ?></h3>
							<?php
							$latest_bonuses = new WP_Query( array(
								'post_type'      => 'bonus',
								'posts_per_page' => 5,
								'post__not_in'   => array( get_the_ID() ),
							) );
							
							if ( $latest_bonuses->have_posts() ) :
							?>
								<div class="widget-content">
									<ul class="latest-bonuses-list">
										<?php while ( $latest_bonuses->have_posts() ) : $latest_bonuses->the_post(); ?>
											<?php
											$latest_bonus_value = get_post_meta( get_the_ID(), '_bonus_value', true );
											$latest_bonus_casino = get_post_meta( get_the_ID(), '_bonus_casino', true );
											$latest_casino_name = $latest_bonus_casino ? get_the_title( $latest_bonus_casino ) : '';
											?>
											<li class="latest-bonus-item">
												<a href="<?php the_permalink(); ?>" class="latest-bonus-link">
													<div class="latest-bonus-title"><?php the_title(); ?></div>
													
													<?php if ( $latest_bonus_value ) : ?>
														<div class="latest-bonus-value"><?php echo esc_html( $latest_bonus_value ); ?></div>
													<?php endif; ?>
													
													<?php if ( $latest_casino_name ) : ?>
														<div class="latest-bonus-casino"><?php echo esc_html( $latest_casino_name ); ?></div>
													<?php endif; ?>
												</a>
											</li>
										<?php endwhile; wp_reset_postdata(); ?>
									</ul>
									
									<a href="<?php echo esc_url( get_post_type_archive_link( 'bonus' ) ); ?>" class="btn btn-outline btn-sm btn-block">
										<?php esc_html_e( 'View All Bonuses', 'casino-review-pro' ); ?>
									</a>
								</div>
							<?php else : ?>
								<div class="widget-content">
									<p><?php esc_html_e( 'No bonus offers found.', 'casino-review-pro' ); ?></p>
								</div>
							<?php endif; ?>
						</div>
						
						<?php get_sidebar(); ?>
					</div><!-- .bonus-sidebar -->
				</div><!-- .sidebar -->
			</div><!-- .row -->
		</div><!-- .container -->
	</main><!-- #main -->

<?php
endwhile; // End of the loop.

get_footer();
