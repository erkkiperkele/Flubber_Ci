<section class="container content-section text-center col-md-6 col-xs-6 col-md-offset-1 col-xs-offset-1">
	<div class="row">
	<?php
        if($newGroup)
            GroupCreationForm($this->profileId);
        else
		    GroupDescriptionBox($this->groupId, $group);
			
	?>
	</div>
	<div class="row">
	<?php
        if(!$newGroup && $isMember)
	        AddGroupContentBox($this->groupId, $this->profileId);
	?>
	<?php
    if(!$newGroup && $isMember && is_array($groupPosts) && count($groupPosts) > 0)
		foreach ($groupPosts as $postInfo): 
			GroupContentBox($this->groupId, $postInfo);
		endforeach;
	?>
	</div>
</section>

<section class="container content-section text-center col-md-4 col-xs-4">
    <div class="row">
            <h1 class="page-header">Group Members
				<small> (<?php echo count($groupMembers); ?> total)</small>
			</h1>
    </div>
    <?php
	if(is_array($groupMembers) && count($groupMembers) > 0)
		GroupsCarousel($groupMembers, $group['ownerId'], 8);
	else
		echo 'The group "'.$group['groupName'].'" does not have any member.';
	?>
</section>
