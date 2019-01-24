<?php

// Authenticain
add_action( 'after_setup_theme', [ 'SKI\WTFA\Auth', 'init' ] );
add_action( 'after_setup_theme', [ 'SKI\WTFA\Ajax', 'init' ] );

// Register Admin Menu Pages
add_action( 'admin_menu', [ 'SKI\WTFA\Views\Page\Admin_Settings', 'register' ] );

// Register Admin Scripts
add_action( 'admin_enqueue_scripts', 'wfta_register_admin_scripts' );

// Enqueue Admin Scripts
add_action( 'admin_enqueue_scripts', 'wfta_enqueue_admin_scripts' );
