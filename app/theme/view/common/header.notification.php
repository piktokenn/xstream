<?php 
$Notifications      = $this->db->from(null,'
            SELECT 
                notifications.*,  
                posts.title,  
                posts.type as post_type,  
                posts.self,  
                discussions.title as discussion_title,
                discussions.self as discussion_self,
                users.avatar,
                users.color,
                users.username,
                n_user.username as n_username
            FROM `notifications` 
            LEFT JOIN users ON users.id = notifications.action_user
            LEFT JOIN posts ON posts.id = notifications.action_id AND notifications.action_id IS NOT NULL AND (notifications.type = "follow" OR notifications.type = "comment")
            LEFT JOIN discussions ON discussions.id = notifications.action_id AND notifications.action_id IS NOT NULL AND (notifications.type = "discussion")
            LEFT JOIN users as n_user ON n_user.id = notifications.action_id AND notifications.action_id IS NOT NULL AND notifications.type = "follow"
            WHERE notifications.user_id ='.$AuthUser['id'].'
            ORDER BY notifications.id DESC
            LIMIT 0,8')
->all();
if(isset($Notifications)) { 
    $this->db->update('notifications')->where('user_id',$AuthUser['id'])->set(array("status" => 1));  
?>
<div class="fw-semibold fs-sm pb-2">
    <?php echo $this->translate('Notifications');?>
</div>
<div class="navbar-notifications">
<?php foreach($Notifications as $Notification) { ?>
<div class="py-2 border-bottom border-gray-200">
    <div class="row gx-3">
        <div class="col-auto">
            <?php echo gravatar($Notification['action_user'],$Notification['username'],$Notification['avatar'],'avatar rounded-circle text-white fs-xs',$Notification['color']);?>
        </div>
        <div class="col-10">
            <?php if($Notification['type'] == 'comment') { ?>
            <a href="<?php echo post($Notification['action_id'],$Notification['self'],$Notification['post_type']).'/comments';?>" class="fs-xs text-wrap">
                <span class="text-white fw-bold d-inline-block">
                    <?php echo $Notification['username'];?></span>
                <span class="text-muted fw-normal ms-1">
                    <?php echo $this->translate('replied to your comment');?></span>
            </a>
            <?php } elseif($Notification['type'] == 'discussion') { ?>
            <a href="<?php echo thread($Notification['action_id'],$Notification['discussion_self']);?>" class="fs-xs text-wrap">
                <span class="text-white fw-bold d-inline-block">
                    <?php echo $Notification['username'];?></span>
                <span class="text-muted fw-normal ms-1">
                    <?php echo $this->translate('responded to the discussion');?></span>
            </a>
            <?php } ?>
            <div class="text-muted text-cap mt-1 fs-xs fw-normal">
                <?php echo timeago($Notification['created']);?>
            </div>
        </div>
    </div>
</div>
<?php } ?>
</div>
<div class="pt-2 text-muted">
    <a href="<?php echo APP.'/dashboard/notifications';?>" class="text-current fw-normal fs-xs">
        <?php echo $this->translate('View all');?></a>
</div>
<?php } ?>
