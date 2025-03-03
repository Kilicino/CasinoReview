<?php
/**
 * The template for displaying game archive pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Casino_Review_Pro
 */

get_header();
?>

<main id="primary" class="site-main">
	<div class="container">
		<div class="game-archive-header">
			<h1 class="archive-title"><?php post_type_archive_title(); ?></h1>
			<div class="archive-description">
				<?php the_archive_description(); ?>
			</div>
		</div>
		
		<div class="filter-bar">
			<form class="filter-form" method="get" action="<?php echo esc_url( get_post_type_archive_link( 'game' ) ); ?>">
				<div class="filter-group">
					<label for="filter-category" class="filter-label"><?php esc_html_e( 'Category', 'casino-review-pro' ); ?></label>
					<select id="filter-category" name="game_category" class="filter-select">
						<option value=""><?php esc_html_e( 'All Categories', 'casino-review-pro' ); ?></option>
						<?php
						$categories = get_terms( array(
							'taxonomy' => 'game_category',
							'hide_empty' => true,
						) );
						
						if ( ! empty( $categories ) && ! is_wp_error( $categories ) ) {
							foreach ( $categories as $category ) {
								$selected = isset( $_GET['game_category'] ) && $_GET['game_category'] === $category->slug ? 'selected' : '';
								echo '<option value="' . esc_attr( $category->slug ) . '" ' . $selected . '>' . esc_html( $category->name ) . '</option>';
							}
						}
						?>
					</select>
				</div>
				
				<div class="filter-group">
					<label for="filter-provider" class="filter-label"><?php esc_html_e( 'Provider', 'casino-review-pro' ); ?></label>
					<select id="filter-provider" name="game_provider" class="filter-select">
						<option value=""><?php esc_html_e( 'All Providers', 'casino-review-pro' ); ?></option>
						<?php
						$providers = get_terms( array(
							'taxonomy' => 'game_provider',
							'hide_empty' => true,
						) );
						
						if ( ! empty( $providers ) && ! is_wp_error( $providers ) ) {
							foreach ( $providers as $provider ) {
								$selected = isset( $_GET['game_provider'] ) && $_GET['game_provider'] === $provider->slug ? 'selected' : '';
								echo '<option value="' . esc_attr( $provider->slug ) . '" ' . $selected . '>' . esc_html( $provider->name ) . '</option>';
							}
						}
						?>
					</select>
				</div>
				
				<div class="filter-group">
					<label for="filter-type" class="filter-label"><?php esc_html_e( 'Game Type', 'casino-review-pro' ); ?></label>
					<select id="filter-type" name="game_type" class="filter-select">
						<option value=""><?php esc_html_e( 'All Types', 'casino-review-pro' ); ?></option>
						<?php
						// Get distinct game types from meta
						global $wpdb;
						$game_types = $wpdb->get_col(
							"SELECT DISTINCT meta_value FROM {$wpdb->postmeta}
							WHERE meta_key = '_game_type'
							AND meta_value != ''
							ORDER BY meta_value ASC"
						);
						
						if ( ! empty( $game_types ) ) {
							foreach ( $game_types as $type ) {
								$selected = isset( $_GET['game_type'] ) && $_GET['game_type'] === sanitize_title( $type ) ? 'selected' : '';
								echo '<option value="' . esc_attr( sanitize_title( $type ) ) . '" ' . $selected . '>' . esc_html( $type ) . '</option>';
							}
						}
						?>
					</select>
				</div>
				
				<div class="filter-group">
					<label for="filter-volatility" class="filter-label"><?php esc_html_e( 'Volatility', 'casino-review-pro' ); ?></label>
					<select id="filter-volatility" name="volatility" class="filter-select">
						<option value=""><?php esc_html_e( 'Any Volatility', 'casino-review-pro' ); ?></option>
						<option value="low" <?php selected( isset( $_GET['volatility'] ) ? $_GET['volatility'] : '', 'low' ); ?>><?php esc_html_e( 'Low', 'casino-review-pro' ); ?></option>
						<option value="medium" <?php selected( isset( $_GET['volatility'] ) ? $_GET['volatility'] : '', 'medium' ); ?>><?php esc_html_e( 'Medium', 'casino-review-pro' ); ?></option>
						<option value="high" <?php selected( isset( $_GET['volatility'] ) ? $_GET['volatility'] : '', 'high' ); ?>><?php esc_html_e( 'High', 'casino-review-pro' ); ?></option>
						<option value="very-high" <?php selected( isset( $_GET['volatility'] ) ? $_GET['volatility'] : '', 'very-high' ); ?>><?php esc_html_e( 'Very High', 'casino-review-pro' ); ?></option>
					</select>
				</div>
				
				<div class="filter-group">
					<label for="filter-sort" class="filter-label"><?php esc_html_e( 'Sort By', 'casino-review-pro' ); ?></label>
					<select id="filter-sort" name="orderby" class="filter-select">
						<option value="rating" <?php selected( isset( $_GET['orderby'] ) ? $_GET['orderby'] : 'rating', 'rating' ); ?>><?php esc_html_e( 'Rating (High to Low)', 'casino-review-pro' ); ?></option>
						<option value="date" <?php selected( isset( $_GET['orderby'] ) ? $_GET['orderby'] : '', 'date' ); ?>><?php esc_html_e( 'Newest First', 'casino-review-pro' ); ?></option>
						<option value="title" <?php selected( isset( $_GET['orderby'] ) ? $_GET['orderby'] : '', 'title' ); ?>><?php esc_html_e( 'Name (A-Z)', 'casino-review-pro' ); ?></option>
						<option value="rtp" <?php selected( isset( $_GET['orderby'] ) ? $_GET['orderby'] : '', 'rtp' ); ?>><?php esc_html_e( 'RTP (High to Low)', 'casino-review-pro' ); ?></option>
					</select>
				</div>
				
				<button type="submit" class="filter-submit"><?php esc_html_e( 'Apply Filters', 'casino-review-pro' ); ?></button>
			</form>
		</div>
		
		<div class="row">
			<div class="col-lg-8 main-content">
				<?php
				$paged = get_query_var( 'paged' ) ? get_query_var( 'paged' ) : 1;
				$args = array(
					'post_type'      => 'game',
					'posts_per_page' => 12,
					'paged'          => $paged,
				);
				
				// Apply filters from query parameters
				if ( isset( $_GET['game_category'] ) && ! empty( $_GET['game_category'] ) ) {
					$args['tax_query'][] = array(
						'taxonomy' => 'game_category',
						'field'    => 'slug',
						'terms'    => sanitize_text_field( $_GET['game_category'] ),
					);
				}
				
				if ( isset( $_GET['game_provider'] ) && ! empty( $_GET['game_provider'] ) ) {
					$args['tax_query'][] = array(
						'taxonomy' => 'game_provider',
						'field'    => 'slug',
						'terms'    => sanitize_text_field( $_GET['game_provider'] ),
					);
				}
				
				if ( isset( $_GET['game_type'] ) && ! empty( $_GET['game_type'] ) ) {
					// Need to get actual meta value from sanitized slug
					global $wpdb;
					$game_type_value = $wpdb->get_var(
						$wpdb->prepare(
							"SELECT DISTINCT meta_value FROM {$wpdb->postmeta}
							WHERE meta_key = '_game_type'
							AND LOWER(REPLACE(meta_value, ' ', '-')) = %s
							LIMIT 1",
							sanitize_text_field( $_GET['game_type'] )
						)
					);
					
					if ( $game_type_value ) {
						$args['meta_query'][] = array(
							'key'     => '_game_type',
							'value'   => $game_type_value,
							'compare' => '=',
						);
					}
				}
				
				if ( isset( $_GET['volatility'] ) && ! empty( $_GET['volatility'] ) ) {
					$volatility_map = array(
						'low'       => 'Low',
						'medium'    => 'Medium',
						'high'      => 'High',
						'very-high' => 'Very High',
					);
					
					if ( isset( $volatility_map[ $_GET['volatility'] ] ) ) {
						$args['meta_query'][] = array(
							'key'     => '_game_volatility',
							'value'   => $volatility_map[ $_GET['volatility'] ],
							'compare' => '=',
						);
					}
				}
				
				// Set orderby parameter
				if ( isset( $_GET['orderby'] ) ) {
					switch ( $_GET['orderby'] ) {
						case 'rating':
							$args['meta_key'] = '_game_rating';
							$args['orderby']  = 'meta_value_num';
							$args['order']    = 'DESC';
							break;
						case 'date':
							$args['orderby'] = 'date';
							$args['order']   = 'DESC';
							break;
						case 'title':
							$args['orderby'] = 'title';
							$args['order']   = 'ASC';
							break;
						case 'rtp':
							$args['meta_key'] = '_game_rtp';
							$args['orderby']  = 'meta_value_num';
							$args['order']    = 'DESC';
							break;
						default:
							$args['meta_key'] = '_game_rating';
							$args['orderby']  = 'meta_value_num';
							$args['order']    = 'DESC';
					}
				} else {
					// Default sorting by rating
					$args['meta_key'] = '_game_rating';
					$args['orderby']  = 'meta_value_num';
					$args['order']    = 'DESC';
				}
				
				$games_query = new WP_Query( $args );
				
				if ( $games_query->have_posts() ) : ?>
					<div class="games-grid">
						<?php
						while ( $games_query->have_posts() ) :
							$games_query->the_post();
							$game_id = get_the_ID();
							
							// Get game meta data
							$game_provider = get_post_meta( $game_id, '_game_provider', true );
							$game_type = get_post_meta( $game_id, '_game_type', true );
							$game_rtp = get_post_meta( $game_id, '_game_rtp', true );
							$game_volatility = get_post_meta( $game_id, '_game_volatility', true );
							$game_rating = get_post_meta( $game_id, '_game_rating', true );
							$game_play_url = get_post_meta( $game_id, '_game_play_url', true );
							?>
							
							<div class="game-card">
								<?php if ( has_post_thumbnail() ) : ?>
									<a href="<?php the_permalink(); ?>" class="game-card-image">
										<?php the_post_thumbnail( 'medium', array( 'class' => 'game-thumbnail' ) ); ?>
									</a>
								<?php endif; ?>
								
								<div class="game-card-content">
									<h3 class="game-card-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
									
									<?php if ( $game_provider ) : ?>
										<div class="game-card-provider"><?php echo esc_html( $game_provider ); ?></div>
									<?php endif; ?>
									
									<div class="game-card-meta">
										<?php if ( $game_rating ) : ?>
											<div class="game-card-rating">
												<?php echo casino_review_rating_stars( $game_rating, 10 ); ?>
												<span class="rating-text"><?php echo esc_html( $game_rating ); ?>/10</span>
											</div>
										<?php endif; ?>
										
										<?php if ( $game_rtp ) : ?>
											<div class="game-card-rtp">RTP: <?php echo esc_html( $game_rtp ); ?>%</div>
										<?php endif; ?>
										
										<?php if ( $game_volatility ) : ?>
											<div class="game-card-volatility">
												<span class="volatility-label"><?php esc_html_e( 'Volatility:', 'casino-review-pro' ); ?></span>
												<span class="volatility-value"><?php echo esc_html( $game_volatility ); ?></span>
											</div>
										<?php endif; ?>
									</div>
									
									<div class="game-card-actions">
										<a href="<?php the_permalink(); ?>" class="btn btn-sm btn-outline"><?php esc_html_e( 'Read More', 'casino-review-pro' ); ?></a>
										
										<?php if ( $game_play_url ) : ?>
											<a href="<?php echo esc_url( $game_play_url ); ?>" class="btn btn-sm btn-primary" target="_blank"><?php esc_html_e( 'Play Now', 'casino-review-pro' ); ?></a>
										<?php endif; ?>
									</div>
								</div>
							</div>
							
						<?php endwhile; ?>
					</div>
					
					<?php
					// Pagination
					$big = 999999999; // need an unlikely integer
					echo '<div class="pagination">';
					echo paginate_links( array(
						'base'      => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
						'format'    => '?paged=%#%',
						'current'   => max( 1, get_query_var( 'paged' ) ),
						'total'     => $games_query->max_num_pages,
						'prev_text' => '<i class="fa-solid fa-chevron-left"></i> ' . __( 'Previous', 'casino-review-pro' ),
						'next_text' => __( 'Next', 'casino-review-pro' ) . ' <i class="fa-solid fa-chevron-right"></i>',
					) );
					echo '</div>';
					?>
					
				<?php else : ?>
					<div class="no-results">
						<h2><?php esc_html_e( 'No Games Found', 'casino-review-pro' ); ?></h2>
						<p><?php esc_html_e( 'Sorry, no games match your filter criteria. Please try adjusting your filters.', 'casino-review-pro' ); ?></p>
					</div>
				<?php 
				endif;
				wp_reset_postdata();
				?>
			</div><!-- .main-content -->
			
			<div class="col-lg-4 sidebar">
				<?php get_sidebar(); ?>
				
				<div class="widget game-categories-widget">
					<h3 class="widget-title"><?php esc_html_e( 'Game Categories', 'casino-review-pro' ); ?></h3>
					<?php
					$categories = get_terms( array(
						'taxonomy' => 'game_category',
						'hide_empty' => true,
					) );
					
					if ( ! empty( $categories ) && ! is_wp_error( $categories ) ) :
					?>
						<div class="widget-content">
							<ul class="game-categories-list">
								<?php foreach ( $categories as $category ) : ?>
									<li>
										<a href="<?php echo esc_url( get_term_link( $category ) ); ?>">
											<?php echo esc_html( $category->name ); ?>
											<span class="count">(<?php echo esc_html( $category->count ); ?>)</span>
										</a>
									</li>
								<?php endforeach; ?>
							</ul>
						</div>
					<?php else : ?>
						<div class="widget-content">
							<p><?php esc_html_e( 'No game categories found.', 'casino-review-pro' ); ?></p>
						</div>
					<?php endif; ?>
				</div>
				
				<div class="widget game-providers-widget">
					<h3 class="widget-title"><?php esc_html_e( 'Game Providers', 'casino-review-pro' ); ?></h3>
					<?php
					$providers = get_terms( array(
						'taxonomy' => 'game_provider',
						'hide_empty' => true,
					) );
					
					if ( ! empty( $providers ) && ! is_wp_error( $providers ) ) :
					?>
						<div class="widget-content">
							<ul class="game-providers-list">
								<?php foreach ( $providers as $provider ) : ?>
									<li>
										<a href="<?php echo esc_url( get_term_link( $provider ) ); ?>">
											<?php echo esc_html( $provider->name ); ?>
											<span class="count">(<?php echo esc_html( $provider->count ); ?>)</span>
										</a>
									</li>
								<?php endforeach; ?>
							</ul>
						</div>
					<?php else : ?>
						<div class="widget-content">
							<p><?php esc_html_e( 'No game providers found.', 'casino-review-pro' ); ?></p>
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
			</div><!-- .sidebar -->
		</div><!-- .row -->
	</div><!-- .container -->
</main><!-- #main -->

<?php
get_footer();
