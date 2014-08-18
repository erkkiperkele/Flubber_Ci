<section class="container content-section text-center col-md-6 col-xs-6 col-md-offset-1 col-xs-offset-1">
	<div class="row">
	<?php
	if(!empty($userMessageList))
    {
        if($newConversation)
        {
            AddUserMessageContent($this->profileId, $targetId, '');
        }
        else if (array_key_exists('id'.$targetId, $userMessageList))
        {
            AddUserMessageContent($this->profileId, $targetId, $userMessageList['id'.$targetId][0]['title']);
            foreach($userMessageList['id'.$targetId] as $message):
                UserMessageBox($message);
            endforeach;
        }
        else
        {
            echo 'Please select a conversation to display.';
        }
    }
	else
    {
		echo 'You do not have any message yet.';
    }
	?>
	</div>
</section>

<section class="container content-section text-center col-md-4 col-xs-4">
    <div class="row">
        <?php
	    if(!empty($userMessageList))
        {
            echo "
            <div class='conversation panel panel-default' style='margin-left:10px'>
			    <div class='panel-heading'>Conversations</div>
			    <ul class='list-group'>";
                    foreach($userMessageList as $messageList):
                        
                        $targetId = 0;
                        $lastMsg = $messageList[0];
                        
                        if ($lastMsg['msgType'] == 'sender')
                            $targetId = $lastMsg['sentTo'];
                        else if ($lastMsg['msgType'] == 'receiver')
                            $targetId = $lastMsg['sentFrom'];
                        
                        ConversationBox($targetId, $lastMsg);
                    endforeach;
            echo "
			    </ul>
            </div>";
        }
        ?>
	</div>
</section>