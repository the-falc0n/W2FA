<?php

namespace SKI\WTFA;

use SKI\WTFA\Helpers\Session;
use SKI\WTFA\Helpers\TFA\TOTP;

class Profile
{
    public static function totp_setup_field( $user )
    {
        $is_tfa_enabled = \wtfa_user_enabled( $user->ID );

        $args = [
            'is_2fa_enabled'   => $is_2fa_enabled,
            'totp_setup_url'   => add_query_arg( 'ski_wtfa_setup', wp_create_nonce('ski_wtfa_setup_nonce'), admin_url( 'profile.php' ) ),
            'totp_disable_url' => add_query_arg( 'ski_wtfa_disable', wp_create_nonce('ski_wtfa_disable_nonce'), admin_url( 'profile.php' ) )
        ];

        \wtfa_include_template( 'profile/two-factor-setup-field.php', $args );
    }
}
