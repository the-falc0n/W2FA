<?php

namespace SKI\WTFA;

class Events
{
    public static function activate()
    {
        // create tables
        Migration::create_tables();
    }
    public static function deactivate()
    {
        
    }
}
