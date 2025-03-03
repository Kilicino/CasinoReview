<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and beginning of <body>
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Casino_Review_Pro
 */

?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="https://gmpg.org/xfn/11">

	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<div id="page" class="site">
	<a class="skip-link screen-reader-text" href="#primary"><?php esc_html_e( 'Skip to content', 'casino-review-pro' ); ?></a>

	<header id="masthead" class="site-header">
		<div class="header-container container">
			<div class="site-branding">
				<?php
				if ( has_custom_logo() ) :
					the_custom_logo();
				else :
					?>
					<h1 class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
					<?php
					$casino_review_description = get_bloginfo( 'description', 'display' );
					if ( $casino_review_description || is_customize_preview() ) :
						?>
						<p class="site-description"><?php echo $casino_review_description; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></p>
					<?php endif; ?>
				<?php endif; ?>
			</div><!-- .site-branding -->

			<nav id="site-navigation" class="main-navigation">
				<button class="menu-toggle" aria-controls="primary-menu" aria-expanded="false">
					<i class="fa-solid fa-bars"></i>
				</button>
				<?php
				wp_nav_menu(
					array(
						'theme_location' => 'primary',
						'menu_id'        => 'primary-menu',
						'menu_class'     => 'primary-menu',
						'container'      => false,
					)
				);
				?>
				
				<div class="search-form-wrapper">
					<?php get_search_form(); ?>
				</div>
			</nav><!-- #site-navigation -->
		</div><!-- .header-container -->
		
		<?php if ( is_front_page() && !is_paged() ) : ?>
			<div class="hero-section">
				<div class="container">
					<div class="hero-content">
						<h1 class="hero-title"><?php echo esc_html( get_theme_mod( 'casino_review_hero_title', __( 'Find the Best Online Casinos', 'casino-review-pro' ) ) ); ?></h1>
						<p class="hero-description"><?php echo esc_html( get_theme_mod( 'casino_review_hero_description', __( 'Expert Reviews, Exclusive Bonuses & Top-Rated Casinos', 'casino-review-pro' ) ) ); ?></p>
						
						<div class="hero-buttons">
							<a href="<?php echo esc_url( get_post_type_archive_link( 'casino' ) ); ?>" class="btn btn-primary btn-lg"><?php esc_html_e( 'View Casino Reviews', 'casino-review-pro' ); ?></a>
							<a href="<?php echo esc_url( get_post_type_archive_link( 'bonus' ) ); ?>" class="btn btn-outline btn-lg"><?php esc_html_e( 'Latest Bonuses', 'casino-review-pro' ); ?></a>
						</div>
						
						<?php 
						// Display top 3 casinos in hero section
						$top_casinos = new WP_Query( array(
							'post_type'      => 'casino',
							'posts_per_page' => 3,
							'meta_key'       => '_casino_overall_rating',
							'orderby'        => 'meta_value_num',
							'order'          => 'DESC',
						) );
						
						if ( $top_casinos->have_posts() ) : ?>
							<div class="top-casinos-preview">
								<h3><?php esc_html_e( 'Top Rated Casinos', 'casino-review-pro' ); ?></h3>
								<div class="top-casinos-list">
									<?php while ( $top_casinos->have_posts() ) : $top_casinos->the_post(); ?>
										<div class="top-casino-item">
											<?php if ( has_post_thumbnail() ) : ?>
												<div class="casino-logo-wrapper">
													<?php the_post_thumbnail( 'casino-thumbnail', array( 'class' => 'casino-logo' ) ); ?>
												</div>
											<?php endif; ?>
											<div class="casino-info">
												<h4 class="casino-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>
												<?php 
												$rating = get_post_meta( get_the_ID(), '_casino_overall_rating', true );
												if ( $rating ) : 
													$stars = round( $rating / 2, 1 );
												?>
													<div class="rating-stars">
														<?php for ( $i = 1; $i <= 5; $i++ ) : ?>
															<?php if ( $i <= floor( $stars ) ) : ?>
																<span class="star filled"><i class="fa-solid fa-star"></i></span>
															<?php elseif ( $i - $stars < 1 && $i - $stars > 0 ) : ?>
																<span class="star filled"><i class="fa-solid fa-star-half-stroke"></i></span>
															<?php else : ?>
																<span class="star"><i class="fa-regular fa-star"></i></span>
															<?php endif; ?>
														<?php endfor; ?>
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
					</div>
				</div>
			</div>
		<?php endif; ?>
		
		<?php if ( !is_front_page() && !is_singular( 'casino' ) && !is_singular( 'bonus' ) && !is_singular( 'game' ) ) : ?>
			<div class="page-header">
				<div class="container">
					<?php
					if ( is_archive() ) {
						the_archive_title( '<h1 class="page-title">', '</h1>' );
						the_archive_description( '<div class="archive-description">', '</div>' );
					} elseif ( is_search() ) {
						?>
						<h1 class="page-title">
							<?php
							/* translators: %s: search query. */
							printf( esc_html__( 'Search Results for: %s', 'casino-review-pro' ), '<span>' . get_search_query() . '</span>' );
							?>
						</h1>
						<?php
					} elseif ( is_404() ) {
						?>
						<h1 class="page-title"><?php esc_html_e( 'Oops! That page can&rsquo;t be found.', 'casino-review-pro' ); ?></h1>
						<?php
					} elseif ( is_page() ) {
						?>
						<h1 class="page-title"><?php the_title(); ?></h1>
						<?php
					}
					
					// Breadcrumbs
					if ( function_exists( 'casino_review_breadcrumbs' ) ) {
						casino_review_breadcrumbs();
					}
					?>
				</div>
			</div>
		<?php endif; ?>
	</header><!-- #masthead -->
