<section class="container content-section col-md-5 col-xs-5 col-md-offset-1 col-xs-offset-1">
	<div class="panel content panel-default">
		<div class="panel-heading text-center"> <h2> Groups </h2> </div>
		</div>
	</div>
<?php
	//echo '<pre>'; print_r($allGroupsList); echo '</pre>';
	foreach ($allGroupsList as $group)
	{
		SimpleGroupBox($group);
	}
	
?>
</section>
<section class="container content-section col-md-5 col-xs-5">
	<div class="panel content panel-default">
		<div class="panel-heading text-center"> <h2> Members </h2> </div>
		</div>
	</div>

<?php
	foreach ($memberList as $member)
	{
		SimpleMemberBox($member);
	}
	
?>
</section>
</div>
