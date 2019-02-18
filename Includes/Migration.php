<?php

namespace SKI\WTFA;

class Migration
{
    public static function create_tables()
    {
        self::ski_wtfa_table();
    }
    public static function ski_wtfa_table()
    {
        global $wpdb;

        $charset_collate = $wpdb->get_charset_collate();

        $sql = "CREATE TABLE IF NOT EXISTS `{$wpdb->prefix}ski_wtfa` (
                 `ID` bigint(20) NOT NULL AUTO_INCREMENT,
                 `user_id` bigint(20) NOT NULL,
                 `tfa_key` varchar(512) NOT NULL,
                 `encryption_key` text NOT NULL,
                 `password` varchar(512) NOT NULL,
                 `enabled` tinyint(1) NOT NULL DEFAULT '0',
                 `created_on` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
                 `modified_on` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
                 PRIMARY KEY (`ID`)
                ) {$charset_collate}";

        require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );

        dbDelta( $sql );
    }
}
