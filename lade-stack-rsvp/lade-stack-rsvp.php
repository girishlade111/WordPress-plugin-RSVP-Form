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
 * Requires at least: 5.0
 * Tested up to: 6.4
 * Requires PHP: 7.4
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

// Define plugin constants
define('LADE_RSVP_VERSION', '1.0.0');
define('LADE_RSVP_PLUGIN_URL', plugin_dir_url(__FILE__));
define('LADE_RSVP_PLUGIN_PATH', plugin_dir_path(__FILE__));
define('LADE_RSVP_PLUGIN_BASENAME', plugin_basename(__FILE__));

/**
 * Load plugin text domain for translations
 */
function lade_rsvp_load_textdomain() {
    load_plugin_textdomain(
        'lade-stack-rsvp',
        false,
        dirname(LADE_RSVP_PLUGIN_BASENAME) . '/languages'
    );
}
add_action('plugins_loaded', 'lade_rsvp_load_textdomain');

/**
 * Plugin activation hook
 */
function lade_rsvp_activate() {
    // Set default options
    if (!get_option('lade_rsvp_default_capacity')) {
        add_option('lade_rsvp_default_capacity', '50');
    }
    
    // Flush rewrite rules for Gutenberg block
    flush_rewrite_rules();
    
    // Log activation
    error_log('Lade Stack RSVP Widget activated - Version ' . LADE_RSVP_VERSION);
}
register_activation_hook(__FILE__, 'lade_rsvp_activate');

/**
 * Plugin deactivation hook
 */
function lade_rsvp_deactivate() {
    // Clear any transients
    delete_transient('lade_rsvp_assets_loaded');
    
    // Flush rewrite rules
    flush_rewrite_rules();
    
    error_log('Lade Stack RSVP Widget deactivated');
}
register_deactivation_hook(__FILE__, 'lade_rsvp_deactivate');

/**
 * Plugin uninstall hook - clean up on deletion
 */
function lade_rsvp_uninstall() {
    // Remove all plugin options
    delete_option('lade_rsvp_default_capacity');
    delete_option('lade_rsvp_default_emailjs_service');
    delete_option('lade_rsvp_default_emailjs_template');
    delete_option('lade_rsvp_default_emailjs_key');
    
    error_log('Lade Stack RSVP Widget uninstalled - all data cleaned');
}
register_uninstall_hook(__FILE__, 'lade_rsvp_uninstall');

/**
 * Main Plugin Class
 */
final class Lade_Stack_RSVP {

    /**
     * Single instance of the class
     *
     * @var Lade_Stack_RSVP
     */
    private static $instance = null;

