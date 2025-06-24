<?php
class BP_Followers_Basic_Tests extends WP_UnitTestCase {
    protected $factory;
    protected $user_ids = [];
    protected $follow_data = [];
    
    public function setUp(): void {
        parent::setUp();
        
        $this->factory = new BP_UnitTest_Factory();
        
        // Create test users
        $this->user_ids = $this->factory->user->create_many(3);
        
        // Setup follow relationships
        $this->follow_data = [
            [
                'leader_id' => $this->user_ids[1],
                'follower_id' => $this->user_ids[0],
            ],
            [
                'leader_id' => $this->user_ids[2],
                'follower_id' => $this->user_ids[0],
            ]
        ];
        
        foreach ($this->follow_data as $data) {
            bp_follow_start_following($data);
        }
    }
    
    public function test_follow_relationship_created() {
        $this->assertTrue(bp_is_following([
            'leader_id' => $this->user_ids[1],
            'follower_id' => $this->user_ids[0],
        ]));
    }
    
    public function test_followers_count() {
        $this->assertEquals(
            2, 
            bp_follow_get_following_count(['user_id' => $this->user_ids[0]])
        );
    }
    
    public function test_following_count() {
        $this->assertEquals(
            1, 
            bp_follow_get_followers_count(['user_id' => $this->user_ids[1]])
        );
    }
    
    public function test_stop_following() {
        bp_follow_stop_following([
            'leader_id' => $this->user_ids[1],
            'follower_id' => $this->user_ids[0],
        ]);
        
        $this->assertFalse(bp_is_following([
            'leader_id' => $this->user_ids[1],
            'follower_id' => $this->user_ids[0],
        ]));
    }
    
    public function test_notification_created() {
        $notifications = bp_notifications_get_all_notifications_for_user($this->user_ids[1]);
        $this->assertNotEmpty($notifications);
    }
}