

<section class="container content-section col-md-5 col-xs-5 col-md-offset-1 col-xs-offset-1">
	<div class="panel interests panel-default">
	  <div class="panel-heading text-center"><h1>Messages to Members</h1></div>
	</div>
	<?php
	AdminMessageContent($this->profileId, '');
	
	if(is_array($messagePOSN) && count($messagePOSN) > 0)
		foreach($messagePOSN as $message):
			AdminMessageBox($message);
		endforeach;
	else
		echo 'No administrators have posted yet.';
?>
</section>
<section class="container content-section col-md-5 col-xs-5">
	<div class="panel content panel-default">
	  <div class="panel-heading text-center"><h1>Public Content</h1></div>
	</div>
	<?php
	adminPublicContentBox($this->profileId);

	if(is_array($messageALL) && count($messageALL) > 0)
		foreach($messageALL as $message):
			PublicContentBox($message);
		endforeach;
	else
		echo 'No public content posted yet.';
?>

</section>
</div>
