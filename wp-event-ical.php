<?php

/**
 * @wordpress-plugin
 * Plugin Name:       WP Event iCal
 * Plugin URI:        http://example.com/plugin-name-uri/
 * Description:       This adds exportable iCal/ICS files to the WP Event Calendar plugin
 * Version:           0.1.0
 * Author:            Chris Smith
 * Author URI:        http://www.cgsmith.net
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 */

// If this file is called directly, abort.
defined('ABSPATH') || exit;

/**
 * Requires all of the plugin's files
 */
function _wp_event_ical_require()
{
    $pluginPath = plugin_dir_path(__FILE__);
    require_once($pluginPath . 'includes/wp-event-export.php');
    require_once($pluginPath . 'includes/admin.php');
}
add_action('plugins_loaded', '_wp_event_ical_require');


/**
 * The code that runs during plugin activation.
 */
function wp_event_ical_activation()
{
    // @todo check if JJJ's plugin is installed - disable if not
}

/**
 * The code that runs during plugin deactivation.
 */
function wp_event_ical_deactivation()
{
}

/**
 * Render the iCal export link on the appropriate pages. For now just the tools page and at 
 * the end of the WP Event Calendar links
 */
function wp_event_ical_link()
{

    // The only way I could get this to work is duplicate JJJ's code - there is probably a better way
    // Get post types
    $post_types = wp_event_calendar_allowed_post_types();

    // Loop through and add submenus
    foreach ($post_types as $post_type) {

        // 'post' post type needs special handling
        $parent = ('post' === $post_type)
            ? 'edit.php'
            : "edit.php?post_type={$post_type}";

        // add the submenu page
        add_submenu_page(
            $parent,
            __('Export iCal', 'wp-event-ical'),
            __('Export iCal', 'wp-event-ical'),
            'read_calendar',
            'export-calendar-export',
            'wp_event_ical_admin_render'
        );
    }

    // Add the export tool to the Tools section of WordPress as well
    add_management_page(
        __('Export iCal', 'wp-event-ical'),
        __('Export iCal', 'wp-event-ical'),
        'read_calendar',
        'export-ical-event',
        'wp_event_ical_admin_render'
    );

}


// set to priority 15 so it is added after JJJ's plugin
add_action('admin_menu', 'wp_event_ical_link', 15);

// Register activation and deactiviation hooks
register_activation_hook(__FILE__, 'wp_event_ical_activation');
register_deactivation_hook(__FILE__, 'wp_event_ical_deactivation');

