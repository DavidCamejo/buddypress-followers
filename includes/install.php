<?php
namespace BuddyPress\Followers;

defined('ABSPATH') || exit;

class Install {
    const DB_VERSION = '2.0';
    
    public static function activate() {
        self::create_tables();
        self::update_db_version();
        self::schedule_cron();
    }
    
    public static function deactivate() {
        self::clear_cron();
    }
    
    protected static function create_tables() {
        global $wpdb;
        $bp = buddypress();
        
        $charset_collate = $wpdb->get_charset_collate();
        $table_name = $bp->table_prefix . 'bp_follow';
        
        if ($wpdb->get_var("SHOW TABLES LIKE '{$table_name}'") !== $table_name) {
            $sql = "CREATE TABLE {$table_name} (
                id bigint(20) NOT NULL AUTO_INCREMENT,
                leader_id bigint(20) NOT NULL,
                follower_id bigint(20) NOT NULL,
                date_recorded datetime NOT NULL,
                PRIMARY KEY (id),
                KEY leader_id (leader_id),
                KEY follower_id (follower_id)
            ) {$charset_collate};";
            
            require_once ABSPATH . 'wp-admin/includes/upgrade.php';
            dbDelta($sql);
        }
    }
    
    protected static function update_db_version() {
        update_site_option('bp_follow_db_version', self::DB_VERSION);
    }
    
    protected static function schedule_cron() {
        if (!wp_next_scheduled('bp_follow_cleanup')) {
            wp_schedule_event(time(), 'daily', 'bp_follow_cleanup');
        }
    }
    
    protected static function clear_cron() {
        wp_clear_scheduled_hook('bp_follow_cleanup');
    }
}