<?php

// Authenticain
add_action( 'after_setup_theme', [ 'SKI\WTFA\Auth', 'init' ] );
add_action( 'after_setup_theme', [ 'SKI\WTFA\Ajax', 'init' ] );

// Register Admin Menu Pages
add_action( 'init', [ 'SKI\WTFA\Views\Page\Admin_Settings', 'init' ] );

// Register Admin Scripts
add_action( 'admin_enqueue_scripts', 'wfta_register_admin_scripts' );

// Enqueue Admin Scripts
add_action( 'admin_enqueue_scripts', 'wfta_enqueue_admin_scripts' );

// Adding Totp Setup Field To User Profile
add_action( 'show_user_profile', [ 'SKI\WTFA\Profile', 'totp_setup_field' ] );
