<?php
/**
 * The template for displaying payment method archive pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Casino_Review_Pro
 */

get_header();
?>

<main id="primary" class="site-main">
	<div class="container">
		<div class="payment-archive-header">
			<h1 class="archive-title"><?php post_type_archive_title(); ?></h1>
			<div class="archive-description">
				<?php the_archive_description(); ?>
			</div>
		</div>
		
		<div class="filter-bar">
			<form class="filter-form" method="get" action="<?php echo esc_url( get_post_type_archive_link( 'payment_method' ) ); ?>">
				<div class="filter-group">
					<label for="filter-type" class="filter-label"><?php esc_html_e( 'Payment Type', 'casino-review-pro' ); ?></label>
					<select id="filter-type" name="payment_type" class="filter-select">
						<option value=""><?php esc_html_e( 'All Types', 'casino-review-pro' ); ?></option>
						<?php
						$payment_types = get_terms( array(
							'taxonomy' => 'payment_type',
							'hide_empty' => true,
						) );
						
						if ( ! empty( $payment_types ) && ! is_wp_error( $payment_types ) ) {
							foreach ( $payment_types as $type ) {
								$selected = isset( $_GET['payment_type'] ) && $_GET['payment_type'] === $type->slug ? 'selected' : '';
								echo '<option value="' . esc_attr( $type->slug ) . '" ' . $selected . '>' . esc_html( $type->name ) . '</option>';
							}
						}
						?>
					</select>
				</div>
				
				<div class="filter-group">
					<label for="filter-deposit-time" class="filter-label"><?php esc_html_e( 'Deposit Time', 'casino-review-pro' ); ?></label>
					<select id="filter-deposit-time" name="deposit_time" class="filter-select">
						<option value=""><?php esc_html_e( 'Any Time', 'casino-review-pro' ); ?></option>
						<option value="instant" <?php selected( isset( $_GET['deposit_time'] ) ? $_GET['deposit_time'] : '', 'instant' ); ?>><?php esc_html_e( 'Instant', 'casino-review-pro' ); ?></option>
						<option value="fast" <?php selected( isset( $_GET['deposit_time'] ) ? $_GET['deposit_time'] : '', 'fast' ); ?>><?php esc_html_e( 'Fast (< 1 hour)', 'casino-review-pro' ); ?></option>
						<option value="same-day" <?php selected( isset( $_GET['deposit_time'] ) ? $_GET['deposit_time'] : '', 'same-day' ); ?>><?php esc_html_e( 'Same Day', 'casino-review-pro' ); ?></option>
					</select>
				</div>
				
				<div class="filter-group">
					<label for="filter-fees" class="filter-label"><?php esc_html_e( 'Fees', 'casino-review-pro' ); ?></label>
					<select id="filter-fees" name="fees" class="filter-select">
						<option value=""><?php esc_html_e( 'Any Fees', 'casino-review-pro' ); ?></option>
						<option value="free" <?php selected( isset( $_GET['fees'] ) ? $_GET['fees'] : '', 'free' ); ?>><?php esc_html_e( 'No Fees', 'casino-review-pro' ); ?></option>
						<option value="low" <?php selected( isset( $_GET['fees'] ) ? $_GET['fees'] : '', 'low' ); ?>><?php esc_html_e( 'Low Fees', 'casino-review-pro' ); ?></option>
					</select>
				</div>
				
				<div class="filter-group">
					<label for="filter-sort" class="filter-label"><?php esc_html_e( 'Sort By', 'casino-review-pro' ); ?></label>
					<select id="filter-sort" name="orderby" class="filter-select">
						<option value="title" <?php selected( isset( $_GET['orderby'] ) ? $_GET['orderby'] : 'title', 'title' ); ?>><?php esc_html_e( 'Name (A-Z)', 'casino-review-pro' ); ?></option>
						<option value="date" <?php selected( isset( $_GET['orderby'] ) ? $_GET['orderby'] : '', 'date' ); ?>><?php esc_html_e( 'Newest First', 'casino-review-pro' ); ?></option>
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
					'post_type'      => 'payment_method',
					'posts_per_page' => 12,
					'paged'          => $paged,
				);
				
				// Apply filters from query parameters
				if ( isset( $_GET['payment_type'] ) && ! empty( $_GET['payment_type'] ) ) {
					$args['tax_query'] = array(
						array(
							'taxonomy' => 'payment_type',
							'field'    => 'slug',
							'terms'    => sanitize_text_field( $_GET['payment_type'] ),
						),
					);
				}
				
				// Deposit time filter
				if ( isset( $_GET['deposit_time'] ) && ! empty( $_GET['deposit_time'] ) ) {
					$deposit_time_values = array(
						'instant'   => array('Instant', 'instant', 'Immediate'),
						'fast'      => array('Fast', 'Minutes', 'minutes', '< 1 hour', 'Less than 1 hour'),
						'same-day'  => array('Same Day', 'same day', '24 hours', '24 Hours', '1 day')
					);
					
					if (isset($deposit_time_values[$_GET['deposit_time']])) {
						$args['meta_query'][] = array(
							'key'     => '_payment_deposit_time',
							'value'   => $deposit_time_values[$_GET['deposit_time']],
							'compare' => 'LIKE',
						);
					}
				}
				
				// Fees filter
				if ( isset( $_GET['fees'] ) && ! empty( $_GET['fees'] ) ) {
					if ( $_GET['fees'] === 'free' ) {
						$args['meta_query'][] = array(
							'key'     => '_payment_fees',
							'value'   => array('No Fees', 'Free', 'None', '0%', '0', 'No'),
							'compare' => 'IN',
						);
					} elseif ( $_GET['fees'] === 'low' ) {
						$args['meta_query'][] = array(
							'key'     => '_payment_fees',
							'value'   => array('Low', 'low fees', '1%', '2%', '3%', '<5%'),
							'compare' => 'LIKE',
						);
					}
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
							$args['orderby'] = 'title';
							$args['order']   = 'ASC';
					}
				} else {
					// Default sorting by title
					$args['orderby'] = 'title';
					$args['order']   = 'ASC';
				}
				
				$methods_query = new WP_Query( $args );
				
				if ( $methods_query->have_posts() ) : ?>
					<div class="payment-methods-grid">
						<?php
						while ( $methods_query->have_posts() ) :
							$methods_query->the_post();
							$payment_id = get_the_ID();
							
							// Get payment method meta data
							$deposit_time = get_post_meta( $payment_id, '_payment_deposit_time', true );
							$withdrawal_time = get_post_meta( $payment_id, '_payment_withdrawal_time', true );
							$fees = get_post_meta( $payment_id, '_payment_fees', true );
							?>
							
							<div class="payment-method-card">
								<a href="<?php the_permalink(); ?>" class="payment-method-logo-wrapper">
									<?php if ( has_post_thumbnail() ) : ?>
										<?php the_post_thumbnail( 'medium', array( 'class' => 'payment-method-logo' ) ); ?>
									<?php else : ?>
										<div class="payment-method-placeholder">
											<?php the_title(); ?>
										</div>
									<?php endif; ?>
								</a>
								
								<div class="payment-method-content">
									<h3 class="payment-method-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
									
									<?php
									// Get payment type terms
									$payment_types = get_the_terms( $payment_id, 'payment_type' );
									if ( ! empty( $payment_types ) && ! is_wp_error( $payment_types ) ) :
										$type_names = array();
										foreach ( $payment_types as $type ) {
											$type_names[] = $type->name;
										}
									?>
										<div class="payment-method-type">
											<?php echo esc_html( implode( ', ', $type_names ) ); ?>
										</div>
									<?php endif; ?>
									
									<div class="payment-method-meta">
										<?php if ( $deposit_time ) : ?>
											<div class="meta-item">
												<span class="meta-label"><?php esc_html_e( 'Deposit:', 'casino-review-pro' ); ?></span>
												<span class="meta-value"><?php echo esc_html( $deposit_time ); ?></span>
											</div>
										<?php endif; ?>
										
										<?php if ( $withdrawal_time ) : ?>
											<div class="meta-item">
												<span class="meta-label"><?php esc_html_e( 'Withdrawal:', 'casino-review-pro' ); ?></span>
												<span class="meta-value"><?php echo esc_html( $withdrawal_time ); ?></span>
											</div>
										<?php endif; ?>
										
										<?php if ( $fees ) : ?>
											<div class="meta-item">
												<span class="meta-label"><?php esc_html_e( 'Fees:', 'casino-review-pro' ); ?></span>
												<span class="meta-value"><?php echo esc_html( $fees ); ?></span>
											</div>
										<?php endif; ?>
									</div>
									
									<div class="payment-method-action">
										<a href="<?php the_permalink(); ?>" class="btn btn-sm btn-outline"><?php esc_html_e( 'View Details', 'casino-review-pro' ); ?></a>
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
						'total'     => $methods_query->max_num_pages,
						'prev_text' => '<i class="fa-solid fa-chevron-left"></i> ' . __( 'Previous', 'casino-review-pro' ),
						'next_text' => __( 'Next', 'casino-review-pro' ) . ' <i class="fa-solid fa-chevron-right"></i>',
					) );
					echo '</div>';
					?>
					
				<?php else : ?>
					<div class="no-results">
						<h2><?php esc_html_e( 'No Payment Methods Found', 'casino-review-pro' ); ?></h2>
						<p><?php esc_html_e( 'Sorry, no payment methods match your filter criteria. Please try adjusting your filters.', 'casino-review-pro' ); ?></p>
					</div>
				<?php 
				endif;
				wp_reset_postdata();
				?>
			</div><!-- .main-content -->
			
			<div class="col-lg-4 sidebar">
				<?php get_sidebar(); ?>
				
				<div class="widget payment-types-widget">
					<h3 class="widget-title"><?php esc_html_e( 'Payment Types', 'casino-review-pro' ); ?></h3>
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
			</div><!-- .sidebar -->
		</div><!-- .row -->
	</div><!-- .container -->
</main><!-- #main -->

<?php
get_footer();
