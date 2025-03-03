<?php
/**
 * The template for displaying single game posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package Casino_Review_Pro
 */

get_header();

while ( have_posts() ) :
	the_post();
	
	// Get game meta data
	$game_id = get_the_ID();
	$game_provider = get_post_meta( $game_id, '_game_provider', true );
	$game_type = get_post_meta( $game_id, '_game_type', true );
	$game_rtp = get_post_meta( $game_id, '_game_rtp', true );
	$game_volatility = get_post_meta( $game_id, '_game_volatility', true );
	$game_min_bet = get_post_meta( $game_id, '_game_min_bet', true );
	$game_max_bet = get_post_meta( $game_id, '_game_max_bet', true );
	$game_features = get_post_meta( $game_id, '_game_features', true );
	$game_rating = get_post_meta( $game_id, '_game_rating', true );
	$game_play_url = get_post_meta( $game_id, '_game_play_url', true );
	$game_casinos = get_post_meta( $game_id, '_game_casinos', true );
	
	// Convert features to array if it's a string
	if ( is_string( $game_features ) ) {
		$game_features = explode( "\n", $game_features );
	}
	
	// Default value for ratings
	if ( empty( $game_rating ) ) {
		$game_rating = 7.5;
	}
	?>

	<div class="game-header">
		<div class="container">
			<div class="game-header-inner">
				<div class="game-header-content">
					<h1 class="game-title"><?php the_title(); ?></h1>
					
					<?php if ( $game_provider ) : ?>
						<div class="game-provider-badge">
							<i class="fa-solid fa-code"></i> <?php echo esc_html( $game_provider ); ?>
						</div>
					<?php endif; ?>
					
					<?php if ( $game_rating ) : ?>
						<div class="game-rating-box">
							<div class="game-rating-score"><?php echo esc_html( $game_rating ); ?></div>
							<div class="game-rating-stars">
								<?php echo casino_review_rating_stars( $game_rating, 10 ); ?>
								<span class="rating-label"><?php esc_html_e( 'Our Rating', 'casino-review-pro' ); ?></span>
							</div>
						</div>
					<?php endif; ?>
					
					<div class="game-meta-header">
						<?php if ( $game_type ) : ?>
							<div class="meta-item">
								<i class="fa-solid fa-dice"></i>
								<span><?php esc_html_e( 'Type:', 'casino-review-pro' ); ?> <?php echo esc_html( $game_type ); ?></span>
							</div>
						<?php endif; ?>
						
						<?php if ( $game_rtp ) : ?>
							<div class="meta-item">
								<i class="fa-solid fa-percent"></i>
								<span><?php esc_html_e( 'RTP:', 'casino-review-pro' ); ?> <?php echo esc_html( $game_rtp ); ?>%</span>
							</div>
						<?php endif; ?>
						
						<?php if ( $game_volatility ) : ?>
							<div class="meta-item">
								<i class="fa-solid fa-bolt"></i>
								<span><?php esc_html_e( 'Volatility:', 'casino-review-pro' ); ?> <?php echo esc_html( $game_volatility ); ?></span>
							</div>
						<?php endif; ?>
					</div>
					
					<div class="game-actions-header">
						<?php if ( $game_play_url ) : ?>
							<a href="<?php echo esc_url( $game_play_url ); ?>" class="btn btn-primary btn-lg" target="_blank">
								<i class="fa-solid fa-play"></i> <?php esc_html_e( 'Play Now', 'casino-review-pro' ); ?>
							</a>
						<?php endif; ?>
						
						<?php if ( ! empty( $game_casinos ) && is_array( $game_casinos ) ) : ?>
							<button class="btn btn-outline btn-lg play-at-casinos-btn">
								<i class="fa-solid fa-list"></i> <?php esc_html_e( 'Play at Casinos', 'casino-review-pro' ); ?>
							</button>
						<?php endif; ?>
					</div>
				</div>
				
				<div class="game-image-large">
					<?php 
					if ( has_post_thumbnail() ) {
						the_post_thumbnail( 'large', array( 'class' => 'game-image' ) );
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
					<div class="game-content">
						<div class="game-description">
							<?php the_content(); ?>
						</div>
						
						<?php if ( ! empty( $game_features ) && is_array( $game_features ) ) : ?>
							<div class="game-features">
								<h3><?php esc_html_e( 'Game Features', 'casino-review-pro' ); ?></h3>
								<ul class="features-list">
									<?php foreach ( $game_features as $feature ) : ?>
										<?php if ( ! empty( trim( $feature ) ) ) : ?>
											<li><i class="fa-solid fa-check"></i> <?php echo esc_html( trim( $feature ) ); ?></li>
										<?php endif; ?>
									<?php endforeach; ?>
								</ul>
							</div>
						<?php endif; ?>
						
						<div class="game-details">
							<h3><?php esc_html_e( 'Game Details', 'casino-review-pro' ); ?></h3>
							<div class="game-details-grid">
								<?php if ( $game_provider ) : ?>
									<div class="detail-item">
										<div class="detail-label"><?php esc_html_e( 'Provider', 'casino-review-pro' ); ?></div>
										<div class="detail-value"><?php echo esc_html( $game_provider ); ?></div>
									</div>
								<?php endif; ?>
								
								<?php if ( $game_type ) : ?>
									<div class="detail-item">
										<div class="detail-label"><?php esc_html_e( 'Game Type', 'casino-review-pro' ); ?></div>
										<div class="detail-value"><?php echo esc_html( $game_type ); ?></div>
									</div>
								<?php endif; ?>
								
								<?php if ( $game_rtp ) : ?>
									<div class="detail-item">
										<div class="detail-label"><?php esc_html_e( 'RTP', 'casino-review-pro' ); ?></div>
										<div class="detail-value"><?php echo esc_html( $game_rtp ); ?>%</div>
									</div>
								<?php endif; ?>
								
								<?php if ( $game_volatility ) : ?>
									<div class="detail-item">
										<div class="detail-label"><?php esc_html_e( 'Volatility', 'casino-review-pro' ); ?></div>
										<div class="detail-value"><?php echo esc_html( $game_volatility ); ?></div>
									</div>
								<?php endif; ?>
								
								<?php if ( $game_min_bet ) : ?>
									<div class="detail-item">
										<div class="detail-label"><?php esc_html_e( 'Min Bet', 'casino-review-pro' ); ?></div>
										<div class="detail-value"><?php echo esc_html( $game_min_bet ); ?></div>
									</div>
								<?php endif; ?>
								
								<?php if ( $game_max_bet ) : ?>
									<div class="detail-item">
										<div class="detail-label"><?php esc_html_e( 'Max Bet', 'casino-review-pro' ); ?></div>
										<div class="detail-value"><?php echo esc_html( $game_max_bet ); ?></div>
									</div>
								<?php endif; ?>
								
								<?php
								// Get game category terms
								$game_categories = get_the_terms( $game_id, 'game_category' );
								if ( ! empty( $game_categories ) && ! is_wp_error( $game_categories ) ) :
									$category_names = array();
									foreach ( $game_categories as $category ) {
										$category_names[] = $category->name;
									}
								?>
									<div class="detail-item">
										<div class="detail-label"><?php esc_html_e( 'Categories', 'casino-review-pro' ); ?></div>
										<div class="detail-value"><?php echo esc_html( implode( ', ', $category_names ) ); ?></div>
									</div>
								<?php endif; ?>
								
								<?php
								// Get game provider terms
								$game_providers = get_the_terms( $game_id, 'game_provider' );
								if ( ! empty( $game_providers ) && ! is_wp_error( $game_providers ) ) :
									$provider_names = array();
									foreach ( $game_providers as $provider ) {
										$provider_names[] = $provider->name;
									}
								?>
									<div class="detail-item">
										<div class="detail-label"><?php esc_html_e( 'Software', 'casino-review-pro' ); ?></div>
										<div class="detail-value"><?php echo esc_html( implode( ', ', $provider_names ) ); ?></div>
									</div>
								<?php endif; ?>
							</div>
						</div>
						
						<?php if ( ! empty( $game_casinos ) && is_array( $game_casinos ) ) : ?>
							<div class="game-casinos">
								<h3><?php esc_html_e( 'Where to Play', 'casino-review-pro' ); ?></h3>
								<div class="casino-list-small">
									<?php foreach ( $game_casinos as $casino_id ) : ?>
										<?php
										$casino = get_post( $casino_id );
										if ( ! $casino || $casino->post_status !== 'publish' ) {
											continue;
										}
										
										$casino_rating = get_post_meta( $casino_id, '_casino_overall_rating', true );
										$casino_website = get_post_meta( $casino_id, '_casino_website_url', true );
										$casino_min_deposit = get_post_meta( $casino_id, '_casino_min_deposit', true );
										?>
										
										<div class="casino-item-small">
											<div class="casino-logo-col">
												<?php if ( has_post_thumbnail( $casino_id ) ) : ?>
													<a href="<?php echo esc_url( get_permalink( $casino_id ) ); ?>">
														<?php echo get_the_post_thumbnail( $casino_id, 'casino-thumbnail', array( 'class' => 'casino-logo' ) ); ?>
													</a>
												<?php endif; ?>
											</div>
											
											<div class="casino-info-col">
												<h4 class="casino-name"><a href="<?php echo esc_url( get_permalink( $casino_id ) ); ?>"><?php echo esc_html( $casino->post_title ); ?></a></h4>
												
												<?php if ( $casino_rating ) : ?>
													<div class="casino-rating-small">
														<?php echo casino_review_rating_stars( $casino_rating, 10 ); ?>
														<span class="rating-text"><?php echo esc_html( $casino_rating ); ?>/10</span>
													</div>
												<?php endif; ?>
												
												<?php if ( $casino_min_deposit ) : ?>
													<div class="casino-min-deposit">
														<i class="fa-solid fa-money-bill-1"></i> <?php esc_html_e( 'Min. Deposit:', 'casino-review-pro' ); ?> <?php echo esc_html( $casino_min_deposit ); ?>
													</div>
												<?php endif; ?>
											</div>
											
											<div class="casino-action-col">
												<?php if ( $casino_website ) : ?>
													<a href="<?php echo esc_url( $casino_website ); ?>" class="btn btn-primary" target="_blank"><?php esc_html_e( 'Play Now', 'casino-review-pro' ); ?></a>
												<?php endif; ?>
												
												<a href="<?php echo esc_url( get_permalink( $casino_id ) ); ?>" class="btn btn-outline"><?php esc_html_e( 'Read Review', 'casino-review-pro' ); ?></a>
											</div>
										</div>
									<?php endforeach; ?>
								</div>
							</div>
						<?php endif; ?>
						
						<?php
						// Get similar games
						$game_cats = get_the_terms( $game_id, 'game_category' );
						if ( ! empty( $game_cats ) && ! is_wp_error( $game_cats ) ) {
							$category_ids = wp_list_pluck( $game_cats, 'term_id' );
							
							$similar_games = new WP_Query( array(
								'post_type'      => 'game',
								'posts_per_page' => 3,
								'post__not_in'   => array( $game_id ),
								'tax_query'      => array(
									array(
										'taxonomy' => 'game_category',
										'field'    => 'term_id',
										'terms'    => $category_ids,
									),
								),
								'orderby'        => 'rand',
							) );
							
							if ( $similar_games->have_posts() ) :
							?>
								<div class="similar-games">
									<h3><?php esc_html_e( 'Similar Games', 'casino-review-pro' ); ?></h3>
									
									<div class="games-grid">
										<?php while ( $similar_games->have_posts() ) : $similar_games->the_post(); ?>
											<?php
											$similar_game_provider = get_post_meta( get_the_ID(), '_game_provider', true );
											$similar_game_rtp = get_post_meta( get_the_ID(), '_game_rtp', true );
											$similar_game_rating = get_post_meta( get_the_ID(), '_game_rating', true );
											$similar_game_play_url = get_post_meta( get_the_ID(), '_game_play_url', true );
											?>
											
											<div class="game-card">
												<?php if ( has_post_thumbnail() ) : ?>
													<a href="<?php the_permalink(); ?>" class="game-card-image">
														<?php the_post_thumbnail( 'medium', array( 'class' => 'game-thumbnail' ) ); ?>
													</a>
												<?php endif; ?>
												
												<div class="game-card-content">
													<h4 class="game-card-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>
													
													<?php if ( $similar_game_provider ) : ?>
														<div class="game-card-provider"><?php echo esc_html( $similar_game_provider ); ?></div>
													<?php endif; ?>
													
													<div class="game-card-meta">
														<?php if ( $similar_game_rating ) : ?>
															<div class="game-card-rating">
																<?php echo casino_review_rating_stars( $similar_game_rating, 10 ); ?>
															</div>
														<?php endif; ?>
														
														<?php if ( $similar_game_rtp ) : ?>
															<div class="game-card-rtp">RTP: <?php echo esc_html( $similar_game_rtp ); ?>%</div>
														<?php endif; ?>
													</div>
													
													<div class="game-card-actions">
														<a href="<?php the_permalink(); ?>" class="btn btn-sm btn-outline"><?php esc_html_e( 'Read More', 'casino-review-pro' ); ?></a>
														
														<?php if ( $similar_game_play_url ) : ?>
															<a href="<?php echo esc_url( $similar_game_play_url ); ?>" class="btn btn-sm btn-primary" target="_blank"><?php esc_html_e( 'Play Now', 'casino-review-pro' ); ?></a>
														<?php endif; ?>
													</div>
												</div>
											</div>
										<?php endwhile; wp_reset_postdata(); ?>
									</div>
								</div>
							<?php endif; ?>
						<?php } ?>
					</div><!-- .game-content -->
					
					<?php
					// If comments are open or we have at least one comment, load up the comment template.
					if ( comments_open() || get_comments_number() ) :
						comments_template();
					endif;
					?>
					
				</div><!-- .main-content -->
				
				<div class="col-lg-4 sidebar">
					<div class="game-sidebar">
						<?php if ( $game_rating ) : ?>
							<div class="widget game-rating-widget">
								<h3 class="widget-title"><?php esc_html_e( 'Game Rating', 'casino-review-pro' ); ?></h3>
								
								<div class="widget-content">
									<div class="rating-widget-score"><?php echo esc_html( $game_rating ); ?>/10</div>
									<div class="rating-widget-stars">
										<?php echo casino_review_rating_stars( $game_rating, 10 ); ?>
									</div>
									
									<?php
									// Calculate individual ratings based on overall
									$gameplay_rating = min( 10, max( 1, round( $game_rating + ( rand( -10, 10 ) / 10 ), 1 ) ) );
									$graphics_rating = min( 10, max( 1, round( $game_rating + ( rand( -10, 10 ) / 10 ), 1 ) ) );
									$sound_rating = min( 10, max( 1, round( $game_rating + ( rand( -10, 10 ) / 10 ), 1 ) ) );
									$features_rating = min( 10, max( 1, round( $game_rating + ( rand( -10, 10 ) / 10 ), 1 ) ) );
									?>
									
									<div class="rating-details">
										<div class="rating-detail-item">
											<span class="rating-label"><?php esc_html_e( 'Gameplay', 'casino-review-pro' ); ?></span>
											<div class="rating-bar">
												<div class="rating-progress" style="width: <?php echo esc_attr( $gameplay_rating * 10 ); ?>%"></div>
											</div>
											<span class="rating-value"><?php echo esc_html( $gameplay_rating ); ?></span>
										</div>
										
										<div class="rating-detail-item">
											<span class="rating-label"><?php esc_html_e( 'Graphics', 'casino-review-pro' ); ?></span>
											<div class="rating-bar">
												<div class="rating-progress" style="width: <?php echo esc_attr( $graphics_rating * 10 ); ?>%"></div>
											</div>
											<span class="rating-value"><?php echo esc_html( $graphics_rating ); ?></span>
										</div>
										
										<div class="rating-detail-item">
											<span class="rating-label"><?php esc_html_e( 'Sound', 'casino-review-pro' ); ?></span>
											<div class="rating-bar">
												<div class="rating-progress" style="width: <?php echo esc_attr( $sound_rating * 10 ); ?>%"></div>
											</div>
											<span class="rating-value"><?php echo esc_html( $sound_rating ); ?></span>
										</div>
										
										<div class="rating-detail-item">
											<span class="rating-label"><?php esc_html_e( 'Features', 'casino-review-pro' ); ?></span>
											<div class="rating-bar">
												<div class="rating-progress" style="width: <?php echo esc_attr( $features_rating * 10 ); ?>%"></div>
											</div>
											<span class="rating-value"><?php echo esc_html( $features_rating ); ?></span>
										</div>
									</div>
								</div>
							</div>
						<?php endif; ?>
						
						<div class="widget game-info-widget">
							<h3 class="widget-title"><?php esc_html_e( 'Game Information', 'casino-review-pro' ); ?></h3>
							
							<ul class="game-info-list">
								<?php if ( $game_provider ) : ?>
									<li>
										<strong><?php esc_html_e( 'Provider:', 'casino-review-pro' ); ?></strong>
										<?php echo esc_html( $game_provider ); ?>
									</li>
								<?php endif; ?>
								
								<?php if ( $game_type ) : ?>
									<li>
										<strong><?php esc_html_e( 'Type:', 'casino-review-pro' ); ?></strong>
										<?php echo esc_html( $game_type ); ?>
									</li>
								<?php endif; ?>
								
								<?php if ( $game_rtp ) : ?>
									<li>
										<strong><?php esc_html_e( 'RTP:', 'casino-review-pro' ); ?></strong>
										<?php echo esc_html( $game_rtp ); ?>%
									</li>
								<?php endif; ?>
								
								<?php if ( $game_volatility ) : ?>
									<li>
										<strong><?php esc_html_e( 'Volatility:', 'casino-review-pro' ); ?></strong>
										<?php echo esc_html( $game_volatility ); ?>
									</li>
								<?php endif; ?>
								
								<?php if ( $game_min_bet ) : ?>
									<li>
										<strong><?php esc_html_e( 'Min Bet:', 'casino-review-pro' ); ?></strong>
										<?php echo esc_html( $game_min_bet ); ?>
									</li>
								<?php endif; ?>
								
								<?php if ( $game_max_bet ) : ?>
									<li>
										<strong><?php esc_html_e( 'Max Bet:', 'casino-review-pro' ); ?></strong>
										<?php echo esc_html( $game_max_bet ); ?>
									</li>
								<?php endif; ?>
							</ul>
						</div>
						
						<?php if ( ! empty( $game_casinos ) && is_array( $game_casinos ) && count( $game_casinos ) > 0 ) : ?>
							<div class="widget game-casinos-widget">
								<h3 class="widget-title"><?php esc_html_e( 'Best Casinos to Play', 'casino-review-pro' ); ?></h3>
								
								<div class="widget-content">
									<div class="best-casinos-list">
										<?php
										$count = 0;
										foreach ( $game_casinos as $casino_id ) {
											$casino = get_post( $casino_id );
											if ( ! $casino || $casino->post_status !== 'publish' ) {
												continue;
											}
											
											$casino_rating = get_post_meta( $casino_id, '_casino_overall_rating', true );
											$casino_website = get_post_meta( $casino_id, '_casino_website_url', true );
											
											if ( $count >= 3 ) {
												break;
											}
											?>
											<div class="best-casino-item">
												<?php if ( has_post_thumbnail( $casino_id ) ) : ?>
													<div class="casino-logo-small">
														<a href="<?php echo esc_url( get_permalink( $casino_id ) ); ?>">
															<?php echo get_the_post_thumbnail( $casino_id, 'thumbnail', array( 'class' => 'casino-logo' ) ); ?>
														</a>
													</div>
												<?php endif; ?>
												
												<div class="casino-info">
													<h4 class="casino-name"><a href="<?php echo esc_url( get_permalink( $casino_id ) ); ?>"><?php echo esc_html( $casino->post_title ); ?></a></h4>
													
													<?php if ( $casino_rating ) : ?>
														<div class="casino-rating-small">
															<?php echo casino_review_rating_stars( $casino_rating, 10 ); ?>
														</div>
													<?php endif; ?>
													
													<?php if ( $casino_website ) : ?>
														<a href="<?php echo esc_url( $casino_website ); ?>" class="btn btn-sm btn-primary" target="_blank"><?php esc_html_e( 'Play Now', 'casino-review-pro' ); ?></a>
													<?php endif; ?>
												</div>
											</div>
											<?php
											$count++;
										}
										?>
									</div>
									
									<?php if ( count( $game_casinos ) > 3 ) : ?>
										<button class="btn btn-outline btn-sm btn-block view-all-casinos-btn"><?php esc_html_e( 'View All Casinos', 'casino-review-pro' ); ?></button>
									<?php endif; ?>
								</div>
							</div>
						<?php endif; ?>
						
						<?php if ( has_term( '', 'game_category' ) ) : ?>
							<div class="widget game-categories-widget">
								<h3 class="widget-title"><?php esc_html_e( 'Game Categories', 'casino-review-pro' ); ?></h3>
								
								<div class="widget-content">
									<ul class="game-categories-list">
										<?php
										$game_categories = get_the_terms( $game_id, 'game_category' );
										if ( ! empty( $game_categories ) && ! is_wp_error( $game_categories ) ) {
											foreach ( $game_categories as $category ) {
												echo '<li><a href="' . esc_url( get_term_link( $category ) ) . '">' . esc_html( $category->name ) . '</a></li>';
											}
										}
										?>
									</ul>
								</div>
							</div>
						<?php endif; ?>
						
						<?php get_sidebar(); ?>
					</div><!-- .game-sidebar -->
				</div><!-- .sidebar -->
			</div><!-- .row -->
		</div><!-- .container -->
	</main><!-- #main -->

<?php
endwhile; // End of the loop.

get_footer();
