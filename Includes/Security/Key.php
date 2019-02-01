<?php

namespace SKI\WTFA\Security;

use Defuse\Crypto\KeyProtectedByPassword as KPBP;

class Key
{
    public static function unlock( $password )
    {
        try {
            return self::generate( $password )->unlockKey( $password );
        } catch ( Defuse\Crypto\Exception $e ) {
            return false;
        }
    }
    public static function generate( $password )
    {
        try {
            return KPBP::createRandomPasswordProtectedKey( $password );
        } catch ( Defuse\Crypto\Exception $e ) {
            return false;
        }
    }
    public static function update( $current_password, $new_password )
    {
        try {
            return self::generate( $current_password )->changePassword( $current_password, $new_password );
        } catch ( Defuse\Crypto\Exception $e ) {
            return false;
        }
    }
}
