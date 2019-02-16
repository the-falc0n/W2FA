<?php

namespace SKI\WTFA;

use SKI\WTFA\Helpers\Session;
use SKI\WTFA\Helpers\TFA\TOTP;
use SKI\WTFA\TFA;

class Profile
{
    public static function totp_setup_field( $user )
    {
        if( ! wtfa_get_deep_option('ski_wtfa_settings__general.enabled') ) return false;

        $is_tfa_enabled = TFA::user_enabled( $user->ID );

        $args = [
            'is_tfa_enabled'   => $is_tfa_enabled,
            'totp_setup_url'   => add_query_arg( 'ski_wtfa_setup', wp_create_nonce('ski_wtfa_setup_nonce'), admin_url( 'profile.php' ) ),
            'totp_disable_url' => add_query_arg( 'ski_wtfa_disable', wp_create_nonce('ski_wtfa_disable_nonce'), admin_url( 'profile.php' ) )
        ];

        \wtfa_include_template( 'profile/two-factor-setup-field.php', $args );
    }
}
