<?php
namespace BuddyPress\Followers;

class Notifications {
    public function __construct() {
        $this->setup_hooks();
    }
    
    protected function setup_hooks() {
        add_action('bp_follow_start_following', [$this, 'create_notification'], 10, 2);
        add_filter('bp_notifications_get_registered_components', [$this, 'register_component']);
        add_filter('bp_notifications_get_notifications_for_user', [$this, 'format_notification'], 10, 5);
    }
    
    public function register_component($components) {
        if (!in_array('follow', $components)) {
            $components[] = 'follow';
        }
        return $components;
    }
    
    public function create_notification($leader_id, $follower_id) {
        bp_notifications_add_notification([
            'user_id'           => $leader_id,
            'item_id'          => $follower_id,
            'component_name'   => 'follow',
            'component_action' => 'new_follow',
            'date_notified'     => bp_core_current_time(),
            'is_new'            => 1,
        ]);
    }
    
    public function format_notification($action, $item_id, $secondary_item_id, $total_items, $format = 'string') {
        if ('new_follow' !== $action) {
            return $action;
        }
        
        $follower_id = $item_id;
        $follower_name = bp_core_get_user_displayname($follower_id);
        $follower_link = bp_core_get_user_domain($follower_id);
        
        if ((int) $total_items > 1) {
            $text = sprintf(
                __('%1$d users started following you', 'buddypress-followers'),
                (int) $total_items
            );
            $link = add_query_arg('type', 'new_follow', bp_get_notifications_permalink());
        } else {
            $text = sprintf(
                __('%s started following you', 'buddypress-followers'),
                $follower_name
            );
            $link = add_query_arg('type', 'new_follow', $follower_link);
        }
        
        return ($format === 'string') 
            ? '<a href="' . esc_url($link) . '">' . esc_html($text) . '</a>' 
            : [
                'text' => $text,
                'link' => $link
            ];
    }
}