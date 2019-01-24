<?php

namespace SKI\WTFA;

class TFA
{
    public static function user_enabled( $user_id = null )
    {
        $user_id = ! is_null( $user_id ) ? $user_id : get_current_user_id();

        return get_user_meta( $user_id, '_ski_wtfa_enabled', true );
    }
    public static function enable_user( $user_id, $tfa_key = null )
    {
        if (
            ! self::update_user_wtfa_key( $user_id, $tfa_key )
            && self::get_user_wtfa_key( $user_id ) != $tfa_key
        ) {
            return false;
        }
        return \update_user_meta( $user_id, '_ski_wtfa_enabled', true );
    }
    public static function disable_user( $user_id = null )
    {
        $user_id = ! is_null( $user_id ) ? $user_id : get_current_user_id();
        
        return \update_user_meta( $user_id, '_ski_wtfa_enabled', false );
    }
    public static function update_user_wtfa_key( $user_id, $tfa_key )
    {
        return \update_user_meta( $user_id, '_ski_wtfa_key', $tfa_key );
    }
    public static function get_user_wtfa_key( $user_id )
    {
        return \get_user_meta( $user_id, '_ski_wtfa_key', true );
    }
}
