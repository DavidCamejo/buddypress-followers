<?php
namespace BuddyPress\Followers;

class Plugin {
    private static $instance;
    
    protected $components = [];
    
    public static function instance() {
        if (!isset(self::$instance)) {
            self::$instance = new self();
            self::$instance->setup();
        }
        
        return self::$instance;
    }
    
    protected function setup() {
        // Check if BuddyPress is active
        if (!function_exists('buddypress')) {
            add_action('admin_notices', [$this, 'admin_notice_missing_buddypress']);
            return;
        }
        
        $this->load_textdomain();
        $this->includes();
        $this->setup_components();
        $this->register_hooks();
    }
    
    protected function load_textdomain() {
        load_plugin_textdomain(
            'buddypress-followers',
            false,
            dirname(plugin_basename(BP_FOLLOWERS_PLUGIN_FILE)) . '/languages/'
        );
    }
    
    protected function includes() {
        require_once BP_FOLLOWERS_PLUGIN_DIR . 'includes/functions/core-functions.php';
        require_once BP_FOLLOWERS_PLUGIN_DIR . 'includes/classes/Component.php';
        require_once BP_FOLLOWERS_PLUGIN_DIR . 'includes/classes/API.php';
        require_once BP_FOLLOWERS_PLUGIN_DIR . 'includes/classes/Notifications.php';
    }
    
    protected function setup_components() {
        $this->components['core'] = new Component();
        
        if (bp_is_active('activity')) {
            $this->components['activity'] = new Activity();
        }
        
        if (bp_is_active('notifications')) {
            $this->components['notifications'] = new Notifications();
        }
    }
    
    protected function register_hooks() {
        register_activation_hook(BP_FOLLOWERS_PLUGIN_FILE, [$this, 'activate']);
        register_deactivation_hook(BP_FOLLOWERS_PLUGIN_FILE, [$this, 'deactivate']);
        
        add_action('bp_init', [$this, 'register_template_stack']);
    }
    
    public function register_template_stack() {
        bp_register_template_stack([$this, 'get_template_directory'], 10);
    }
    
    public function get_template_directory() {
        return BP_FOLLOWERS_PLUGIN_DIR . 'templates/';
    }
    
    public function activate() {
        require_once BP_FOLLOWERS_PLUGIN_DIR . 'includes/install.php';
        Install::activate();
    }
    
    public function deactivate() {
        require_once BP_FOLLOWERS_PLUGIN_DIR . 'includes/install.php';
        Install::deactivate();
    }
    
    public function admin_notice_missing_buddypress() {
        echo '<div class="error"><p>';
        printf(
            __('BuddyPress Followers requires %s to be installed and active.', 'buddypress-followers'),
            '<a href="https://buddypress.org/">BuddyPress</a>'
        );
        echo '</p></div>';
    }
}