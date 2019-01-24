<?php

namespace SKI\WTFA\Helpers\TFA;

use SKI\WTFA\Helpers\TFA\HOTP;

class TOTP extends HOTP
{
    private $startTime;
    private $timeInterval;
    public function __construct( $algo = 'sha1', $start = 0, $ti = 30 )
    {
        parent::__construct( $algo );
        $this->startTime = $start;
        $this->timeInterval = $ti;
    }
    public function generate_token( $key, $time = null, $length = 6 )
    {
        // Pad the key if necessary
        if ( $this->algo === 'sha256' ) {
            $key = $key . substr( $key, 0, 12 );
        } elseif ( $this->algo === 'sha512' ) {
            $key = $key . $key . $key . substr( $key, 0, 4 );
        }
        // Get the current unix timestamp if one isn't given
        if ( is_null( $time ) ) {
            $time = ( new \DateTime() )->getTimestamp();
        }
        // Calculate the count
        $now   = $time - $this->startTime;
        $count = floor( $now / $this->timeInterval );
        // Generate a normal HOTP token
        return parent::generate_token( $key, $count, $length );
    }
    public static function qr_code_url(
        $secret,
        $label,
        $issuer,
        $algo = 'sha1',
        $digits = 6,
        $period = 30
    )
    {
        $oauth_url_query_array = [
            'secret'    => $secret,
            'issuer'    => $issuer,
            'algorithm' => $algo,
            'digits'    => $digits,
            'period'    => $period
        ];
        $oauth_url_query = http_build_query( $oauth_url_query_array );
        $qr_code_content = "otpauth://totp/{$label}?{$oauth_url_query}";
        $qr_code_url     = "https://chart.googleapis.com/chart?cht=qr&chs=160x160&chl={$qr_code_content}&choe=UTF-8&chld=L|0";

        return $qr_code_url;
    }
}
