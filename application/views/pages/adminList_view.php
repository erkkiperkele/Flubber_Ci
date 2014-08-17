<section class="container content-section col-md-4 col-xs-4 col-md-offset-1 col-xs-offset-1">
<?php

	//TODO
	//foreach ($allGroupsList as $group)
	//{
		//GroupBox($group);
	//}
	
?>
</section>
<section class="container content-section col-md-6 col-xs-6">
<?php
	foreach ($memberList as $member)
	{
		MemberBox($member);
	}
	
?>
</section>
</div>
