<?php

namespace SKI\WTFA;

use SKI\WTFA\Helpers\Session;
use SKI\WTFA\Helpers\TFA\TOTP;
use SKI\WTFA\TFA;

class Ajax
{
    public static function init()
    {
        add_action(
            'wp_ajax_ski_wtfa_verify_pin',
            [ __CLASS__, 'ski_wtfa_verify_pin' ]
        );
        add_action(
            'wp_ajax_nopriv_ski_wtfa_verify_pin',
            [ __CLASS__, 'ski_wtfa_verify_pin' ]
        );
        add_action(
            'wp_ajax_ski_wtfa_setup',
            [ __CLASS__, 'ski_wtfa_setup' ]
        );
    }
    public static function ski_wtfa_verify_pin()
    {
        if(
            empty( $_POST['ski_wtfa_nonce'] )
            || ! wp_verify_nonce( $_POST['ski_wtfa_nonce'], 'ski_user_authenticate' )
        ) {
            echo json_encode( [
                'status'  => false,
                'message' => 'Unauthorized Access.'
            ] );
            wp_die();
        }

        $totp     = new TOTP();
        $wtfa_key = TFA::get_user_wtfa_key();
        $wtfa_pin = $_POST['pin'];
        if( $totp->generate_token( $wtfa_key ) === $wtfa_pin ) {
            $wtfa_key = apply_filters( 'ski_wtfa_before_login', $wtfa_key, $wtfa_pin );
            if( \is_wp_error( $wtfa_key ) ) {
                echo json_encode( [
                    'status'  => false,
                    'message' => 'Invalid Provided Key.'
                ] );
                wp_die();
            }

            $status = Session::delete( '_ski_user_authenticated' );
            if( ! $status ) {
                echo json_encode( [
                    'status'  => false,
                    'message' => 'Unable To LogIn.'
                ] );
                wp_die();
            }

            do_action( 'ski_wtfa_login', $status, $wtfa_key, $wtfa_pin );

            echo json_encode( [
                'status'  => true,
                'message' => 'Login Successfull.'
            ] );
        }
        wp_die();
    }
    public static function ski_wtfa_setup()
    {
        if(
            empty( $_POST['ski_wtfa_nonce'] )
            || ! wp_verify_nonce( $_POST['ski_wtfa_nonce'], 'ski_wtfa_setup_nonce' )
        ) {
            echo json_encode( [
                'status'  => false,
                'message' => 'Unauthorized Access.'
            ] );
            wp_die();
        }

        $totp     = new TOTP();
        $wtfa_key = Session::get( '_ski_wtfa_setup_secret' );
        $wtfa_pin = $_POST['pin'];
        if( $totp->generate_token( $wtfa_key ) === $wtfa_pin ) {
            $wtfa_key = apply_filters( 'ski_wtfa_before_setup', $wtfa_key, $wtfa_pin );
            if( \is_wp_error( $wtfa_key ) ) {
                echo json_encode( [
                    'status'  => false,
                    'message' => 'Invalid Provided Key.'
                ] );
                wp_die();
            }

            $status = TFA::enable_user( \get_current_user_id(), $wtfa_key );
            if( ! $status ) {
                echo json_encode( [
                    'status'  => false,
                    'message' => 'Unable to Setup 2-factor Authentication.'
                ] );
                wp_die();
            }

            do_action( 'ski_wtfa_setup', $status, $wtfa_key, $wtfa_pin );

            echo json_encode( [
                'status'  => true,
                'message' => 'Successfully Setup 2-factor Authentication.'
            ] );
        }
        wp_die();
    }
}
