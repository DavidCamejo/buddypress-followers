<?php
/**
 * Core functions for BuddyPress Followers
 */

use BuddyPress\Followers\Plugin;

if (!function_exists('bp_follow_start_following')) {
    function bp_follow_start_following($args = []) {
        $r = wp_parse_args($args, [
            'leader_id'   => 0,
            'follower_id' => bp_loggedin_user_id(),
        ]);
        
        if (!$r['leader_id'] || !$r['follower_id']) {
            return false;
        }
        
        // Check if already following
        if (bp_is_following($args)) {
            return true;
        }
        
        global $wpdb;
        $bp = buddypress();
        
        $result = $wpdb->insert(
            $bp->follow->table_name,
            [
                'leader_id'   => $r['leader_id'],
                'follower_id' => $r['follower_id'],
                'date_recorded' => current_time('mysql'),
            ],
            ['%d', '%d', '%s']
        );
        
        if (!$result) {
            return false;
        }
        
        // Clear cache
        wp_cache_delete($r['follower_id'], 'bp_followers');
        wp_cache_delete($r['leader_id'], 'bp_following');
        
        // Trigger action
        do_action('bp_follow_start_following', $r['leader_id'], $r['follower_id']);
        
        return true;
    }
}

if (!function_exists('bp_follow_stop_following')) {
    function bp_follow_stop_following($args = []) {
        $r = wp_parse_args($args, [
            'leader_id'   => 0,
            'follower_id' => bp_loggedin_user_id(),
        ]);
        
        if (!$r['leader_id'] || !$r['follower_id']) {
            return false;
        }
        
        // Check if not following
        if (!bp_is_following($args)) {
            return true;
        }
        
        global $wpdb;
        $bp = buddypress();
        
        $result = $wpdb->delete(
            $bp->follow->table_name,
            [
                'leader_id'   => $r['leader_id'],
                'follower_id' => $r['follower_id'],
            ],
            ['%d', '%d']
        );
        
        if (!$result) {
            return false;
        }
        
        // Clear cache
        wp_cache_delete($r['follower_id'], 'bp_followers');
        wp_cache_delete($r['leader_id'], 'bp_following');
        
        // Trigger action
        do_action('bp_follow_stop_following', $r['leader_id'], $r['follower_id']);
        
        return true;
    }
}

// ... otras funciones esenciales