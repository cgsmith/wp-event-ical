<?php

// Exit if accessed directly
defined('ABSPATH') || exit;

/**
 * Render the admin page
 */
function wp_event_ical_admin_render()
{

    // @todo - show a first step to select events
    $step = empty($_GET['step']) ? 0 : (int)$_GET['step'];

    switch ($step) {
        //Ask for the events the user wants to export
        case 0:
            wp_event_ical_admin_header(); 
            wp_event_ical_admin_greet();
            break;
        // Export the events as an ICS file
        case 1: 
            check_admin_referer('wp-event-ical-export');
            
            // I think there should be some function in WP Event Calendar that can fetch all events? 
            $wpEvent = new WP_Event_Calendar_List_Table(array('screen'=>'event'));
            $wpEvent->prepare_items();
            break;
    }

    wp_event_ical_admin_footer();
}

/**
 * Display introductory text and file upload form
 */
function wp_event_ical_admin_greet()
{
    echo '<div class="narrow">';
    echo '<p>' . esc_html__('Export events from WP Event Calendar', 'wp-event-ical') . '</p>';
    //@todo choosing events might be too much to chew off right now?
    //echo '<p>' . esc_html__('Choose the events that you would like to export as an ICS file', 'wp-event-ical') . '</p>';
    echo '</div>';

    echo '<form action="' . admin_url('tools.php?page=export-ical-event&step=1') . '" method="post">';
    echo '<input type="hidden" name="action" value="wp-event-ical-export" />';
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