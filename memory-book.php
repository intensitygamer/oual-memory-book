<?php
/*
Plugin Name: Once Upon A Legacy Memory Book
Plugin URI: https://rapidvisa.com
Description: A collaborative memory book plugin that will be able to collect letters and photos from friends, family and coworkers.
and photos from friends, family and coworkers.
Version: 1.0
Author: John Patrick Tabanas SR. Full Stack Developer
Author URI: http://impatrickdev.com
*/

if (!defined('ABSPATH')) exit;


// System Constant
define( 'OUAL_NAME', 'oual_memory_book' ); //Plugin Name
define( 'OUAL_NAME_APP', plugin_dir_url(__FILE__) ); //Plugin Directory
define( 'OUAL_NAME_PATH', plugin_dir_path(__FILE__) ); //Plugin Directory Path

// Database Activation Hook
register_activation_hook( __FILE__, 'oual_app_installation_script_function' );
function oual_app_installation_script_function() {
	include('install-script.php');
}


// Register Page Templates
function oual_memory_book_add_page_template ( $templates ) {
    $templates['page-registration.php'] = 'Memory Book Registration Page';
    $templates['page-login.php'] = 'Memory Book Login Page';
    $templates['page-dashboard.php'] = 'Memory Book Dasboard Page';
    return $templates;
}

add_filter ('theme_page_templates', 'oual_memory_book_add_page_template');

// Include Registered Template
function oual_redirect_page_template ( $template ) {

    if ( get_page_template_slug() === 'page-registration.php' ) {

        if ( $theme_file = locate_template( array( 'page-registration.php' ) ) ) {
            $template = $theme_file;
        } else {
            $template = OUAL_NAME_PATH . 'page-registration.php';
        }

    }

    if ( get_page_template_slug() === 'page-login.php' ) {

        if ( $theme_file = locate_template( array( 'page-login.php' ) ) ) {
            $template = $theme_file;
        } else {
            $template = OUAL_NAME_PATH . 'page-login.php';
        }

    }

    if ( get_page_template_slug() === 'page-dashboard.php' ) {

        if ( $theme_file = locate_template( array( 'page-dashboard.php' ) ) ) {
            $template = $theme_file;
        } else {
            $template = OUAL_NAME_PATH . 'page-dashboard.php';
        }

    }

    if ( $template == '' ) {
        throw new \Exception('No template found');
    }

    return $template;
}

add_filter( 'template_include', 'oual_redirect_page_template' );

?>