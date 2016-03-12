<?php
/**
 * Sets our SCSS constant for the improved build process
 *
 * @since Blvd 2.7.0
 */
if (!defined('HJI_BLVD_SCSS')) {
    define('HJI_BLVD_SCSS', true);
}

/**
 * Unregistering some unused sidebars from the parent theme
 */
if ( !function_exists('hji_keenan_widgets_init') ) {
    function hji_keenan_widgets_init() {
        unregister_sidebar( 'idx-horizontal-search' );
        unregister_sidebar( 'blvd-main-sidebarwidgets' );
        unregister_sidebar( 'blvd-topbar-sidebarwidgets' );
    }
    add_action( 'widgets_init', 'hji_keenan_widgets_init' );
}

/**
 * Loading in PT Serif from Google fonts
 */
if ( !function_exists('hji_keenan_load_fonts') ) {
    function hji_keenan_load_fonts() {
        wp_enqueue_style( 'googleFonts', 'https://fonts.googleapis.com/css?family=PT+Serif' );
    }
    add_action( 'wp_enqueue_scripts', 'hji_keenan_load_fonts' );
}

/**
 * Loading in child scripts
 */
if (!function_exists('hji_keenan_enqueue_scripts')) {
    function hji_keenan_enqueue_scripts() {
        wp_enqueue_script( 'hji_keenan_scripts', get_stylesheet_directory_uri() . '/assets/js/main.js', array( 'jquery' ), null, true );
    }
    add_action('wp_enqueue_scripts', 'hji_keenan_enqueue_scripts' );
}
