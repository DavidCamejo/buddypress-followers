<?php
namespace BuddyPress\Followers;

use BP_Component;

class Component extends BP_Component {
    public function __construct() {
        parent::start(
            'follow',
            __('Followers', 'buddypress-followers'),
            BP_FOLLOWERS_PLUGIN_DIR
        );
        
        $this->setup_globals();
        $this->setup_actions();
    }
    
    protected function setup_globals() {
        $bp = buddypress();
        
        $this->slug = 'follow';
        
        $this->global_tables = [
            'table_name' => $bp->table_prefix . 'bp_follow',
        ];
        
        $this->notification_callback = 'bp_follow_format_notifications';
    }
    
    protected function setup_actions() {
        add_action('bp_register_activity_actions', [$this, 'register_activity_actions']);
        add_action('bp_setup_nav', [$this, 'setup_nav'], 10);
        add_action('bp_setup_admin_bar', [$this, 'setup_admin_bar'], 80);
        
        // REST API support
        add_action('bp_rest_api_init', [$this, 'register_rest_routes']);
    }
    
    public function setup_nav() {
        $main_nav = [
            'name' => __('Following', 'buddypress-followers'),
            'slug' => 'following',
            'position' => 60,
            'screen_function' => [$this, 'screen_function'],
            'default_subnav_slug' => 'following',
            'item_css_id' => 'following'
        ];
        
        bp_core_new_nav_item($main_nav);
    }
    
    public function screen_function() {
        add_action('bp_template_content', [$this, 'template_content']);
        bp_core_load_template('members/single/plugins');
    }
    
    public function template_content() {
        bp_get_template_part('members/single/follow');
    }
    
    public function setup_admin_bar() {
        if (!is_user_logged_in()) {
            return;
        }
        
        $bp = buddypress();
        
        $bp->admin_bar_menus[] = [
            'parent' => 'my-account-buddypress',
            'id'     => 'my-account-following',
            'title'  => __('Following', 'buddypress-followers'),
            'href'   => bp_loggedin_user_domain() . 'following/'
        ];
    }
    
    public function register_rest_routes() {
        $controller = new API\Followers();
        $controller->register_routes();
    }
}