<?php

namespace SKI\WTFA\Utils;

class Base32
{
    private const BASE32_TABLE = [
        "A", "B", "C", "D", "E", "F", "G", "H", // 8
        "I", "J", "K", "L", "M", "N", "O", "P", // 16
        "Q", "R", "S", "T", "U", "V", "W", "X", // 24
        "Y", "Z", "2", "3", "4", "5", "6", "7", // 32
        "=" // Padding Character
    ];

    public static function encode( string $data, $padding = false )
    {
        if( gettype( $data ) != 'string' ) {
            throw new \Exception( "Invalid data type" );
        }

        $binary = implode( '', self::str_to_bin( $data ) );
        $five_bit_binary_array = str_split( $binary, 5 );

        while ( count( $five_bit_binary_array ) % 8 !== 0 ) {
            $five_bit_binary_array[] = null;
        }

        $base32 = '';
        foreach( $five_bit_binary_array as $bin ) {
            $char = 32;
            if( ! is_null( $bin ) ) {
                $char = bindec( str_pad( $bin, 5, 0, STR_PAD_RIGHT ) );
            }
            $base32 .= self::BASE32_TABLE[ $char ];
        }


        if( ! $padding ) {
            $base32 = str_replace( '=', '', $base32 );
        }

        return $base32;
    }

    public static function decode( $encoded_string )
    {
        if( empty( $encoded_string ) ) return false;

        if( gettype( $encoded_string ) != 'string' ) {
            throw new \Exception( "Invalid data type" );
        }

        $paddingCharCount = substr_count( $encoded_string, self::BASE32_TABLE[32] );
        // Only work in upper cases
        $encoded_string = strtoupper( $encoded_string );
        // Remove anything that is not base32 alphabet
        $pattern = '/[^A-Z2-7]/';
        $encoded_string = preg_replace( $pattern, '', $encoded_string );
        if ( strlen( $encoded_string ) == 0 ) {
            // Gives an empty string
            return '';
        }
        $base32_flipped_table = array_flip( self::BASE32_TABLE );
        $base32Array = str_split( $encoded_string );

        $string = '';
        foreach ( $base32Array as $str ) {
            $char = $base32_flipped_table[ $str ];
            if ( $char !== 32 ) {
                // Ignore the padding character
                $string .= sprintf( '%05b', $char );
            }
        }

        $binaryArray = str_split( $string, 8 );

        $decoded_string = '';
        foreach ( $binaryArray as $bin ) {
            // Pad each value to 8 bits
            $bin = str_pad( $bin, 8, 0 );
            // Convert binary strings to ASCII
            $decoded_string .= chr( bindec( $bin ) );
        }

        return $decoded_string;
    }

    private static function str_to_bin( $string ) {
        $char_array = str_split( $string, 1 );
        $binary_array = [];

        if( ! count( $char_array ) ) {
            return false;
        }

        foreach( $char_array as $char ) {
            $binary_array[] = sprintf( '%08b', ord( $char ) );
        }

        return $binary_array;
    }
}
