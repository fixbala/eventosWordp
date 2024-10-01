<?php
/*
Plugin Name: Gestión de Eventos
Description: Un plugin para gestionar eventos.
Version: 2.0
Author: Santiago Martínez
Text Domain: gestion-eventos
Domain Path: /languages
*/

// Definir constantes del plugin
define('GE_PLUGIN_DIR', plugin_dir_path(__FILE__));
define('GE_PLUGIN_URL', plugin_dir_url(__FILE__));

// Incluir archivos necesarios
require_once GE_PLUGIN_DIR . 'includes/class-event-post-type.php';
require_once GE_PLUGIN_DIR . 'includes/class-event-cron.php';
require_once GE_PLUGIN_DIR . 'includes/class-event-shortcode.php';
require_once GE_PLUGIN_DIR . 'includes/class-event-security.php';

// Activación del plugin
function ge_activate_plugin() {
    GE_Event_Cron::create_events_table();
}
register_activation_hook(__FILE__, 'ge_activate_plugin');

// Desactivación del plugin
function ge_deactivate_plugin() {
    GE_Event_Cron::deactivate_cron_job();
}
register_deactivation_hook(__FILE__, 'ge_deactivate_plugin');

// Inicializar las clases principales
add_action('plugins_loaded', 'ge_init_plugin');
function ge_init_plugin() {
    GE_Event_Post_Type::init();
    GE_Event_Cron::init();
    GE_Event_Shortcode::init();
    GE_Event_Security::init();
}

// Cargar archivos de traducción
function ge_load_textdomain() {
    load_plugin_textdomain('gestion-eventos', false, dirname(plugin_basename(__FILE__)) . '/languages/');
}
add_action('init', 'ge_load_textdomain');
 
// Registrar el bloque de Gutenberg
function ge_register_gutenberg_block() {
    // Registrar el script del bloque
    wp_register_script(
        'ge-block-script',
        GE_PLUGIN_URL . 'assets/js/block.js',
        array('wp-blocks', 'wp-element', 'wp-editor', 'wp-components', 'wp-i18n', 'wp-api-fetch', 'wp-block-editor'),
        filemtime(GE_PLUGIN_DIR . 'assets/js/block.js')
    );

    // Registrar el estilo del bloque
    wp_register_style(
        'ge-block-style',
        GE_PLUGIN_URL . 'assets/css/block-style.css',
        array(),
        filemtime(GE_PLUGIN_DIR . 'assets/css/block-style.css')
    );

    // Registrar el bloque
    register_block_type('gestion-eventos/eventos-block', array(
        'editor_script' => 'ge-block-script',
        'editor_style' => 'ge-block-style',
        'render_callback' => 'ge_render_event_block', // Callback que renderiza el bloque en el frontend
    ));
}
add_action('init', 'ge_register_gutenberg_block');

// Función que renderiza el bloque en el frontend
function ge_render_event_block($attributes, $content) {
    // Obtener el próximo evento
    $args = array(
        'post_type' => 'eventos',
        'posts_per_page' => 1,
        'meta_key' => '_event_date',
        'orderby' => 'meta_value',
        'order' => 'ASC',
    );

    $events = new WP_Query($args);
    if ($events->have_posts()) {
        $output = '<section class="event-block container">';
        while ($events->have_posts()) {
            $events->the_post();
            $output .= '<div class="row">';
            $output .= '<div class="col-md-6">';
            $output .= '<h2>' . get_the_title() . '</h2>';
            $output .= '<p><small>' . get_post_meta(get_the_ID(), '_event_date', true) . '</small></p>';
            $output .= get_the_post_thumbnail(null, 'large', array('class' => 'img-fluid'));
            $output .= '<p>' . get_the_excerpt() . '</p>';
            $output .= '</div>';

            // Mostrar galería de imágenes
            $gallery_ids = explode(',', get_post_meta(get_the_ID(), '_event_gallery', true));
            if (!empty($gallery_ids)) {
                $output .= '<div class="col-md-6">';
                $output .= '<div class="event-gallery row">';
                foreach ($gallery_ids as $id) {
                    $output .= '<div class="col-md-4 mb-2">';
                    $output .= wp_get_attachment_image($id, 'medium', false, array('class' => 'img-fluid'));
                    $output .= '</div>';
                }
                $output .= '</div>'; // .event-gallery
                $output .= '</div>'; // .col-md-6
            }
            $output .= '</div>'; // .row
        }
        $output .= '</section>';
        wp_reset_postdata();
        return $output;
    } else {
        return '<p>' . __('No hay eventos disponibles.', 'gestion-eventos') . '</p>';
    }
}

// Encolar estilos y scripts
function ge_enqueue_assets() {
    wp_enqueue_style('bootstrap-css', 'https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css');
    wp_enqueue_style('ge-style', GE_PLUGIN_URL . 'assets/css/style.css');
    wp_enqueue_script('ge-script', GE_PLUGIN_URL . 'assets/js/script.js', array('jquery'), false, true);
}
add_action('wp_enqueue_scripts', 'ge_enqueue_assets');
  