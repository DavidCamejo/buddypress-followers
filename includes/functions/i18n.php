<?php
namespace BuddyPress\Followers;

if (!defined('ABSPATH')) {
    exit;
}

class I18n {
    public function __construct() {
        $this->setup_hooks();
    }
    
    protected function setup_hooks() {
        add_action('plugins_loaded', [$this, 'load_textdomain']);
    }
    
    public function load_textdomain() {
        load_plugin_textdomain(
            'buddypress-followers',
            false,
            dirname(plugin_basename(BP_FOLLOWERS_PLUGIN_FILE)) . '/languages/'
        );
    }
    
    public static function get_js_i18n() {
        return [
            'follow'   => __('Follow', 'buddypress-followers'),
            'unfollow' => __('Unfollow', 'buddypress-followers'),
            'error'    => __('An error occurred. Please try again.', 'buddypress-followers'),
        ];
    }
}