<section class="container content-section text-center col-md-4 col-xs-4 col-md-offset-1 col-xs-offset-1">
	<div class="row">
	<h3 class="page-header"><?php echo $member['firstName']; ?>&rsquo;s Family
		<small> (<?php echo count($memberRelatives); ?> total)</small>
	</h3>
    <?php
	if(is_array($memberRelatives) && count($memberRelatives) > 0)
		FriendsCarousel($memberRelatives, 'family', 4);
	else
		echo $member['firstName'].' has not added any family member yet.';
	?>
	</div>
	<div class="row">
	<h3 class="page-header"><?php echo $member['firstName']; ?>&rsquo;s Colleagues
		<small> (<?php echo count($memberColleagues); ?> total)</small>
	</h3>
    <?php
	if(is_array($memberColleagues) && count($memberColleagues) > 0)
		FriendsCarousel($memberColleagues, 'colleague', 4);
	else
		echo $member['firstName'].' has not added any colleague yet.';
	?>
	</div>
</section>
<section class="container content-section text-center col-md-6 col-xs-6">
    <div class="row">
            <h1 class="page-header"><?php echo $member['firstName']; ?>&rsquo;s Friends
				<small> (<?php echo count($memberFriends); ?> total)</small>
			</h1>
    </div>
    <?php
	if(is_array($memberFriends) && count($memberFriends) > 0)
		FriendsCarousel($memberFriends, 'friend', 8);
	else
		echo $member['firstName'].' has not added any friend yet.';
	?>
</section>