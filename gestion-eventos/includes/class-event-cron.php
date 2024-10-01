<?php
class GE_Event_Cron {

    public static function init() {
        add_action('wp', array(__CLASS__, 'schedule_cron_job'));
        add_action('ge_update_event_stats', array(__CLASS__, 'update_event_stats'));
    }

    public static function schedule_cron_job() {
        if (!wp_next_scheduled('ge_update_event_stats')) {
            wp_schedule_event(strtotime('00:00'), 'daily', 'ge_update_event_stats');
        }
    }

    public static function deactivate_cron_job() {
        wp_clear_scheduled_hook('ge_update_event_stats');
    }

    public static function update_event_stats() {
        global $wpdb;
        $table_name = $wpdb->prefix . 'event_stats';

        $active_events = new WP_Query(array(
            'post_type' => 'eventos',
            'meta_key' => '_event_date',
            'meta_value' => current_time('Y-m-d'),
            'meta_compare' => '>=',
        ));

        $previous_event = $wpdb->get_var("SELECT meta_value FROM {$wpdb->prefix}postmeta WHERE meta_key='_event_date' AND meta_value < NOW() ORDER BY meta_value DESC LIMIT 1");
        $next_event = $wpdb->get_var("SELECT meta_value FROM {$wpdb->prefix}postmeta WHERE meta_key='_event_date' AND meta_value >= NOW() ORDER BY meta_value ASC LIMIT 1");

        $wpdb->update($table_name, array(
            'eventos_activos' => $active_events->found_posts,
            'proximo_evento' => $next_event,
            'evento_anterior' => $previous_event,
        )); 
    }

    public static function create_events_table() {
        global $wpdb;
        $table_name = $wpdb->prefix . 'event_stats';
        $charset_collate = $wpdb->get_charset_collate(); 

        $sql = "CREATE TABLE $table_name (
            id mediumint(9) NOT NULL AUTO_INCREMENT,
            eventos_activos int NOT NULL,
            proximo_evento datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
            evento_anterior datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
            PRIMARY KEY  (id)
        ) $charset_collate;";

        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
        dbDelta($sql);
    }
}
 