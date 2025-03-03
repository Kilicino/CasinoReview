<?php
/**
 * The template for displaying bonus archive pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Casino_Review_Pro
 */

get_header();
?>

<main id="primary" class="site-main">
	<div class="container">
		<div class="bonus-archive-header">
			<h1 class="archive-title"><?php post_type_archive_title(); ?></h1>
			<div class="archive-description">
				<?php the_archive_description(); ?>
			</div>
		</div>
		
		<div class="filter-bar">
			<form class="filter-form" method="get" action="<?php echo esc_url( get_post_type_archive_link( 'bonus' ) ); ?>">
				<div class="filter-group">
					<label for="filter-type" class="filter-label"><?php esc_html_e( 'Bonus Type', 'casino-review-pro' ); ?></label>
					<select id="filter-type" name="bonus_type" class="filter-select">
						<option value=""><?php esc_html_e( 'All Types', 'casino-review-pro' ); ?></option>
						<?php
						$bonus_types = get_terms( array(
							'taxonomy' => 'bonus_type',
							'hide_empty' => true,
						) );
						
						if ( ! empty( $bonus_types ) && ! is_wp_error( $bonus_types ) ) {
							foreach ( $bonus_types as $type ) {
								$selected = isset( $_GET['bonus_type'] ) && $_GET['bonus_type'] === $type->slug ? 'selected' : '';
								echo '<option value="' . esc_attr( $type->slug ) . '" ' . $selected . '>' . esc_html( $type->name ) . '</option>';
							}
						}
						?>
					</select>
				</div>
				
				<div class="filter-group">
					<label for="filter-casino" class="filter-label"><?php esc_html_e( 'Casino', 'casino-review-pro' ); ?></label>
					<select id="filter-casino" name="casino_id" class="filter-select">
						<option value=""><?php esc_html_e( 'All Casinos', 'casino-review-pro' ); ?></option>
						<?php
						$casinos = get_posts( array(
							'post_type' => 'casino',
							'posts_per_page' => -1,
							'orderby' => 'title',
							'order' => 'ASC',
						) );
						
						if ( ! empty( $casinos ) ) {
							foreach ( $casinos as $casino ) {
								$selected = isset( $_GET['casino_id'] ) && (int) $_GET['casino_id'] === $casino->ID ? 'selected' : '';
								echo '<option value="' . esc_attr( $casino->ID ) . '" ' . $selected . '>' . esc_html( $casino->post_title ) . '</option>';
							}
						}
						?>
					</select>
				</div>
				
				<div class="filter-group">
					<label for="filter-exclusive" class="filter-label"><?php esc_html_e( 'Exclusive', 'casino-review-pro' ); ?></label>
					<select id="filter-exclusive" name="exclusive" class="filter-select">
						<option value=""><?php esc_html_e( 'All Bonuses', 'casino-review-pro' ); ?></option>
						<option value="1" <?php selected( isset( $_GET['exclusive'] ) ? $_GET['exclusive'] : '', '1' ); ?>><?php esc_html_e( 'Exclusive Only', 'casino-review-pro' ); ?></option>
					</select>
				</div>
				
				<div class="filter-group">
					<label for="filter-sort" class="filter-label"><?php esc_html_e( 'Sort By', 'casino-review-pro' ); ?></label>
					<select id="filter-sort" name="orderby" class="filter-select">
						<option value="date" <?php selected( isset( $_GET['orderby'] ) ? $_GET['orderby'] : 'date', 'date' ); ?>><?php esc_html_e( 'Newest First', 'casino-review-pro' ); ?></option>
						<option value="title" <?php selected( isset( $_GET['orderby'] ) ? $_GET['orderby'] : '', 'title' ); ?>><?php esc_html_e( 'Name (A-Z)', 'casino-review-pro' ); ?></option>
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
					'post_type'      => 'bonus',
					'posts_per_page' => 10,
					'paged'          => $paged,
				);
				
				// Apply filters from query parameters
				if ( isset( $_GET['bonus_type'] ) && ! empty( $_GET['bonus_type'] ) ) {
					$args['tax_query'] = array(
						array(
							'taxonomy' => 'bonus_type',
							'field'    => 'slug',
							'terms'    => sanitize_text_field( $_GET['bonus_type'] ),
						),
					);
				}
				
				if ( isset( $_GET['casino_id'] ) && ! empty( $_GET['casino_id'] ) ) {
					$args['meta_query'][] = array(
						'key'     => '_bonus_casino',
						'value'   => (int) $_GET['casino_id'],
						'compare' => '=',
					);
				}
				
				if ( isset( $_GET['exclusive'] ) && $_GET['exclusive'] === '1' ) {
					$args['meta_query'][] = array(
						'key'     => '_bonus_exclusive',
						'value'   => '1',
						'compare' => '=',
					);
				}
				
				// Set orderby parameter
				if ( isset( $_GET['orderby'] ) ) {
					switch ( $_GET['orderby'] ) {
						case 'date':
							$args['orderby'] = 'date';
							$args['order']   = 'DESC';
							break;
						case 'title':
							$args['orderby'] = 'title';
							$args['order']   = 'ASC';
							break;
						default:
							$args['orderby'] = 'date';
							$args['order']   = 'DESC';
					}
				} else {
					// Default sorting by date
					$args['orderby'] = 'date';
					$args['order']   = 'DESC';
				}
				
				$bonuses_query = new WP_Query( $args );
				
				if ( $bonuses_query->have_posts() ) : ?>
					<div class="bonus-list">
						<?php
						while ( $bonuses_query->have_posts() ) :
							$bonuses_query->the_post();
							$bonus_id = get_the_ID();
							
							// Get bonus meta data
							$bonus_value = get_post_meta( $bonus_id, '_bonus_value', true );
							$bonus_code = get_post_meta( $bonus_id, '_bonus_code', true );
							$bonus_expiry = get_post_meta( $bonus_id, '_bonus_expiry', true );
							$bonus_casino = get_post_meta( $bonus_id, '_bonus_casino', true );
							$bonus_exclusive = get_post_meta( $bonus_id, '_bonus_exclusive', true );
							
							// Get casino data if linked
							$casino_name = '';
							$casino_url = '';
							
							if ( $bonus_casino ) {
								$casino_name = get_the_title( $bonus_casino );
								$casino_url = get_post_meta( $bonus_casino, '_casino_website_url', true );
							}
							?>
							
							<div class="bonus-card">
								<?php if ( $bonus_exclusive ) : ?>
									<div class="bonus-exclusive-tag">
										<i class="fa-solid fa-crown"></i> <?php esc_html_e( 'Exclusive', 'casino-review-pro' ); ?>
									</div>
								<?php endif; ?>
								
								<div class="bonus-logo-wrapper">
									<?php if ( has_post_thumbnail() ) : ?>
										<a href="<?php the_permalink(); ?>">
											<?php the_post_thumbnail( 'medium', array( 'class' => 'bonus-logo' ) ); ?>
										</a>
									<?php elseif ( $bonus_casino && has_post_thumbnail( $bonus_casino ) ) : ?>
										<a href="<?php the_permalink(); ?>">
											<?php echo get_the_post_thumbnail( $bonus_casino, 'medium', array( 'class' => 'bonus-logo' ) ); ?>
										</a>
									<?php else : ?>
										<div class="bonus-logo-placeholder">
											<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
										</div>
									<?php endif; ?>
								</div>
								
								<div class="bonus-content">
									<h2 class="bonus-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
									
									<?php if ( $casino_name ) : ?>
										<div class="bonus-casino-name">
											<?php esc_html_e( 'From:', 'casino-review-pro' ); ?> 
											<a href="<?php echo esc_url( get_permalink( $bonus_casino ) ); ?>">
												<?php echo esc_html( $casino_name ); ?>
											</a>
										</div>
									<?php endif; ?>
									
									<?php if ( $bonus_value ) : ?>
										<div class="bonus-value-box">
											<?php echo esc_html( $bonus_value ); ?>
										</div>
									<?php endif; ?>
									
									<div class="bonus-description">
										<?php the_excerpt(); ?>
									</div>
									
									<div class="bonus-meta">
										<?php if ( $bonus_code ) : ?>
											<div class="meta-item">
												<i class="fa-solid fa-ticket"></i> <?php esc_html_e( 'Code:', 'casino-review-pro' ); ?> 
												<span class="bonus-code"><?php echo esc_html( $bonus_code ); ?></span>
											</div>
										<?php endif; ?>
										
										<?php if ( $bonus_expiry ) : ?>
											<div class="meta-item">
												<i class="fa-solid fa-clock"></i> <?php esc_html_e( 'Expires:', 'casino-review-pro' ); ?> 
												<?php echo esc_html( $bonus_expiry ); ?>
											</div>
										<?php endif; ?>
										
										<?php
										// Get bonus type terms
										$bonus_types = get_the_terms( $bonus_id, 'bonus_type' );
										if ( ! empty( $bonus_types ) && ! is_wp_error( $bonus_types ) ) :
										?>
											<div class="meta-item">
												<i class="fa-solid fa-tag"></i> <?php esc_html_e( 'Type:', 'casino-review-pro' ); ?> 
												<?php 
												$type_links = array();
												foreach ( $bonus_types as $type ) {
													$type_links[] = '<a href="' . esc_url( get_term_link( $type ) ) . '">' . esc_html( $type->name ) . '</a>';
												}
												echo implode( ', ', $type_links );
												?>
											</div>
										<?php endif; ?>
									</div>
									
									<div class="bonus-actions">
										<a href="<?php the_permalink(); ?>" class="btn btn-outline"><?php esc_html_e( 'View Details', 'casino-review-pro' ); ?></a>
										
										<?php if ( $casino_url ) : ?>
											<a href="<?php echo esc_url( $casino_url ); ?>" class="btn btn-primary" target="_blank"><?php esc_html_e( 'Claim Bonus', 'casino-review-pro' ); ?></a>
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
						'total'     => $bonuses_query->max_num_pages,
						'prev_text' => '<i class="fa-solid fa-chevron-left"></i> ' . __( 'Previous', 'casino-review-pro' ),
						'next_text' => __( 'Next', 'casino-review-pro' ) . ' <i class="fa-solid fa-chevron-right"></i>',
					) );
					echo '</div>';
					?>
					
				<?php else : ?>
					<div class="no-results">
						<h2><?php esc_html_e( 'No Bonuses Found', 'casino-review-pro' ); ?></h2>
						<p><?php esc_html_e( 'Sorry, no bonuses match your filter criteria. Please try adjusting your filters.', 'casino-review-pro' ); ?></p>
					</div>
				<?php 
				endif;
				wp_reset_postdata();
				?>
			</div><!-- .main-content -->
			
			<div class="col-lg-4 sidebar">
				<?php get_sidebar(); ?>
				
				<div class="widget bonus-types-widget">
					<h3 class="widget-title"><?php esc_html_e( 'Bonus Types', 'casino-review-pro' ); ?></h3>
					<?php
					$bonus_types = get_terms( array(
						'taxonomy' => 'bonus_type',
						'hide_empty' => true,
					) );
					
					if ( ! empty( $bonus_types ) && ! is_wp_error( $bonus_types ) ) :
					?>
						<div class="widget-content">
							<ul class="bonus-types-list">
								<?php foreach ( $bonus_types as $type ) : ?>
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
							<p><?php esc_html_e( 'No bonus types found.', 'casino-review-pro' ); ?></p>
						</div>
					<?php endif; ?>
				</div>
				
				<div class="widget top-casinos-widget">
					<h3 class="widget-title"><?php esc_html_e( 'Top Rated Casinos', 'casino-review-pro' ); ?></h3>
					<?php
					$top_casinos = new WP_Query( array(
						'post_type' => 'casino',
						'posts_per_page' => 5,
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
