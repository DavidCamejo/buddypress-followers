<?php
class BP_Followers_Integration_Tests extends BP_UnitTestCase {
    public function test_component_is_registered() {
        $bp = buddypress();
        $this->assertTrue(isset($bp->follow));
    }
    
    public function test_navigation_item_added() {
        $this->set_current_user($this->factory->user->create());
        
        $this->go_to(bp_loggedin_user_domain());
        
        $nav = buddypress()->members->nav->get_primary();
        $this->assertArrayHasKey('following', $nav);
    }
    
    public function test_activity_action_registered() {
        $actions = bp_activity_get_actions();
        $this->assertArrayHasKey('follow', $actions);
    }
    
    public function test_notification_component_registered() {
        $components = bp_notifications_get_registered_components();
        $this->assertContains('follow', $components);
    }
}