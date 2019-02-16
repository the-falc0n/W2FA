<?php

namespace SKI\WTFA\Views\Page;

class Admin_Settings {
    private static $tabs = [
        [
            'title' => 'General',
            'slug'  => 'general',
            'view'  => [ self::class, 'general_tab' ]
        ],
        // [
        //     'title' => 'Security',
        //     'slug'  => 'security',
        //     'view'  => [ self::class, 'security_tab' ]
        // ],
        // [
        //     'title' => 'About',
        //     'slug'  => 'about',
        //     'view'  => [ self::class, 'about_tab' ]
        // ]
    ];
    public static function init()
    {
        add_action( 'admin_menu', [ __CLASS__, 'register' ] );

        // save settings
        self::save();
    }
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
    public static function tabs()
    {
        return \wtfa_create_tabs( 'ski-wtfa-settings', self::$tabs );
    }
    public static function layout()
    {
        $data = [
            'tabs' => self::tabs()
        ];

        \wtfa_include_template( 'settings/admin-settings.php', $data );
    }
    public static function general_tab()
    {
        $data = [
            'settings' => \get_option( 'ski_wtfa_settings__general', [] )
        ];

        \wtfa_include_template( 'tabs/settings/general.php', $data );
    }
    public static function security_tab()
    {
        $data = [];

        \wtfa_include_template( 'tabs/settings/security.php', $data );
    }
    public static function about_tab()
    {
        $data = [];

        \wtfa_include_template( 'tabs/settings/about.php', $data );
    }
    public static function save()
    {
        if( empty( $_POST['ski_wtfa_ski-wtfa-settings_current_tab'] ) ) return false;

        if( empty( $_POST['ski-wtfa-setting'] ) ) return false;

        $tab      = trim( $_POST['ski_wtfa_ski-wtfa-settings_current_tab'] );
        $settings = isset( $_POST['ski_wtfa_settings'][ $tab ] ) ? $_POST['ski_wtfa_settings'][ $tab ] : [];

        switch ( $tab ) {
            case 'general':
                return self::save_general_settings( $settings );
                break;
        }

        return false;
    }
    private static function save_general_settings( $settings )
    {
        $setting_key = "ski_wtfa_settings__general";

        if( \get_option( $setting_key ) !== false ) {
            \update_option( $setting_key, $settings );
        } else {
            \add_option( $setting_key, $settings );
        }
    }
}
