<?php
/**
 * Plugin Name: Lade Stack RSVP Widget
 * Plugin URI: https://ladestack.in
 * Description: Free AI-Powered Client-Side RSVP Widget with Draggable Form, Live Counter, QR Codes, EmailJS Integration & Admin Dashboard. No database required - uses localStorage.
 * Version: 1.0.0
 * Author: Lade Stack
 * Author URI: https://ladestack.in
 * License: GPL v2 or later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: lade-stack-rsvp
 * Domain Path: /languages
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

// Define plugin constants
define('LADE_RSVP_VERSION', '1.0.0');
define('LADE_RSVP_PLUGIN_URL', plugin_dir_url(__FILE__));
define('LADE_RSVP_PLUGIN_PATH', plugin_dir_path(__FILE__));

/**
 * Main Plugin Class
 */
final class Lade_Stack_RSVP {
    
    /**
     * Single instance of the class
     */
    private static $instance = null;
    
    /**
     * Get instance
     */
    public static function get_instance() {
        if (null === self::$instance) {
            self::$instance = new self();
        }
        return self::$instance;
    }
    
    /**
     * Constructor
     */
    private function __construct() {
        add_shortcode('lade_rsvp_widget', array($this, 'render_shortcode'));
        add_action('wp_enqueue_scripts', array($this, 'enqueue_assets'));
        add_action('admin_menu', array($this, 'add_admin_menu'));
        add_action('admin_init', array($this, 'register_settings'));
        
        // Gutenberg Block support
        add_action('init', array($this, 'register_block'));
        add_action('enqueue_block_editor_assets', array($this, 'enqueue_block_assets'));
    }
    
    /**
     * Enqueue CDN assets
     */
    public function enqueue_assets() {
        // Only enqueue on pages with shortcode or block
        global $post;
        $has_block = is_a($post, 'WP_Post') && (has_shortcode($post->post_content, 'lade_rsvp_widget') || has_block('lade-stack/rsvp-widget', $post));
        
        if ($has_block) {
            // Interact.js for draggable
            wp_enqueue_script('interact-js', 'https://cdn.jsdelivr.net/npm/interactjs@1.10.23/dist/interact.min.js', array(), '1.10.23', true);

            // EmailJS
            wp_enqueue_script('emailjs', 'https://cdn.jsdelivr.net/npm/@emailjs/browser@3/dist/email.min.js', array(), '3.12.1', true);

            // QR Code.js
            wp_enqueue_script('qrcode-js', 'https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js', array(), '1.0.0', true);

            // FileSaver.js for CSV export
            wp_enqueue_script('filesaver-js', 'https://cdnjs.cloudflare.com/ajax/libs/FileSaver.js/2.0.5/FileSaver.min.js', array(), '2.0.5', true);

            // Canvas Confetti for celebrations
            wp_enqueue_script('canvas-confetti', 'https://cdn.jsdelivr.net/npm/canvas-confetti@1.9.2/dist/confetti.browser.min.js', array(), '1.9.2', true);
        }
    }

    /**
     * Register Gutenberg block
     */
    public function register_block() {
        wp_register_script(
            'lade-rsvp-block-editor',
            plugins_url('block.js', __FILE__),
            array('wp-blocks', 'wp-element', 'wp-components', 'wp-editor', 'wp-i18n'),
            LADE_RSVP_VERSION
        );

        register_block_type('lade-stack/rsvp-widget', array(
            'editor_script' => 'lade-rsvp-block-editor',
            'render_callback' => array($this, 'render_block'),
            'attributes' => array(
                'eventName' => array('type' => 'string', 'default' => 'Lade Stack Event'),
                'eventDate' => array('type' => 'string'),
                'eventTime' => array('type' => 'string'),
                'eventLocation' => array('type' => 'string'),
                'maxCapacity' => array('type' => 'number', 'default' => 50),
                'fields' => array('type' => 'string', 'default' => 'name,email,phone,guests,dietary'),
                'deadline' => array('type' => 'string'),
                'approvalMode' => array('type' => 'boolean', 'default' => false),
                'adminPassword' => array('type' => 'string', 'default' => 'ladestack123'),
                'emailjsService' => array('type' => 'string'),
                'emailjsTemplate' => array('type' => 'string'),
                'emailjsKey' => array('type' => 'string'),
                'theme' => array('type' => 'string', 'default' => 'light'),
                'showBranding' => array('type' => 'boolean', 'default' => true),
            ),
        ));
    }

