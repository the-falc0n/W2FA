<?php

namespace SKI\WTFA\Views\Page;

class Admin_Settings {
    public static function register()
    {
        add_submenu_page(
            'options-general.php',
            __( 'Wordpress 2FA', 'ski-wtfa' ),
            __( 'Wordpress 2FA', 'ski-wtfa' ),
            'manage_options',
            'ski-wtfa-settings',
            [ __CLASS__, 'layout' ]
        );
    }
    public static function layout()
    {
        wtfa_include_template( 'settings/admin-settings.php' );
    }
}
