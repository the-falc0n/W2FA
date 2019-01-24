<?php

namespace SKI\WTFA;

use SKI\WTFA\Helpers\Session;
use SKI\WTFA\Helpers\TFA\TOTP;
use SKI\WTFA\TFA;

class Auth
{
    private static $is_tfa_enabled = false;
    private static $tfa_key        = false;
    public static function init()
    {
        \add_filter(
            'wp_authenticate_user',
            [ __CLASS__, 'check_tfa_enabled' ],
            10,
            2
        );

        \add_action(
            'admin_init',
            [ __CLASS__, 'totp_authenticate' ],
            10,
            1
        );

        \add_action(
            'admin_init',
            [ __CLASS__, 'totp_setup' ],
            10,
            1
        );

        \add_action(
            'admin_init',
            [ __CLASS__, 'totp_disable' ],
            10,
            1
        );
    }
    public static function check_tfa_enabled( $user, $password )
    {
        if( \is_wp_error( $user ) ) return $user;

        self::$is_tfa_enabled = TFA::user_enabled( $user->ID );
        if( ! self::$is_tfa_enabled ) return $user;

        Session::add( '_ski_user_authenticated', false );

        return $user;
    }
    public static function totp_authenticate()
    {
        if( ! Session::isset( '_ski_user_authenticated' ) ) return false;

        if(
            $_SERVER['REQUEST_METHOD'] === 'POST'
            && isset( $_POST['ski_wtfa_nonce'] )
            && wp_verify_nonce( $_POST['ski_wtfa_nonce'], 'ski_user_authenticate' )
        ) {
            return false;
        }

        if( ! isset( $_GET['ski_wtfa_nonce'] ) ) {
            $_nonce = wp_create_nonce( 'ski_user_authenticate' );
            wp_redirect( add_query_arg( 'ski_wtfa_nonce', $_nonce, admin_url( 'admin.php' ) ) );
        } else {
            if( ! wp_verify_nonce( $_GET['ski_wtfa_nonce'], 'ski_user_authenticate' ) ) {
                $_nonce = wp_create_nonce( 'ski_user_authenticate' );
                wp_redirect( add_query_arg( 'ski_wtfa_nonce', $_nonce, admin_url( 'admin.php' ) ) );
            }
        }

        set_current_screen();
        \wtfa_include_template( 'auth/two-factor.php' );
        die();
    }
    public static function totp_setup()
    {
        if( ! isset( $_GET['ski_wtfa_setup'] ) ) {
            return false;
        }

        $ski_wtfa_setup_nonce = $_GET['ski_wtfa_setup'];

        if(
            TFA::user_enabled()
            || ! wp_verify_nonce( $ski_wtfa_setup_nonce, 'ski_wtfa_setup_nonce' )
        ) {
            $_nonce = wp_create_nonce( 'ski_user_authenticate' );
            wp_redirect( admin_url() );
        }

        $totp   = new TOTP();
        $secret = $totp->generate_secret();
        Session::add( '_ski_wtfa_setup_secret', $secret );
        $data = [
            'totp_secret'          => $secret,
            'totp_secret_formated' => implode( "-", str_split( $secret, 4 ) ),
            'qr_code_url'          => TOTP::qr_code_url( $secret, 'officialr.kay', 'Google' )
        ];

        set_current_screen();
        \wtfa_include_template( 'auth/two-factor-totp-setup.php', $data );
        die();
    }
    public static function totp_disable()
    {
        if(
            ! empty( $_GET['ski_wtfa_disable'] )
            && TFA::user_enabled()
            && wp_verify_nonce( $_GET['ski_wtfa_disable'], 'ski_wtfa_disable_nonce' )
        ) {
            TFA::disable_user();
        }
    }
}
