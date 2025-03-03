<?php
/**
 * Custom widgets for the Casino Review Pro theme
 *
 * @package Casino_Review_Pro
 */

/**
 * Register custom widgets
 */
function casino_review_register_widgets() {
    register_widget( 'Casino_Review_Popular_Casinos_Widget' );
    register_widget( 'Casino_Review_Recent_Bonuses_Widget' );
    register_widget( 'Casino_Review_Newsletter_Widget' );
}
add_action( 'widgets_init', 'casino_review_register_widgets' );

/**
 * Recent Bonuses Widget
 */
class Casino_Review_Recent_Bonuses_Widget extends WP_Widget {

    public function __construct() {
        parent::__construct(
            'casino_review_recent_bonuses',
            __( 'Recent Bonuses', 'casino-review-pro' ),
            array(
                'description' => __( 'Display a list of recent bonus offers', 'casino-review-pro' ),
            )
        );
    }

    public function widget( $args, $instance ) {
        $title = ! empty( $instance['title'] ) ? $instance['title'] : __( 'Latest Bonuses', 'casino-review-pro' );
        $number = ! empty( $instance['number'] ) ? absint( $instance['number'] ) : 5;
        
        $title = apply_filters( 'widget_title', $title, $instance, $this->id_base );
        
        echo $args['before_widget'];
        
        if ( $title ) {
            echo $args['before_title'] . $title . $args['after_title'];
        }
        
        // Get recent bonuses
        $bonuses_query = new WP_Query( array(
            'post_type'      => 'bonus',
            'posts_per_page' => $number,
            'orderby'        => 'date',
            'order'          => 'DESC',
        ) );
        
        if ( $bonuses_query->have_posts() ) {
            echo '<div class="recent-bonuses-widget">';
            
            while ( $bonuses_query->have_posts() ) {
                $bonuses_query->the_post();
                $bonus_id = get_the_ID();
                
                // Get bonus data
                $bonus_value = get_post_meta( $bonus_id, '_bonus_value', true );
                $bonus_casino = get_post_meta( $bonus_id, '_bonus_casino', true );
                
                echo '<div class="bonus-item">';
                
                if ( has_post_thumbnail() ) {
                    echo '<div class="bonus-logo-wrapper">';
                    echo get_the_post_thumbnail( $bonus_id, 'thumbnail', array( 'class' => 'bonus-logo' ) );
                    echo '</div>';
                }
                
                echo '<div class="bonus-info">';
                echo '<div class="bonus-title"><a href="' . get_permalink() . '">' . get_the_title() . '</a></div>';
                
                if ( $bonus_value ) {
                    echo '<div class="bonus-value">' . esc_html( $bonus_value ) . '</div>';
                }
                
                if ( $bonus_casino ) {
                    $casino_name = get_the_title( $bonus_casino );
                    echo '<div class="bonus-casino">' . esc_html( $casino_name ) . '</div>';
                }
                
                echo '</div>'; // .bonus-info
                
                echo '</div>'; // .bonus-item
            }
            
            echo '</div>'; // .recent-bonuses-widget
            
            echo '<a href="' . esc_url( get_post_type_archive_link( 'bonus' ) ) . '" class="btn btn-outline btn-sm view-all-link">' . esc_html__( 'View All Bonuses', 'casino-review-pro' ) . '</a>';
            
            wp_reset_postdata();
        } else {
            echo '<p>' . __( 'No bonuses found.', 'casino-review-pro' ) . '</p>';
        }
        
        echo $args['after_widget'];
    }

    public function form( $instance ) {
        $title = ! empty( $instance['title'] ) ? $instance['title'] : __( 'Latest Bonuses', 'casino-review-pro' );
        $number = ! empty( $instance['number'] ) ? absint( $instance['number'] ) : 5;
        ?>
        <p>
            <label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_html_e( 'Title:', 'casino-review-pro' ); ?></label>
            <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">
        </p>
        <p>
            <label for="<?php echo esc_attr( $this->get_field_id( 'number' ) ); ?>"><?php esc_html_e( 'Number of bonuses to show:', 'casino-review-pro' ); ?></label>
            <input class="tiny-text" id="<?php echo esc_attr( $this->get_field_id( 'number' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'number' ) ); ?>" type="number" step="1" min="1" value="<?php echo esc_attr( $number ); ?>" size="3">
        </p>
        <?php
    }

