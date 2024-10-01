<?php
class GE_Event_Security {

    public static function init() {
        add_action('admin_init', array(__CLASS__, 'check_user_permissions'));
    }

    public static function check_user_permissions() {
        if (!current_user_can('administrator')) {
            wp_die(__('No tienes permiso para realizar esta acción.', 'gestion-eventos'));
        }
    }
}
  