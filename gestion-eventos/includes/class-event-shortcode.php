<?php
class GE_Event_Shortcode {

    public static function init() {
        add_shortcode('event_slider', array(__CLASS__, 'display_event_slider'));
    }

    public static function display_event_slider() {
        $args = array(
            'post_type' => 'eventos',
            'posts_per_page' => 5,
            'meta_key' => '_event_date',
            'orderby' => 'meta_value',
            'order' => 'ASC'
        );
        
        $events = new WP_Query($args); 

        if ($events->have_posts()) {
            $output = '<section class="event-slider">';
            $output .= '<h1>' . __('EVENTOS', 'gestion-eventos') . '</h1>';
            $output .= '<div class="slider-controls"><button class="prev-slide">&lt;</button><button class="next-slide">&gt;</button></div>';
            $output .= '<div class="slides-container">';
            
            while ($events->have_posts()) {
                $events->the_post();
                $output .= '<div class="slide">';
                $output .= '<h2>' . get_the_title() . '</h2>';
                $output .= get_the_post_thumbnail(null, 'medium');
                $output .= '<p><small>' . esc_html(get_post_meta(get_the_ID(), '_event_date', true)) . '</small></p>';
                $output .= '<p>' . get_the_excerpt() . '</p></div>';
            }

            $output .= '</div></section>';
            wp_reset_postdata();
            return $output;
        }
    }
}
  