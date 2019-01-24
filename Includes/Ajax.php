<?php

namespace SKI\WTFA;

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
        echo json_encode([
            'status' => true
        ]);
        wp_die();
    }
    public static function ski_wtfa_setup()
    {
        echo json_encode([
            'status' => true
        ]);
        wp_die();
    }
}
