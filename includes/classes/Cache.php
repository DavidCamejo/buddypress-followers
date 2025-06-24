<?php
namespace BuddyPress\Followers;

class Cache {
    const GROUP = 'bp_followers';
    const FOLLOWERS_KEY = 'followers_%d';
    const FOLLOWING_KEY = 'following_%d';
    
    public static function get_followers($user_id) {
        $key = sprintf(self::FOLLOWERS_KEY, $user_id);
        return wp_cache_get($key, self::GROUP);
    }
    
    public static function set_followers($user_id, $followers) {
        $key = sprintf(self::FOLLOWERS_KEY, $user_id);
        wp_cache_set($key, $followers, self::GROUP, HOUR_IN_SECONDS);
    }
    
    public static function delete_followers($user_id) {
        $key = sprintf(self::FOLLOWERS_KEY, $user_id);
        wp_cache_delete($key, self::GROUP);
    }
    
    public static function get_following($user_id) {
        $key = sprintf(self::FOLLOWING_KEY, $user_id);
        return wp_cache_get($key, self::GROUP);
    }
    
    public static function set_following($user_id, $following) {
        $key = sprintf(self::FOLLOWING_KEY, $user_id);
        wp_cache_set($key, $following, self::GROUP, HOUR_IN_SECONDS);
    }
    
    public static function delete_following($user_id) {
        $key = sprintf(self::FOLLOWING_KEY, $user_id);
        wp_cache_delete($key, self::GROUP);
    }
    
    public static function purge_all($user_id) {
        self::delete_followers($user_id);
        self::delete_following($user_id);
    }
}