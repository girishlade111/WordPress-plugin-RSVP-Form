<?php
/**
 * Lade Stack RSVP Widget - Uninstall Handler
 * 
 * This file runs when the plugin is deleted from WordPress.
 * It removes all plugin data from the database.
 *
 * @package Lade_Stack_RSVP
 * @since 1.0.0
 */

// Exit if not called from WordPress uninstall
if (!defined('WP_UNINSTALL_PLUGIN')) {
    exit;
}

// Security check - only admins can uninstall
if (!current_user_can('manage_options')) {
    exit;
}

/**
 * Clean up all plugin data on uninstall
 */
function lade_rsvp_cleanup() {
    global $wpdb;

    // Remove all plugin options
    delete_option('lade_rsvp_default_capacity');
    delete_option('lade_rsvp_default_emailjs_service');
    delete_option('lade_rsvp_default_emailjs_template');
    delete_option('lade_rsvp_default_emailjs_key');
    
    // Remove any transients
    delete_transient('lade_rsvp_assets_loaded');
    
    // Remove any custom post types or taxonomies if they existed
    // (This plugin doesn't use them, but included for completeness)
    
    // Log uninstallation
    if (defined('WP_DEBUG') && WP_DEBUG) {
        error_log('Lade Stack RSVP Widget uninstalled - All data cleaned at ' . current_time('mysql'));
    }
}

// Run cleanup
lade_rsvp_cleanup();
