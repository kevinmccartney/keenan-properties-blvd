<?php
/**
 * Sets our SCSS constant for the improved build process
 *
 * @since Blvd 2.7.0
 */
if ( !defined( 'HJI_BLVD_SCSS' ) ) {
    define( 'HJI_BLVD_SCSS', true );
}

/**
 * Unregistering some unused sidebars from the parent theme
 */
if (!function_exists('hji_keenan_widgets_init')) {
    function hji_keenan_widgets_init() {
        unregister_sidebar( 'idx-horizontal-search');
        unregister_sidebar( 'blvd-main-sidebarwidgets');
        unregister_sidebar( 'blvd-topbar-sidebarwidgets');
    }
    add_action('widgets_init', 'hji_keenan_widgets_init', 11);
}
