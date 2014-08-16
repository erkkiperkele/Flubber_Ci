<section class="container content-section col-md-4 col-xs-4 col-md-offset-1 col-xs-offset-1">
<?php
	//test
	//echo "somthing";
	//echo count($memberList);
	//echo $memberList[2]['firstName'];
	//echo count($memberList[2]);
	//endtest
	//foreach($memberList as $member)
	//{
	//	echo $member['firstName'];
	//}
	
	//$num = 1;
	foreach ($memberList as $member)
	{
		//$num = $num + 1;
		//echo $num;
		MemberBox($member);
		
	}
?>
</section>
<section class="container content-section col-md-6 col-xs-6">
<?php
	
	//TODO
	//foreach ($allGroupsList as $group)
	//{
		//GroupBox($group);
	//}
?>
</section>
</div>
