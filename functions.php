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

if( ! function_exists( 'wtfa_create_tabs' ) ) {
    function wtfa_create_tabs( $page, array $tabs ) {
        global $ski_wtfa_current_tab;
        ob_start();

        $ski_wtfa_current_tab = isset( $_GET['tab'] ) ? $_GET['tab'] : ( isset( $tabs[0] ) ? $tabs[0]['slug'] : false );

        $data = [
            'page' => $page,
            'tabs' => $tabs,
            'current_tab' => $ski_wtfa_current_tab
        ];

        wtfa_include_template( 'utils/tabs.php', $data );

        return ob_get_clean();
    }
}

if( ! function_exists( 'wtfa_tabs_default_fields' ) ) {
    function wtfa_tabs_default_fields( $tabs_page )
    {
        global $ski_wtfa_current_tab;
        ?>
            <input type="hidden"
                   name="<?php echo "ski_wtfa_{$tabs_page}_current_tab"; ?>"
                   value="<?php echo $ski_wtfa_current_tab; ?>"/>
        <?php
    }
    add_action( 'ski_wtfa_resolve_tabs', 'wtfa_tabs_default_fields' );
}

if( ! function_exists( 'wtfa_get_deep_option' ) ) {
    function wtfa_get_deep_option( $option_key, $default = false )
    {
        $option_key_array = explode( '.', $option_key );
        $setting_key = current( $option_key_array );

        unset( $option_key_array[0] );

        $option_value = \get_option( $setting_key );
        if( ! $option_value ) return $default;

        if( is_array( $option_key_array ) ) {
            foreach ( $option_key_array as $_key) {
                if( ! isset( $option_value[ $_key ] ) ) {
                    return $default;
                }

                $option_value = $option_value[ $_key ];
            }
        }

        return $option_value;
    }
}
