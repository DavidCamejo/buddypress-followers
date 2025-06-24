<?php
namespace BuddyPress\Followers;

class Activity {
    public function __construct() {
        $this->setup_hooks();
    }
    
    protected function setup_hooks() {
        add_action('bp_register_activity_actions', [$this, 'register_activity_action']);
        add_action('bp_follow_start_following', [$this, 'record_activity'], 10, 2);
        add_action('bp_follow_stop_following', [$this, 'remove_activity'], 10, 2);
    }
    
    public function register_activity_action() {
        bp_activity_set_action(
            'follow',
            'new_follow',
            __('Started following a member', 'buddypress-followers'),
            [$this, 'format_activity_action'],
            __('Follows', 'buddypress-followers'),
            ['member']
        );
    }
    
    public function record_activity($leader_id, $follower_id) {
        $activity_id = bp_activity_add([
            'user_id'   => $follower_id,
            'item_id'   => $leader_id,
            'component' => 'follow',
            'type'      => 'new_follow',
            'action'    => $this->get_activity_action_string($follower_id, $leader_id),
            'primary_link' => bp_core_get_user_domain($leader_id),
        ]);
        
        return $activity_id;
    }
    
    public function remove_activity($leader_id, $follower_id) {
        bp_activity_delete([
            'user_id'   => $follower_id,
            'item_id'   => $leader_id,
            'component' => 'follow',
            'type'      => 'new_follow',
        ]);
    }
    
    protected function get_activity_action_string($follower_id, $leader_id) {
        return sprintf(
            __('%1$s started following %2$s', 'buddypress-followers'),
            bp_core_get_userlink($follower_id),
            bp_core_get_userlink($leader_id)
        );
    }
    
    public function format_activity_action($action, $activity) {
        return $action;
    }
}