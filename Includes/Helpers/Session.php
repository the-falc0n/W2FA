<?php

namespace SKI\WTFA\Helpers;

class Session
{
    private static $session_id = null;

    public static function init()
    {
        if( self::$session_id ) return self::$session_id;

        session_start();
        self::$session_id = session_id();

        return self::$session_id;
    }
    public static function isset( $key )
    {
        self::init();
        if( isset( $_SESSION['ski_wtfa'][ $key ] ) ) {
            return true;
        }

        return false;
    }
    public static function get( $key )
    {
        self::init();
        if( isset( $_SESSION['ski_wtfa'][ $key ] ) ) {
            return $_SESSION['ski_wtfa'][ $key ];
        }

        return false;
    }
    public static function add( $key, $value )
    {
        self::update( $key, $value );
    }
    public static function update( $key, $value )
    {
        self::init();
        $_SESSION['ski_wtfa'][ $key ] = $value;
    }
    public static function delete( $key )
    {
        self::init();
        if( isset( $_SESSION['ski_wtfa'][ $key ] ) ) {
            unset( $_SESSION['ski_wtfa'][ $key ] );
            return true;
        }

        return false;
    }
    public static function destroy()
    {
        self::init();
        self::$session_id = null;
        session_destroy();
    }
}