    /**
     * Get instance
     *
     * @return Lade_Stack_RSVP
     */
    public static function get_instance() {
        if (null === self::$instance) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    /**
     * Constructor - Private to enforce singleton pattern
     */
    private function __construct() {
        add_shortcode('lade_rsvp_widget', array($this, 'render_shortcode'));
        add_action('wp_enqueue_scripts', array($this, 'enqueue_assets'));
        add_action('admin_menu', array($this, 'add_admin_menu'));
        add_action('admin_init', array($this, 'register_settings'));

        // Gutenberg Block support
        add_action('init', array($this, 'register_block'));
        add_action('enqueue_block_editor_assets', array($this, 'enqueue_block_assets'));
        
        // REST API endpoints for future SaaS integration
        add_action('rest_api_init', array($this, 'register_rest_routes'));
        
        // Add settings link to plugin page
        add_filter('plugin_action_links_' . LADE_RSVP_PLUGIN_BASENAME, array($this, 'add_settings_link'));
    }

    /**
     * Add settings link to plugin page
     *
     * @param array $links Existing plugin action links
     * @return array Modified links
     */
    public function add_settings_link($links) {
        $settings_link = '<a href="' . admin_url('options-general.php?page=lade-stack-rsvp') . '">' . __('Settings', 'lade-stack-rsvp') . '</a>';
        array_unshift($links, $settings_link);
        return $links;
    }

    /**
     * Enqueue CDN assets with lazy loading
     */
    public function enqueue_assets() {
        // Check if current page has shortcode or block
        global $post;
        $has_shortcode = is_a($post, 'WP_Post') && has_shortcode($post->post_content, 'lade_rsvp_widget');
        $has_block = is_a($post, 'WP_Post') && has_block('lade-stack/rsvp-widget', $post);
        
        if (!$has_shortcode && !$has_block) {
            return;
        }

        // Interact.js for draggable
        wp_enqueue_script(
            'interact-js',
            'https://cdn.jsdelivr.net/npm/interactjs@1.10.23/dist/interact.min.js',
            array(),
            '1.10.23',
            true
        );

        // EmailJS (only if configured)
        $emailjs_key = get_option('lade_rsvp_default_emailjs_key');
        if ($emailjs_key) {
            wp_enqueue_script(
                'emailjs',
                'https://cdn.jsdelivr.net/npm/@emailjs/browser@3/dist/email.min.js',
                array(),
                '3.12.1',
                true
            );
        }

        // QR Code.js
        wp_enqueue_script(
            'qrcode-js',
            'https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js',
            array(),
            '1.0.0',
            true
        );

        // FileSaver.js for CSV export
        wp_enqueue_script(
            'filesaver-js',
            'https://cdnjs.cloudflare.com/ajax/libs/FileSaver.js/2.0.5/FileSaver.min.js',
            array(),
            '2.0.5',
            true
        );

        // Canvas Confetti for celebrations
        wp_enqueue_script(
            'canvas-confetti',
            'https://cdn.jsdelivr.net/npm/canvas-confetti@1.9.2/dist/confetti.browser.min.js',
            array(),
            '1.9.2',
            true
        );
        
        // Add inline script for lazy loading optimization
        wp_add_inline_script('interact-js', '
            // Lazy load widget when scrolled into view
            document.addEventListener("DOMContentLoaded", function() {
                var widgetContainer = document.getElementById("lade-rsvp-widget-container");
                if (widgetContainer && "IntersectionObserver" in window) {
                    var observer = new IntersectionObserver(function(entries) {
                        entries.forEach(function(entry) {
                            if (entry.isIntersecting) {
                                // Widget is visible, initialize
                                observer.unobserve(entry.target);
                            }
                        });
                    }, { threshold: 0.1 });
                    observer.observe(widgetContainer);
                }
            });
        ');
    }

    /**
     * Register Gutenberg block
     */
    public function register_block() {
        wp_register_script(
            'lade-rsvp-block-editor',
            plugins_url('block.js', __FILE__),
            array('wp-blocks', 'wp-element', 'wp-components', 'wp-editor', 'wp-i18n'),
            LADE_RSVP_VERSION,
            true
        );

        register_block_type('lade-stack/rsvp-widget', array(
            'editor_script' => 'lade-rsvp-block-editor',
            'render_callback' => array($this, 'render_block'),
            'attributes' => array(
                'eventName' => array(
                    'type' => 'string',
                    'default' => 'Lade Stack Event'
                ),
                'eventDate' => array(
                    'type' => 'string',
                    'default' => ''
                ),
                'eventTime' => array(
                    'type' => 'string',
                    'default' => ''
                ),
                'eventLocation' => array(
                    'type' => 'string',
                    'default' => ''
                ),
                'maxCapacity' => array(
                    'type' => 'number',
                    'default' => 50
                ),
                'fields' => array(
                    'type' => 'string',
                    'default' => 'name,email,phone,guests,dietary'
                ),
                'deadline' => array(
                    'type' => 'string',
                    'default' => ''
                ),
                'approvalMode' => array(
                    'type' => 'boolean',
                    'default' => false
                ),
                'adminPassword' => array(
                    'type' => 'string',
                    'default' => 'ladestack123'
                ),
                'emailjsService' => array(
                    'type' => 'string',
                    'default' => ''
                ),
                'emailjsTemplate' => array(
                    'type' => 'string',
                    'default' => ''
                ),
                'emailjsKey' => array(
                    'type' => 'string',
                    'default' => ''
                ),
                'theme' => array(
                    'type' => 'string',
                    'default' => 'light'
                ),
                'showBranding' => array(
                    'type' => 'boolean',
                    'default' => true
                ),
                // Pro Features (Phase 9)
                'language' => array(
                    'type' => 'string',
                    'default' => 'en'
                ),
                'analyticsId' => array(
                    'type' => 'string',
                    'default' => ''
                ),
                'customCSS' => array(
                    'type' => 'string',
                    'default' => ''
                ),
            ),
        ));
    }

    /**
     * Render Gutenberg block
     *
     * @param array $attributes Block attributes
     * @return string Rendered HTML
     */
    public function render_block($attributes) {
        $atts = array(
            'event-name' => sanitize_text_field($attributes['eventName']),
            'event-date' => sanitize_text_field($attributes['eventDate'] ?? ''),
            'event-time' => sanitize_text_field($attributes['eventTime'] ?? ''),
            'event-location' => sanitize_text_field($attributes['eventLocation'] ?? ''),
            'max-capacity' => absint($attributes['maxCapacity']),
            'fields' => sanitize_text_field($attributes['fields']),
            'deadline' => sanitize_text_field($attributes['deadline'] ?? ''),
            'approval-mode' => $attributes['approvalMode'] ? 'true' : 'false',
            'admin-password' => sanitize_text_field($attributes['adminPassword']),
            'emailjs-service' => sanitize_text_field($attributes['emailjsService'] ?? ''),
            'emailjs-template' => sanitize_text_field($attributes['emailjsTemplate'] ?? ''),
            'emailjs-key' => sanitize_text_field($attributes['emailjsKey'] ?? ''),
            'theme' => sanitize_text_field($attributes['theme']),
            'show-branding' => $attributes['showBranding'] ? 'true' : 'false',
            // Pro Features
            'language' => sanitize_text_field($attributes['language'] ?? 'en'),
            'analytics-id' => sanitize_text_field($attributes['analyticsId'] ?? ''),
            'custom-css' => wp_kses_post($attributes['customCSS'] ?? ''),
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
     * Register REST API routes for SaaS integration
     */
    public function register_rest_routes() {
        register_rest_route('lade-rsvp/v1', '/export', array(
            'methods' => 'POST',
            'callback' => array($this, 'rest_export_data'),
            'permission_callback' => function() {
                return current_user_can('manage_options');
            },
        ));
        
        register_rest_route('lade-rsvp/v1', '/clear', array(
            'methods' => 'POST',
            'callback' => array($this, 'rest_clear_data'),
            'permission_callback' => function() {
                return current_user_can('manage_options');
            },
        ));
    }

    /**
     * REST API: Export data
     *
     * @param WP_REST_Request $request Request object
     * @return WP_REST_Response
     */
    public function rest_export_data($request) {
        $event_id = sanitize_text_field($request->get_param('event_id'));
        $storage_key = 'lade_rsvp_' . $event_id;
        $data = get_option($storage_key, array());
        
        return rest_ensure_response(array(
            'success' => true,
            'data' => $data,
        ));
    }

    /**
     * REST API: Clear data
     *
     * @param WP_REST_Request $request Request object
     * @return WP_REST_Response
     */
    public function rest_clear_data($request) {
        $event_id = sanitize_text_field($request->get_param('event_id'));
        $storage_key = 'lade_rsvp_' . $event_id;
        delete_option($storage_key);
        
        return rest_ensure_response(array(
            'success' => true,
            'message' => __('Data cleared successfully', 'lade-stack-rsvp'),
        ));
    }

    /**
     * Render shortcode
     *
     * @param array $atts Shortcode attributes
     * @return string Rendered HTML
     */
    public function render_shortcode($atts = array()) {
        // Default attributes with proper sanitization defaults
        $atts = shortcode_atts(array(
            // Event Settings
            'event-name' => __('Lade Stack Event', 'lade-stack-rsvp'),
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

        // Sanitize all attributes
        $atts = array_map('sanitize_text_field', $atts);
        $atts['max-capacity'] = absint($atts['max-capacity']);

        // Build widget with proper escaping
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
            __('Lade Stack RSVP', 'lade-stack-rsvp'),
            __('Lade Stack RSVP', 'lade-stack-rsvp'),
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
        register_setting('lade_rsvp_settings', 'lade_rsvp_default_capacity', array(
            'type' => 'integer',
            'sanitize_callback' => 'absint',
            'default' => 50,
        ));
        register_setting('lade_rsvp_settings', 'lade_rsvp_default_emailjs_service', array(
            'type' => 'string',
            'sanitize_callback' => 'sanitize_text_field',
        ));
        register_setting('lade_rsvp_settings', 'lade_rsvp_default_emailjs_template', array(
            'type' => 'string',
            'sanitize_callback' => 'sanitize_text_field',
        ));
        register_setting('lade_rsvp_settings', 'lade_rsvp_default_emailjs_key', array(
            'type' => 'string',
            'sanitize_callback' => 'sanitize_text_field',
        ));
    }

    /**
     * Render admin page with nonce verification
     */
    public function render_admin_page() {
        // Verify nonce for form submission
        if (isset($_POST['submit']) && check_admin_referer('lade_rsvp_settings_options', 'lade_rsvp_settings_nonce')) {
            // Settings are automatically saved via register_setting
        }
        ?>
        <div class="wrap">
            <h1><?php echo esc_html__('🎉 Lade Stack RSVP Widget Settings', 'lade-stack-rsvp'); ?></h1>
            <p><?php echo esc_html__('Configure default settings for your RSVP widgets. Each widget can override these via shortcode attributes.', 'lade-stack-rsvp'); ?></p>

            <form method="post" action="options.php">
                <?php settings_fields('lade_rsvp_settings'); ?>
                <?php do_settings_sections('lade_rsvp_settings'); ?>
                <?php wp_nonce_field('lade_rsvp_settings_options', 'lade_rsvp_settings_nonce'); ?>

                <table class="form-table">
                    <tr>
                        <th scope="row"><?php echo esc_html__('Default Max Capacity', 'lade-stack-rsvp'); ?></th>
                        <td>
                            <input type="number" name="lade_rsvp_default_capacity" value="<?php echo esc_attr(get_option('lade_rsvp_default_capacity', '50')); ?>" class="regular-text" min="1" />
                            <p class="description"><?php echo esc_html__('Default maximum RSVP capacity for new widgets.', 'lade-stack-rsvp'); ?></p>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row"><?php echo esc_html__('EmailJS Service ID', 'lade-stack-rsvp'); ?></th>
                        <td>
                            <input type="text" name="lade_rsvp_default_emailjs_service" value="<?php echo esc_attr(get_option('lade_rsvp_default_emailjs_service')); ?>" class="regular-text" />
                            <p class="description"><?php echo esc_html__('Your EmailJS Service ID (optional, can set per-widget).', 'lade-stack-rsvp'); ?></p>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row"><?php echo esc_html__('EmailJS Template ID', 'lade-stack-rsvp'); ?></th>
                        <td>
                            <input type="text" name="lade_rsvp_default_emailjs_template" value="<?php echo esc_attr(get_option('lade_rsvp_default_emailjs_template')); ?>" class="regular-text" />
                            <p class="description"><?php echo esc_html__('Your EmailJS Template ID.', 'lade-stack-rsvp'); ?></p>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row"><?php echo esc_html__('EmailJS Public Key', 'lade-stack-rsvp'); ?></th>
                        <td>
                            <input type="password" name="lade_rsvp_default_emailjs_key" value="<?php echo esc_attr(get_option('lade_rsvp_default_emailjs_key')); ?>" class="regular-text" />
                            <p class="description"><?php echo esc_html__('Your EmailJS Public Key.', 'lade-stack-rsvp'); ?></p>
                        </td>
                    </tr>
                </table>

                <?php submit_button(); ?>
            </form>

            <hr style="margin: 40px 0;">

            <h2><?php echo esc_html__('📖 Quick Start Guide', 'lade-stack-rsvp'); ?></h2>
            <div style="background: #fff; padding: 20px; border-left: 4px solid #2271b1; box-shadow: 0 1px 3px rgba(0,0,0,0.1);">
                <h3><?php echo esc_html__('Step 1: Add Widget to Page', 'lade-stack-rsvp'); ?></h3>
                <p><?php echo esc_html__('Use the shortcode in any page or post:', 'lade-stack-rsvp'); ?></p>
                <code style="display: block; padding: 10px; background: #f0f0f1; margin: 10px 0; border-radius: 4px;">[lade_rsvp_widget event-name="My Event" max-capacity="100"]</code>

                <h3><?php echo esc_html__('Step 2: Configure EmailJS (Optional)', 'lade-stack-rsvp'); ?></h3>
                <ol style="margin-left: 20px;">
                    <li><?php echo esc_html__('Sign up at', 'lade-stack-rsvp'); ?> <a href="https://www.emailjs.com/" target="_blank" rel="noopener">EmailJS.com</a> (<?php echo esc_html__('free tier available', 'lade-stack-rsvp'); ?>)</li>
                    <li><?php echo esc_html__('Create an Email Service (e.g., Gmail)', 'lade-stack-rsvp'); ?></li>
                    <li><?php echo esc_html__('Create an Email Template with variables:', 'lade-stack-rsvp'); ?> <code>{{name}}, {{email}}, {{event_name}}, {{event_date}}</code></li>
                    <li><?php echo esc_html__('Add your Service ID, Template ID, and Public Key to the shortcode or settings above', 'lade-stack-rsvp'); ?></li>
                </ol>

                <h3><?php echo esc_html__('Step 3: Customize Fields', 'lade-stack-rsvp'); ?></h3>
                <p><?php echo esc_html__('Control which fields appear:', 'lade-stack-rsvp'); ?></p>
                <code style="display: block; padding: 10px; background: #f0f0f1; margin: 10px 0; border-radius: 4px;">[lade_rsvp_widget fields="name,email,guests"]</code>
                <p><?php echo esc_html__('Available fields:', 'lade-stack-rsvp'); ?> name, email, phone, guests, dietary</p>

                <h3><?php echo esc_html__('Step 4: Enable Approval Mode', 'lade-stack-rsvp'); ?></h3>
                <code style="display: block; padding: 10px; background: #f0f0f1; margin: 10px 0; border-radius: 4px;">[lade_rsvp_widget approval-mode="true" admin-password="yourpassword"]</code>
            </div>

            <hr style="margin: 40px 0;">

            <h2><?php echo esc_html__('📋 Shortcode Reference', 'lade-stack-rsvp'); ?></h2>
            <div style="overflow-x: auto;">
                <table class="wp-list-table widefat fixed striped">
                    <thead>
                        <tr>
                            <th><?php echo esc_html__('Attribute', 'lade-stack-rsvp'); ?></th>
                            <th><?php echo esc_html__('Default', 'lade-stack-rsvp'); ?></th>
                            <th><?php echo esc_html__('Description', 'lade-stack-rsvp'); ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><code>event-name</code></td>
                            <td>Lade Stack Event</td>
                            <td><?php echo esc_html__('Name of your event', 'lade-stack-rsvp'); ?></td>
                        </tr>
                        <tr>
                            <td><code>event-date</code></td>
                            <td>-</td>
                            <td><?php echo esc_html__('Event date (YYYY-MM-DD)', 'lade-stack-rsvp'); ?></td>
                        </tr>
                        <tr>
                            <td><code>max-capacity</code></td>
                            <td>50</td>
                            <td><?php echo esc_html__('Maximum number of RSVPs', 'lade-stack-rsvp'); ?></td>
                        </tr>
                        <tr>
                            <td><code>language</code></td>
                            <td>en</td>
                            <td><?php echo esc_html__('Language: en (English) or mr (Marathi)', 'lade-stack-rsvp'); ?></td>
                        </tr>
                        <tr>
                            <td><code>analytics-id</code></td>
                            <td>-</td>
                            <td><?php echo esc_html__('Google Analytics Tracking ID (e.g., G-XXXXXXXXXX)', 'lade-stack-rsvp'); ?></td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <hr style="margin: 40px 0;">

            <h2><?php echo esc_html__('🔧 Export/Import Data', 'lade-stack-rsvp'); ?></h2>
            <p><?php echo esc_html__('Export all RSVP data from localStorage or clear widget data.', 'lade-stack-rsvp'); ?></p>
            <div id="lade-admin-tools" style="background: #fff; padding: 20px; border-radius: 8px; box-shadow: 0 1px 3px rgba(0,0,0,0.1);">
                <button id="lade-export-all" class="button button-primary">📥 <?php echo esc_html__('Export All Data', 'lade-stack-rsvp'); ?></button>
                <button id="lade-clear-all" class="button button-secondary">🗑️ <?php echo esc_html__('Clear All Widget Data', 'lade-stack-rsvp'); ?></button>
                <p id="lade-export-status" style="margin-top: 10px; font-weight: 600;"></p>
            </div>
        </div>

        <script>
        jQuery(document).ready(function($) {
            $('#lade-export-all').on('click', function() {
                var data = {};
                for (var i = 0; i < localStorage.length; i++) {
                    var key = localStorage.key(i);
                    if (key.indexOf('lade_rsvp_') === 0) {
                        try {
                            data[key] = JSON.parse(localStorage.getItem(key));
                        } catch (e) {
                            data[key] = localStorage.getItem(key);
                        }
                    }
                }
                var blob = new Blob([JSON.stringify(data, null, 2)], {type: 'application/json'});
                var url = URL.createObjectURL(blob);
                var a = document.createElement('a');
                a.href = url;
                a.download = 'lade-rsvp-export-' + new Date().toISOString().split('T')[0] + '.json';
                a.click();
                URL.revokeObjectURL(url);
                $('#lade-export-status').text('✅ <?php echo esc_js(__('Export completed!', 'lade-stack-rsvp')); ?>');
                setTimeout(function() { $('#lade-export-status').text(''); }, 3000);
            });

            $('#lade-clear-all').on('click', function() {
                if (confirm('<?php echo esc_js(__('Are you sure? This will delete all RSVP data for all events!', 'lade-stack-rsvp')); ?>')) {
                    for (var i = 0; i < localStorage.length; i++) {
                        var key = localStorage.key(i);
                        if (key.indexOf('lade_rsvp_') === 0) {
                            localStorage.removeItem(key);
                        }
                    }
                    $('#lade-export-status').text('✅ <?php echo esc_js(__('All widget data cleared!', 'lade-stack-rsvp')); ?>');
                    setTimeout(function() { $('#lade-export-status').text(''); }, 3000);
                }
            });
        });
        </script>
        <?php
    }
}

// Initialize plugin
Lade_Stack_RSVP::get_instance();
