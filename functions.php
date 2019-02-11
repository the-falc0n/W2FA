<?php

if( ! function_exists( 'wtfa_include_template' ) ) {
    function wtfa_include_template( string $template, array $arguments = [] )
    {
        $template_file_path = realpath( SKI_WTFA_PLUGIN_BASE_PATH . 'templates/' . $template );

        // Check Template File Exists
        if( ! file_exists( $template_file_path ) ) {
            return false;
        }

        extract( $arguments );

        include $template_file_path;
    }
}

if( ! function_exists( 'wfta_register_admin_scripts' ) ) {
    function wfta_register_admin_scripts()
    {
        wp_register_script(
            'ski-wfta-admin',
            SKI_WTFA_PLUGIN_BASE_URL . 'assets/js/admin.js',
            array( 'jquery' ),
            null,
            true
        );

        wp_register_style(
            'ski-wfta-admin',
            SKI_WTFA_PLUGIN_BASE_URL . 'assets/css/admin.min.css'
        );

        wp_register_script(
            'ski-wfta-auth',
            SKI_WTFA_PLUGIN_BASE_URL . 'assets/js/auth.js',
            array( 'jquery' ),
            null,
            true
        );

        wp_register_style(
            'ski-wfta-auth',
            SKI_WTFA_PLUGIN_BASE_URL . 'assets/css/auth.min.css'
        );

        wp_register_script(
            'ski-wfta-setup',
            SKI_WTFA_PLUGIN_BASE_URL . 'assets/js/auth-setup.js',
            array( 'jquery' ),
            null,
            true
        );

        wp_register_style(
            'ski-wfta-setup',
            SKI_WTFA_PLUGIN_BASE_URL . 'assets/css/auth-setup.min.css'
        );
    }
}

if( ! function_exists( 'wfta_enqueue_admin_scripts' ) ) {
    function wfta_enqueue_admin_scripts( $hook )
    {
        if( $hook === 'ski-wtfa-auth' ) {
            wp_enqueue_script( 'ski-wfta-auth' );
            wp_enqueue_style( 'ski-wfta-auth' );
            return;
        }
        if( $hook === 'ski-wtfa-setup' ) {
            wp_enqueue_script( 'ski-wfta-setup' );
            wp_enqueue_style( 'ski-wfta-setup' );
            return;
        }
        wp_enqueue_script( 'ski-wfta-admin' );
        wp_enqueue_style( 'ski-wfta-admin' );
    }
}

if( ! function_exists( 'wfta_get_user_password' ) ) {
    function wfta_get_user_password( $user_id ) {
        $user = get_user_by( 'ID', $user_id );

        if( empty( $user ) ) return false;

        return $user->password;
    }
}
