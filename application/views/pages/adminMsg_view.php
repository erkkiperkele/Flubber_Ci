

<section class="container content-section col-md-5 col-xs-5 col-md-offset-1 col-xs-offset-1">
<?php
	//adminMessageBox($this->profileId);
	
	if(is_array($messagePOSN) && count($messagePOSN) > 0)
		foreach($messagePOSN as $message):
			UserMessageBox($message);
		endforeach;
	else
		echo 'No administrators have posted yet.';
?>
</section>
<section class="container content-section col-md-5 col-xs-5">
<?php
	/*adminPublicBox($admin);
*/
	if(is_array($messageALL) && count($messageALL) > 0)
		foreach($messageALL as $message):
			PublicContentBox($message);
		endforeach;
	else
		echo 'No public content posted yet.';
?>

</section>
</div>