    /**
     * Render Gutenberg block
     */
    public function render_block($attributes) {
        $atts = array(
            'event-name' => $attributes['eventName'],
            'event-date' => $attributes['eventDate'] ?? '',
            'event-time' => $attributes['eventTime'] ?? '',
            'event-location' => $attributes['eventLocation'] ?? '',
            'max-capacity' => $attributes['maxCapacity'],
            'fields' => $attributes['fields'],
            'deadline' => $attributes['deadline'] ?? '',
            'approval-mode' => $attributes['approvalMode'] ? 'true' : 'false',
            'admin-password' => $attributes['adminPassword'],
            'emailjs-service' => $attributes['emailjsService'] ?? '',
            'emailjs-template' => $attributes['emailjsTemplate'] ?? '',
            'emailjs-key' => $attributes['emailjsKey'] ?? '',
            'theme' => $attributes['theme'],
            'show-branding' => $attributes['showBranding'] ? 'true' : 'false',
        );
        return $this->render_shortcode($atts);
    }

    /**
     * Enqueue block editor assets
     */
    public function enqueue_block_assets() {
        wp_enqueue_style(
            'lade-rsvp-block-editor-styles',
            plugins_url('block-editor.css', __FILE__),
            array(),
            LADE_RSVP_VERSION
        );
    }
    
    /**
     * Render shortcode
     */
    public function render_shortcode($atts = array()) {
        // Default attributes
        $atts = shortcode_atts(array(
            // Event Settings
            'event-name' => 'Lade Stack Event',
            'event-date' => '',
            'event-time' => '',
            'event-location' => '',
            'event-description' => '',

            // Capacity Settings
            'max-capacity' => '50',
            'waitlist-enabled' => 'true',

            // Field Toggles
            'fields' => 'name,email,phone,guests,dietary',

            // Deadline
            'deadline' => '',

            // Approval Mode
            'approval-mode' => 'false',
            'admin-password' => 'ladestack123',

            // EmailJS Settings
            'emailjs-service' => '',
            'emailjs-template' => '',
            'emailjs-key' => '',

            // Styling
            'theme' => 'light',
            'position' => 'bottom-right',

            // Branding
            'show-branding' => 'true',

            // Pro Features (Phase 9)
            'language' => 'en', // i18n: en/mr
            'analytics-id' => '', // Google Analytics Tracking ID
            'custom-css' => '' // Custom CSS variables (JSON)
        ), $atts, 'lade_rsvp_widget');
        
        // Generate unique event ID from event name
        $event_id = sanitize_title($atts['event-name']);
        
        // Parse fields
        $fields_array = array_map('trim', explode(',', $atts['fields']));
        
        // Build widget
        ob_start();
        ?>
        <div id="lade-rsvp-widget-container"
             data-event-id="<?php echo esc_attr($event_id); ?>"
             data-event-name="<?php echo esc_attr($atts['event-name']); ?>"
             data-event-date="<?php echo esc_attr($atts['event-date']); ?>"
             data-event-time="<?php echo esc_attr($atts['event-time']); ?>"
             data-event-location="<?php echo esc_attr($atts['event-location']); ?>"
             data-event-description="<?php echo esc_attr($atts['event-description']); ?>"
             data-max-capacity="<?php echo esc_attr($atts['max-capacity']); ?>"
             data-waitlist-enabled="<?php echo esc_attr($atts['waitlist-enabled']); ?>"
             data-fields="<?php echo esc_attr($atts['fields']); ?>"
             data-deadline="<?php echo esc_attr($atts['deadline']); ?>"
             data-approval-mode="<?php echo esc_attr($atts['approval-mode']); ?>"
             data-admin-password="<?php echo esc_attr($atts['admin-password']); ?>"
             data-emailjs-service="<?php echo esc_attr($atts['emailjs-service']); ?>"
             data-emailjs-template="<?php echo esc_attr($atts['emailjs-template']); ?>"
             data-emailjs-key="<?php echo esc_attr($atts['emailjs-key']); ?>"
             data-theme="<?php echo esc_attr($atts['theme']); ?>"
             data-position="<?php echo esc_attr($atts['position']); ?>"
             data-show-branding="<?php echo esc_attr($atts['show-branding']); ?>"
             data-language="<?php echo esc_attr($atts['language']); ?>"
             data-analytics-id="<?php echo esc_attr($atts['analytics-id']); ?>"
             data-custom-css="<?php echo esc_attr($atts['custom-css']); ?>">
        </div>
        
        <?php
        // Include the widget script and styles
        include LADE_RSVP_PLUGIN_PATH . 'includes/widget.php';
        
        return ob_get_clean();
    }
    
