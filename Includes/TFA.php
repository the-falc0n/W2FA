<?php

namespace SKI\WTFA;

use SKI\WTFA\Security\Key;
use Defuse\Crypto\Crypto;

class TFA
{
    protected static $table = 'ski_wtfa';
    protected static function table()
    {
        global $wpdb;
        $table = self::$table;

        return "{$wpdb->prefix}{$table}";
    }
    public static function user_enabled( $user_id = null )
    {
        global $wpdb;
        $table = self::table();

        $user_id = ! is_null( $user_id ) ? $user_id : get_current_user_id();

        $sql = "SELECT enabled
                FROM   {$table}
                WHERE  user_id = {$user_id}";

        return 1 == $wpdb->get_var( $sql );
    }
    public static function enable_user( $user_id, $tfa_key = null )
    {
        global $wpdb;
        $table = self::table();

        if (
            ! self::update_user_wtfa_key( $user_id, $tfa_key )
            && self::get_user_wtfa_key( $user_id ) != $tfa_key
        ) {
            return false;
        }

        $sql = "UPDATE {$table}
                SET    enabled = 1
                WHERE  user_id = {$user_id}
                       AND enabled = 0";

        return $wpdb->query( $sql );
    }
    public static function disable_user( $user_id = null )
    {
        global $wpdb;
        $table = self::table();

        $user_id = ! is_null( $user_id ) ? $user_id : get_current_user_id();

        $sql = "UPDATE {$table}
                SET    enabled = 0
                WHERE  user_id = {$user_id}
                       AND enabled = 1";

        return $wpdb->query( $sql );
    }
    public static function update_user_wtfa_key( $user_id, $tfa_key )
    {
        global $wpdb;
        $table = self::table();

        $_tfa_key = self::get_user_wtfa_key( $user_id );
        if( $tfa_key ) {
            $password = password_hash( md5( microtime() ), PASSWORD_BCRYPT );
            $encryption_key = Key::generate( $password );
            $tfa_key = Crypto::encrypt( $tfa_key, Key::unlock( $encryption_key, $password ) );
        }

        if( $_tfa_key ) {
            $sql = "UPDATE {$table}
                    SET    tfa_key = {$tfa_key},
                           encryption_key = {$encryption_key},
                           password = {$password}
                    WHERE  user_id = {$user_id}";

            return $wpdb->query( $sql );
        } else {
            return $wpdb->insert(
                $table,
                [
                    'user_id' => $user_id,
                    'tfa_key' => $tfa_key,
                    'encryption_key' => $encryption_key,
                    'password' => $password,
                    'enabled' => 1
                ]
            );
        }
    }
    public static function get_user_wtfa_key( $user_id = null )
    {
        global $wpdb;
        $table = self::table();

        $sql = "SELECT *
                FROM   {$table}
                WHERE  user_id = {$user_id}";
        $row = $wpdb->get_row( $sql );

        if( ! $row ) return false;

        $tfa_key = Crypto::decrypt( $row->tfa_key, Key::unlock( $row->encryption_key, $row->password ) );

        return $tfa_key;
    }
}
