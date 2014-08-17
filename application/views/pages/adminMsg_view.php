<section class="container content-section col-md-4 col-xs-4 col-md-offset-1 col-xs-offset-1">
<?php
	adminMessageBox($admin);
?>

<?php
	if(is_array($messagePOSN) && count($messagePOSN) > 0)
		foreach($messagePOSN as $message):
			adminMessagePost($message);
		endforeach;
	else
		echo 'No administrators have posted yet.';
?>
</section>
<section class="container content-section col-md-6 col-xs-6">
<?php
	adminPublicBox($admin);
?>

<?php
	if(is_array($messageALL) && count($messageALL) > 0)
		foreach($messageALL as $message):
			adminPublicContent($message);
		endforeach;
	else
		echo 'No public content posted yet.';
?>
</section>
</div>
