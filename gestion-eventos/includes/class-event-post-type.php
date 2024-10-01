<?php
 
class GE_Event_Post_Type {

    public static function init() {
        add_action('init', array(__CLASS__, 'register_post_type'));
        add_action('add_meta_boxes', array(__CLASS__, 'add_gallery_meta_box'));
        add_action('save_post', array(__CLASS__, 'save_gallery_meta'));
    }

    public static function register_post_type() {
        $labels = array(
            'name' => __('Eventos', 'gestion-eventos'),
            'singular_name' => __('Evento', 'gestion-eventos'),
            // Otras etiquetas
        );

        $args = array(
            'labels' => $labels,
            'public' => true,
            'supports' => array('title', 'editor', 'thumbnail', 'excerpt'),
            'has_archive' => true,
        );

        register_post_type('eventos', $args);
    }

    // Agregar el metabox para la galería de imágenes
    public static function add_gallery_meta_box() {
        add_meta_box(
            'ge_gallery_meta_box',
            __('Galería de imágenes', 'gestion-eventos'),
            array(__CLASS__, 'render_gallery_meta_box'),
            'eventos',
            'normal',
            'default'
        );
    }

    // Renderizar el metabox de galería
    public static function render_gallery_meta_box($post) {
        wp_nonce_field('ge_save_gallery_meta', 'ge_gallery_meta_nonce');
        $gallery = get_post_meta($post->ID, '_event_gallery', true);
        ?>
        <div>
            <p><?php _e('Selecciona las imágenes de la galería para este evento.', 'gestion-eventos'); ?></p>
            <input type="hidden" name="ge_event_gallery" id="ge_event_gallery" value="<?php echo esc_attr($gallery); ?>" />
            <button type="button" class="button" id="ge_add_gallery_button"><?php _e('Seleccionar imágenes', 'gestion-eventos'); ?></button>
            <div id="ge_gallery_preview"><?php echo $gallery ? wp_get_attachment_image($gallery, 'thumbnail') : ''; ?></div>
        </div>
        <script>
            jQuery(document).ready(function($) {
                $('#ge_add_gallery_button').click(function(e) {
                    e.preventDefault();
                    var frame = wp.media({
                        title: '<?php _e('Seleccionar imágenes para la galería', 'gestion-eventos'); ?>',
                        button: {
                            text: '<?php _e('Usar estas imágenes', 'gestion-eventos'); ?>'
                        },
                        multiple: true
                    });

                    frame.on('select', function() {
                        var attachments = frame.state().get('selection').toJSON();
                        var galleryIds = attachments.map(function(att) { return att.id; }).join(',');
                        $('#ge_event_gallery').val(galleryIds);
                        $('#ge_gallery_preview').html(attachments.map(function(att) {
                            return '<img src="' + att.sizes.thumbnail.url + '" />';
                        }).join(''));
                    });

                    frame.open();
                });
            });
        </script>
        <?php
    }
 
    // Guardar la galería de imágenes
    public static function save_gallery_meta($post_id) {
        if (!isset($_POST['ge_gallery_meta_nonce']) || !wp_verify_nonce($_POST['ge_gallery_meta_nonce'], 'ge_save_gallery_meta')) {
            return;
        }

        if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
            return;
        }

        if (isset($_POST['ge_event_gallery'])) {
            update_post_meta($post_id, '_event_gallery', sanitize_text_field($_POST['ge_event_gallery']));
        }
    }
}
