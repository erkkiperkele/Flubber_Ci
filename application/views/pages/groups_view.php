<section class="container content-section text-center col-md-6 col-xs-6 col-md-offset-1 col-xs-offset-1">
	<div class="row">
	<?php
		echo
			"<div class='description panel panel-default'>
			<div class='panel-heading'>Description</div>
			<ul class='list-group'>
			<li class='list-group-item' id='".$this->groupId."'>
			<div id='description' class='groupEdit'>"
			.$group['description']
			."</div></li>
			</ul>
			</div>
			";
				
	?>
	</div>
	<div class="row">
	<?php
		AddGroupContentBox($this->groupId, $this->profileId);
	?>
	<?php
		if(is_array($groupPosts) && count($groupPosts) > 0)
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