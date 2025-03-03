<?php
/**
 * The template for displaying casino archive pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Casino_Review_Pro
 */

get_header();
?>

<main id="primary" class="site-main">
	<div class="container">
		<div class="casino-archive-header">
			<h1 class="archive-title"><?php post_type_archive_title(); ?></h1>
			<div class="archive-description">
				<?php the_archive_description(); ?>
			</div>
		</div>
		
		<div class="filter-bar">
			<form class="filter-form" method="get" action="<?php echo esc_url( get_post_type_archive_link( 'casino' ) ); ?>">
				<div class="filter-group">
					<label for="filter-category" class="filter-label"><?php esc_html_e( 'Category', 'casino-review-pro' ); ?></label>
					<select id="filter-category" name="casino_category" class="filter-select">
						<option value=""><?php esc_html_e( 'All Categories', 'casino-review-pro' ); ?></option>
						<?php
						$categories = get_terms( array(
							'taxonomy' => 'casino_category',
							'hide_empty' => true,
						) );
						
						if ( ! empty( $categories ) && ! is_wp_error( $categories ) ) {
							foreach ( $categories as $category ) {
								$selected = isset( $_GET['casino_category'] ) && $_GET['casino_category'] === $category->slug ? 'selected' : '';
								echo '<option value="' . esc_attr( $category->slug ) . '" ' . $selected . '>' . esc_html( $category->name ) . '</option>';
							}
						}
						?>
					</select>
				</div>
				
				<div class="filter-group">
					<label for="filter-rating" class="filter-label"><?php esc_html_e( 'Min Rating', 'casino-review-pro' ); ?></label>
					<select id="filter-rating" name="min_rating" class="filter-select">
						<option value=""><?php esc_html_e( 'Any Rating', 'casino-review-pro' ); ?></option>
						<?php
						for ( $i = 5; $i <= 10; $i++ ) {
							$selected = isset( $_GET['min_rating'] ) && (int) $_GET['min_rating'] === $i ? 'selected' : '';
							echo '<option value="' . esc_attr( $i ) . '" ' . $selected . '>' . esc_html( $i ) . '+</option>';
						}
						?>
					</select>
				</div>
				
				<div class="filter-group">
					<label for="filter-sort" class="filter-label"><?php esc_html_e( 'Sort By', 'casino-review-pro' ); ?></label>
					<select id="filter-sort" name="orderby" class="filter-select">
						<option value="rating" <?php selected( isset( $_GET['orderby'] ) ? $_GET['orderby'] : 'rating', 'rating' ); ?>><?php esc_html_e( 'Rating (High to Low)', 'casino-review-pro' ); ?></option>
						<option value="date" <?php selected( isset( $_GET['orderby'] ) ? $_GET['orderby'] : '', 'date' ); ?>><?php esc_html_e( 'Newest First', 'casino-review-pro' ); ?></option>
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
					'post_type'      => 'casino',
					'posts_per_page' => 10,
					'paged'          => $paged,
				);
				
				// Apply filters from query parameters
				if ( isset( $_GET['casino_category'] ) && ! empty( $_GET['casino_category'] ) ) {
					$args['tax_query'] = array(
						array(
							'taxonomy' => 'casino_category',
							'field'    => 'slug',
							'terms'    => sanitize_text_field( $_GET['casino_category'] ),
						),
					);
				}
				
				if ( isset( $_GET['min_rating'] ) && ! empty( $_GET['min_rating'] ) ) {
					$args['meta_query'] = array(
						array(
							'key'     => '_casino_overall_rating',
							'value'   => (int) $_GET['min_rating'],
							'compare' => '>=',
							'type'    => 'NUMERIC',
						),
					);
				}
				
				// Set orderby parameter
				if ( isset( $_GET['orderby'] ) ) {
					switch ( $_GET['orderby'] ) {
						case 'rating':
							$args['meta_key'] = '_casino_overall_rating';
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
						default:
							$args['meta_key'] = '_casino_overall_rating';
							$args['orderby']  = 'meta_value_num';
							$args['order']    = 'DESC';
					}
				} else {
					// Default sorting by rating
					$args['meta_key'] = '_casino_overall_rating';
					$args['orderby']  = 'meta_value_num';
					$args['order']    = 'DESC';
				}
				
				$casinos_query = new WP_Query( $args );
				
				if ( $casinos_query->have_posts() ) : ?>
					<div class="casino-list">
						<?php
						$counter = 1;
						while ( $casinos_query->have_posts() ) :
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
							?>
							
							<div class="casino-card">
								<div class="casino-rank"><?php echo esc_html( $counter ); ?></div>
								
								<div class="casino-logo-wrapper">
									<?php if ( has_post_thumbnail() ) : ?>
										<a href="<?php the_permalink(); ?>">
											<?php the_post_thumbnail( 'casino-logo', array( 'class' => 'casino-logo' ) ); ?>
										</a>
									<?php else : ?>
										<div class="casino-logo-placeholder">
											<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
										</div>
									<?php endif; ?>
								</div>
								
								<div class="casino-content">
									<h2 class="casino-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
									
									<?php if ( $rating ) : ?>
										<div class="rating-box">
											<div class="rating-score"><?php echo esc_html( $rating ); ?></div>
											<div class="rating-text">
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
												</div>
												<div class="rating-title"><?php esc_html_e( 'Overall Rating', 'casino-review-pro' ); ?></div>
											</div>
										</div>
									<?php endif; ?>
									
									<div class="casino-meta">
										<?php if ( $established ) : ?>
											<div class="meta-item"><i class="fa-solid fa-calendar-days"></i> <?php esc_html_e( 'Established:', 'casino-review-pro' ); ?> <?php echo esc_html( $established ); ?></div>
										<?php endif; ?>
										
										<?php if ( $min_deposit ) : ?>
											<div class="meta-item"><i class="fa-solid fa-money-bill-1"></i> <?php esc_html_e( 'Min. Deposit:', 'casino-review-pro' ); ?> <?php echo esc_html( $min_deposit ); ?></div>
										<?php endif; ?>
										
										<?php if ( $withdrawal_time ) : ?>
											<div class="meta-item"><i class="fa-solid fa-clock"></i> <?php esc_html_e( 'Withdrawal Time:', 'casino-review-pro' ); ?> <?php echo esc_html( $withdrawal_time ); ?></div>
										<?php endif; ?>
									</div>
									
									<?php if ( ! empty( $pros_array ) || ! empty( $cons_array ) ) : ?>
										<div class="casino-pros-cons">
											<?php if ( ! empty( $pros_array ) ) : ?>
												<div class="casino-pros-list">
													<h3><?php esc_html_e( 'Pros', 'casino-review-pro' ); ?></h3>
													<ul>
														<?php foreach ( array_slice( $pros_array, 0, 3 ) as $pro ) : ?>
															<?php if ( ! empty( trim( $pro ) ) ) : ?>
																<li><i class="fa-solid fa-check"></i> <?php echo esc_html( trim( $pro ) ); ?></li>
															<?php endif; ?>
														<?php endforeach; ?>
													</ul>
												</div>
											<?php endif; ?>
											
											<?php if ( ! empty( $cons_array ) ) : ?>
												<div class="casino-cons-list">
													<h3><?php esc_html_e( 'Cons', 'casino-review-pro' ); ?></h3>
													<ul>
														<?php foreach ( array_slice( $cons_array, 0, 3 ) as $con ) : ?>
															<?php if ( ! empty( trim( $con ) ) ) : ?>
																<li><i class="fa-solid fa-xmark"></i> <?php echo esc_html( trim( $con ) ); ?></li>
															<?php endif; ?>
														<?php endforeach; ?>
													</ul>
												</div>
											<?php endif; ?>
										</div>
									<?php endif; ?>
									
									<div class="casino-actions">
										<a href="<?php the_permalink(); ?>" class="btn btn-outline"><?php esc_html_e( 'Read Review', 'casino-review-pro' ); ?></a>
										
										<?php if ( $website_url ) : ?>
											<a href="<?php echo esc_url( $website_url ); ?>" class="btn btn-primary" target="_blank"><?php esc_html_e( 'Visit Casino', 'casino-review-pro' ); ?></a>
										<?php endif; ?>
									</div>
								</div>
							</div>
							
							<?php
							$counter++;
						endwhile;
						
						// Reset post data
						wp_reset_postdata();
						?>
					</div>
					
					<?php
					// Pagination
					$big = 999999999; // need an unlikely integer
					echo '<div class="pagination">';
					echo paginate_links( array(
						'base'      => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
						'format'    => '?paged=%#%',
						'current'   => max( 1, get_query_var( 'paged' ) ),
						'total'     => $casinos_query->max_num_pages,
						'prev_text' => '<i class="fa-solid fa-chevron-left"></i> ' . __( 'Previous', 'casino-review-pro' ),
						'next_text' => __( 'Next', 'casino-review-pro' ) . ' <i class="fa-solid fa-chevron-right"></i>',
					) );
					echo '</div>';
					?>
					
				<?php else : ?>
					<div class="no-results">
						<h2><?php esc_html_e( 'No Casinos Found', 'casino-review-pro' ); ?></h2>
						<p><?php esc_html_e( 'Sorry, no casinos match your filter criteria. Please try adjusting your filters.', 'casino-review-pro' ); ?></p>
					</div>
				<?php endif; ?>
			</div><!-- .main-content -->
			
			<div class="col-lg-4 sidebar">
				<?php get_sidebar(); ?>
			</div><!-- .sidebar -->
		</div><!-- .row -->
	</div><!-- .container -->
</main><!-- #main -->

<?php
get_footer();