    /**
     * Add admin menu
     */
    public function add_admin_menu() {
        add_options_page(
            'Lade Stack RSVP',
            'Lade Stack RSVP',
            'manage_options',
            'lade-stack-rsvp',
            array($this, 'render_admin_page'),
            'dashicons-calendar-alt',
            30
        );
    }
    
    /**
     * Register settings
     */
    public function register_settings() {
        register_setting('lade_rsvp_settings', 'lade_rsvp_default_capacity');
        register_setting('lade_rsvp_settings', 'lade_rsvp_default_emailjs_service');
        register_setting('lade_rsvp_settings', 'lade_rsvp_default_emailjs_template');
        register_setting('lade_rsvp_settings', 'lade_rsvp_default_emailjs_key');
    }
    
    /**
     * Render admin page
     */
    public function render_admin_page() {
        ?>
        <div class="wrap">
            <h1>🎉 Lade Stack RSVP Widget Settings</h1>
            <p>Configure default settings for your RSVP widgets. Each widget can override these via shortcode attributes.</p>
            
            <form method="post" action="options.php">
                <?php settings_fields('lade_rsvp_settings'); ?>
                <?php do_settings_sections('lade_rsvp_settings'); ?>
                
                <table class="form-table">
                    <tr>
                        <th scope="row">Default Max Capacity</th>
                        <td>
                            <input type="number" name="lade_rsvp_default_capacity" value="<?php echo esc_attr(get_option('lade_rsvp_default_capacity', '50')); ?>" class="regular-text" />
                            <p class="description">Default maximum RSVP capacity for new widgets.</p>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">EmailJS Service ID</th>
                        <td>
                            <input type="text" name="lade_rsvp_default_emailjs_service" value="<?php echo esc_attr(get_option('lade_rsvp_default_emailjs_service')); ?>" class="regular-text" />
                            <p class="description">Your EmailJS Service ID (optional, can set per-widget).</p>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">EmailJS Template ID</th>
                        <td>
                            <input type="text" name="lade_rsvp_default_emailjs_template" value="<?php echo esc_attr(get_option('lade_rsvp_default_emailjs_template')); ?>" class="regular-text" />
                            <p class="description">Your EmailJS Template ID.</p>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">EmailJS Public Key</th>
                        <td>
                            <input type="text" name="lade_rsvp_default_emailjs_key" value="<?php echo esc_attr(get_option('lade_rsvp_default_emailjs_key')); ?>" class="regular-text" />
                            <p class="description">Your EmailJS Public Key.</p>
                        </td>
                    </tr>
                </table>
                
                <?php submit_button(); ?>
            </form>
            
            <hr style="margin: 40px 0;">
            
            <h2>📖 Quick Start Guide</h2>
            <div style="background: #fff; padding: 20px; border-left: 4px solid #2271b1;">
                <h3>Step 1: Add Widget to Page</h3>
                <p>Use the shortcode in any page or post:</p>
                <code style="display: block; padding: 10px; background: #f0f0f1; margin: 10px 0;">[lade_rsvp_widget event-name="My Event" max-capacity="100"]</code>
                
                <h3>Step 2: Configure EmailJS (Optional)</h3>
                <ol>
                    <li>Sign up at <a href="https://www.emailjs.com/" target="_blank">EmailJS.com</a> (free tier available)</li>
                    <li>Create an Email Service (e.g., Gmail)</li>
                    <li>Create an Email Template with variables: {{name}}, {{email}}, {{event_name}}, {{event_date}}</li>
                    <li>Add your Service ID, Template ID, and Public Key to the shortcode or settings above</li>
                </ol>
                
                <h3>Step 3: Customize Fields</h3>
                <p>Control which fields appear:</p>
                <code style="display: block; padding: 10px; background: #f0f0f1; margin: 10px 0;">[lade_rsvp_widget fields="name,email,guests"]</code>
                <p>Available fields: name, email, phone, guests, dietary</p>
                
                <h3>Step 4: Enable Approval Mode</h3>
                <code style="display: block; padding: 10px; background: #f0f0f1; margin: 10px 0;">[lade_rsvp_widget approval-mode="true" admin-password="yourpassword"]</code>
            </div>
            
            <hr style="margin: 40px 0;">
            
            <h2>📋 Shortcode Reference</h2>
            <table class="wp-list-table widefat fixed striped">
                <thead>
                    <tr>
                        <th>Attribute</th>
                        <th>Default</th>
                        <th>Description</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><code>event-name</code></td>
                        <td>Lade Stack Event</td>
                        <td>Name of your event</td>
                    </tr>
                    <tr>
                        <td><code>event-date</code></td>
                        <td>-</td>
                        <td>Event date (YYYY-MM-DD)</td>
                    </tr>
                    <tr>
                        <td><code>event-time</code></td>
                        <td>-</td>
                        <td>Event time (e.g., 7:00 PM)</td>
                    </tr>
                    <tr>
                        <td><code>event-location</code></td>
                        <td>-</td>
                        <td>Venue address</td>
                    </tr>
                    <tr>
                        <td><code>max-capacity</code></td>
                        <td>50</td>
                        <td>Maximum number of RSVPs</td>
                    </tr>
                    <tr>
                        <td><code>fields</code></td>
                        <td>name,email,phone,guests,dietary</td>
                        <td>Comma-separated list of fields</td>
                    </tr>
                    <tr>
                        <td><code>deadline</code></td>
                        <td>-</td>
                        <td>RSVP deadline (YYYY-MM-DD)</td>
                    </tr>
                    <tr>
                        <td><code>approval-mode</code></td>
                        <td>false</td>
                        <td>Require admin approval</td>
                    </tr>
                    <tr>
                        <td><code>admin-password</code></td>
                        <td>admin</td>
                        <td>Password for admin dashboard</td>
                    </tr>
                    <tr>
                        <td><code>emailjs-service</code></td>
                        <td>-</td>
                        <td>EmailJS Service ID</td>
                    </tr>
                    <tr>
                        <td><code>emailjs-template</code></td>
                        <td>-</td>
                        <td>EmailJS Template ID</td>
                    </tr>
                    <tr>
                        <td><code>emailjs-key</code></td>
                        <td>-</td>
                        <td>EmailJS Public Key</td>
                    </tr>
                </tbody>
            </table>
            
            <hr style="margin: 40px 0;">
            
            <h2>🔧 Export/Import Data</h2>
            <p>Export all RSVP data from localStorage or clear widget data.</p>
            <div id="lade-admin-tools" style="background: #fff; padding: 20px;">
                <button id="lade-export-all" class="button button-primary">📥 Export All Data</button>
                <button id="lade-clear-all" class="button button-secondary">🗑️ Clear All Widget Data</button>
                <p id="lade-export-status" style="margin-top: 10px;"></p>
            </div>
        </div>
        
        <script>
        jQuery(document).ready(function($) {
            $('#lade-export-all').on('click', function() {
                var data = {};
                for (var i = 0; i < localStorage.length; i++) {
                    var key = localStorage.key(i);
                    if (key.indexOf('lade_rsvp_') === 0) {
                        data[key] = JSON.parse(localStorage.getItem(key));
                    }
                }
                var blob = new Blob([JSON.stringify(data, null, 2)], {type: 'application/json'});
                var url = URL.createObjectURL(blob);
                var a = document.createElement('a');
                a.href = url;
                a.download = 'lade-rsvp-export-' + new Date().toISOString().split('T')[0] + '.json';
                a.click();
                $('#lade-export-status').text('✅ Export completed!');
            });
            
            $('#lade-clear-all').on('click', function() {
                if (confirm('Are you sure? This will delete all RSVP data for all events!')) {
                    for (var i = 0; i < localStorage.length; i++) {
                        var key = localStorage.key(i);
                        if (key.indexOf('lade_rsvp_') === 0) {
                            localStorage.removeItem(key);
                        }
                    }
                    $('#lade-export-status').text('✅ All widget data cleared!');
                }
            });
        });
        </script>
        <?php
    }
}

// Initialize plugin
Lade_Stack_RSVP::get_instance();
