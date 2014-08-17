<section class="container content-section text-center col-md-6 col-xs-6 col-md-offset-1 col-xs-offset-1">
	<div class="row">
	<?php
    AddUserMessageContent(1, 2, 'RE: Hey');
	if(is_array($userMessageList) && count($userMessageList) > 0)
		foreach($userMessageList as $userMessage):
			UserMessageBox($userMessage);
		endforeach;
	else
		echo 'You do not have any message yet.';
	?>
	</div>
</section>