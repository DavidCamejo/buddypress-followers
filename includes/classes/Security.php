<?php
namespace BuddyPress\Followers;

class Security {
    public static function sanitize_follow_data($data) {
        return [
            'leader_id'   => absint($data['leader_id']),
            'follower_id' => absint($data['follower_id']),
        ];
    }
    
    public static function validate_follow_request($leader_id, $follower_id) {
        if ($leader_id === $follower_id) {
            return new \WP_Error(
                'bp_follow_self_follow',
                __('You cannot follow yourself.', 'buddypress-followers')
            );
        }
        
        if (!get_userdata($leader_id) {
            return new \WP_Error(
                'bp_follow_invalid_leader',
                __('Invalid user to follow.', 'buddypress-followers')
            );
        }
        
        return true;
    }
    
    public static function check_nonce($action, $nonce) {
        return wp_verify_nonce($nonce, 'bp_follow_' . $action);
    }
}