    public function update( $new_instance, $old_instance ) {
        $instance = array();
        $instance['title'] = ( ! empty( $new_instance['title'] ) ) ? sanitize_text_field( $new_instance['title'] ) : '';
        $instance['number'] = ( ! empty( $new_instance['number'] ) ) ? absint( $new_instance['number'] ) : 5;
        
        return $instance;
    }
}

/**
 * Newsletter Widget
 */
class Casino_Review_Newsletter_Widget extends WP_Widget {

    public function __construct() {
        parent::__construct(
            'casino_review_newsletter',
            __( 'Newsletter Signup', 'casino-review-pro' ),
            array(
                'description' => __( 'Display a newsletter signup form', 'casino-review-pro' ),
            )
        );
    }

    public function widget( $args, $instance ) {
        $title = ! empty( $instance['title'] ) ? $instance['title'] : __( 'Subscribe to Newsletter', 'casino-review-pro' );
        $description = ! empty( $instance['description'] ) ? $instance['description'] : __( 'Sign up for our newsletter to receive the latest casino news and exclusive bonuses.', 'casino-review-pro' );
        $form_action = ! empty( $instance['form_action'] ) ? $instance['form_action'] : '#';
        
        $title = apply_filters( 'widget_title', $title, $instance, $this->id_base );
        
        echo $args['before_widget'];
        
        if ( $title ) {
            echo $args['before_title'] . $title . $args['after_title'];
        }
        
        echo '<div class="newsletter-widget">';
        
        if ( $description ) {
            echo '<p class="newsletter-description">' . esc_html( $description ) . '</p>';
        }
        
        echo '<form action="' . esc_url( $form_action ) . '" method="post" class="newsletter-form">';
        echo '<div class="form-group">';
        echo '<input type="email" name="email" class="form-control" placeholder="' . esc_attr__( 'Your Email Address', 'casino-review-pro' ) . '" required>';
        echo '</div>';
        echo '<div class="form-group">';
        echo '<button type="submit" class="btn btn-primary">' . esc_html__( 'Subscribe', 'casino-review-pro' ) . '</button>';
        echo '</div>';
        echo '</form>';
        
        echo '<p class="privacy-note">' . esc_html__( 'By subscribing, you agree to our privacy policy.', 'casino-review-pro' ) . '</p>';
        
        echo '</div>'; // .newsletter-widget
        
        echo $args['after_widget'];
    }

    public function form( $instance ) {
        $title = ! empty( $instance['title'] ) ? $instance['title'] : __( 'Subscribe to Newsletter', 'casino-review-pro' );
        $description = ! empty( $instance['description'] ) ? $instance['description'] : __( 'Sign up for our newsletter to receive the latest casino news and exclusive bonuses.', 'casino-review-pro' );
        $form_action = ! empty( $instance['form_action'] ) ? $instance['form_action'] : '#';
        ?>
        <p>
            <label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_html_e( 'Title:', 'casino-review-pro' ); ?></label>
            <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">
        </p>
        <p>
            <label for="<?php echo esc_attr( $this->get_field_id( 'description' ) ); ?>"><?php esc_html_e( 'Description:', 'casino-review-pro' ); ?></label>
            <textarea class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'description' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'description' ) ); ?>" rows="3"><?php echo esc_textarea( $description ); ?></textarea>
        </p>
        <p>
            <label for="<?php echo esc_attr( $this->get_field_id( 'form_action' ) ); ?>"><?php esc_html_e( 'Form Action URL:', 'casino-review-pro' ); ?></label>
            <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'form_action' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'form_action' ) ); ?>" type="url" value="<?php echo esc_attr( $form_action ); ?>">
            <small><?php esc_html_e( 'Enter your newsletter service provider URL here', 'casino-review-pro' ); ?></small>
        </p>
        <?php
    }

    public function update( $new_instance, $old_instance ) {
        $instance = array();
        $instance['title'] = ( ! empty( $new_instance['title'] ) ) ? sanitize_text_field( $new_instance['title'] ) : '';
        $instance['description'] = ( ! empty( $new_instance['description'] ) ) ? sanitize_textarea_field( $new_instance['description'] ) : '';
        $instance['form_action'] = ( ! empty( $new_instance['form_action'] ) ) ? esc_url_raw( $new_instance['form_action'] ) : '#';
        
        return $instance;
    }
}
