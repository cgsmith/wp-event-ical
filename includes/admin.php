<?php

// Exit if accessed directly
defined('ABSPATH') || exit;

/**
 * Render the admin page
 */
function wp_event_ical_admin_render()
{
    wp_event_ical_admin_header();
    wp_event_ical_admin_greet();
    wp_event_ical_admin_footer();
}

function wp_event_ical_export($wp)
{
    if (array_key_exists('page', $wp->query_vars) && $wp->query_vars['page'] === 'export-ics-file') {
        check_admin_referer('wp-event-ical-export');


        $terms = isset($_POST['cat']) ? $_POST['cat'] : 0;

        // Query for the specific taxonomy that we searched for
        $events = wp_event_calendar_fetch(array(
            'tax_query' =>
                array(
                    'taxonomy' => 'event-calendar',
                    'field' => 'term_id',
                    'terms' => $terms,
                ),
        ));

        $icsExport = new WP_Event_Exporter($events);
        $icsExport->getExportFile();
        exit;
    }
}

/**
 * Display introductory text and file upload form
 */
function wp_event_ical_admin_greet()
{
    echo '<div class="narrow">';
    echo '<p>' . esc_html__('Select which category of events to export.', 'wp-event-ical') . '</p>';
    //@todo choosing events might be too much to chew off right now?
    //echo '<p>' . esc_html__('Choose the events that you would like to export as an ICS file', 'wp-event-ical') . '</p>';
    echo '</div>';

    echo '<form action="' . admin_url('tools.php?page=export-ics-file') . '" method="post">';
    echo '<input type="hidden" name="action" value="wp-event-ical-export" />';
    // Display Dropdown of event categories
    wp_dropdown_categories(array(
        'taxonomy' => 'event-category',
        'hide_empty' => 0,
        'show_count' => 1,
    ));
    wp_nonce_field('wp-event-ical-export');
    submit_button(__('Export Events As iCal', 'wp-event-ical'), 'button');
    echo '</form>';
}

/**
 * Show the opening div with the main H2
 */
function wp_event_ical_admin_header()
{
    echo '<div class="wrap">';
    echo '<h2>' . __('Export iCal Events', 'wp-event-ical') . '</h2>';
}

/**
 * Close the div
 */
function wp_event_ical_admin_footer()
{
    echo '</div>';
}