<?php
/**
 * Follow template
 */

defined('ABSPATH') || exit;
?>

<div class="bp-follow-container" id="bp-follow-container">
    <?php do_action('bp_before_follow_content'); ?>
    
    <nav class="bp-follow-nav">
        <ul class="item-list-tabs">
            <li class="selected" id="following">
                <a href="<?php echo esc_url(bp_displayed_user_domain() . bp_get_follow_slug()); ?>">
                    <?php 
                    printf(
                        __('Following <span>%d</span>', 'buddypress-followers'), 
                        bp_follow_get_following_count(['user_id' => bp_displayed_user_id()])
                    ); 
                    ?>
                </a>
            </li>
            <li id="followers">
                <a href="<?php echo esc_url(bp_displayed_user_domain() . bp_get_follow_slug() . '/followers/'); ?>">
                    <?php 
                    printf(
                        __('Followers <span>%d</span>', 'buddypress-followers'), 
                        bp_follow_get_followers_count(['user_id' => bp_displayed_user_id()])
                    ); 
                    ?>
                </a>
            </li>
        </ul>
    </nav>
    
    <div class="bp-follow-content">
        <?php bp_get_template_part('members/members-loop'); ?>
    </div>
    
    <?php do_action('bp_after_follow_content'); ?>
</div>