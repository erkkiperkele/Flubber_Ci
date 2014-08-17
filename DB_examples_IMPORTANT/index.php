<?php

	/*****************************************************
	* This file goes through all use cases of the        *
	* DatabaseAccessObject.  This is important for       *
	* anybody using DatabaseAccessObject.                *
	*****************************************************/

	session_start();

	include "DatabaseAccessObject.php";
	//You can put whatever database information you want in here.  For now, I've put the one on the ENCS server.
	//Please note, I tested this code on my own server, so make sure the information in the constructor below is correct.
	$db = new DatabaseAccessObject('localhost', 'occ55311', 'occ55311', 'DGt4lAT');
	
	
	
echo "Delete all current members";
	echo '<br>';
	print_r($db->deleteAllMembers());
	echo '<br>';
	
	echo '<br>';
	
echo "Test add member:";
	echo '<br>';
	print_r($db->addMember('Steven', 'Miscione', 'steven.miscione@gmail.com', 'password', 'Programmer', '314A Square Saint Louis', 'Montreal', 'Canada',
	NULL, NULL, NULL, '1983-10-08', 'public'));
	echo '<br>';
	
	echo '<br>';
	
echo "Test verify login:";
	echo '<br>';
	print_r($db->verifyLogin('steven.miscione@gmail.com', 'password'));
	echo '<br>';
	echo "New memberId: " . $_SESSION['login'];
	echo '<br>';
	
	echo '<br>';
	
echo "Make first user an administrator:";
	echo '<br>';
	print_r($db->setPrivilegeOfMember($_SESSION['login'], "administrator"));
	echo '<br>';
	
	echo '<br>';
	
echo "Get user info from first user:";
	echo '<br>';
	$result = $db->getMemberInfo($_SESSION['login']);
	print_r($result);
	echo '<br>';
	
	echo '<br>';
	
echo "Check email steven.miscione@gmail.com is NOT duplicate:";
	echo '<br>';
	$result = $db->checkEmailNotDuplicate('steven.miscione@gmail.com');
	if ($result){
		echo "Result: email is NOT a duplicate";
		echo '<br>';
	}
	else{
		echo "Result: email IS a duplicate";
		echo '<br>';
	}
	
	echo '<br>';
	
echo "Check email s.miscione@gmail.com is NOT duplicate:";
	echo '<br>';
	$result = $db->checkEmailNotDuplicate('s.miscione@gmail.com');
	if ($result){
		echo "Email is NOT a duplicate";
		echo '<br>';
	}
	else{
		echo "Email IS a dupliate";
		echo '<br>';
	}
	
	echo '<br>';
	
echo "Test add another member:";
	echo '<br>';
	print_r($db->addMember('John', 'Katz', 's.miscione@gmail.com', 'password', 'Programmer', '314A Square Saint Louis', 'Montreal', 'Canada',
	NULL, NULL, NULL, '1983-10-08', 'public'));
	echo '<br>';
	
	echo '<br>';
	
echo "Change first user to administrator:";
	echo '<br>';
	print_r($db->setPrivilegeOfMember($_SESSION['login'], 'administrator'));
	echo '<br>';
	
	echo '<br>';
	
echo "Find memberId of second member (by email): ";
	echo '<br>';
	$result = $db->getMemberId('s.miscione@gmail.com');
	$secondId = $result['memberId'];
	echo "Second users Id: " . $secondId;
	echo '<br>';
	
	echo '<br>';
	
echo "Make the two users friends:";
	echo '<br>';
	print_r($db->addRelation($_SESSION['login'], $secondId, 1));
	echo '<br>';

	echo '<br>';
	
echo "Display all friends of original Member:";
	echo '<br>';
	$result = $db->getRelated($_SESSION['login'], 1);
	print_r($result);
	echo '<br>';
	
	echo '<br>';
	
echo "Display all friends of second Member:";
	echo '<br>';
	$result = $db->getRelated($secondId, 1);
	print_r($result);
	echo '<br>';
	
	echo '<br>';
	
echo "Send message from first member to second member:";
	echo '<br>';
	print_r($db->sendMessage($secondId, $_SESSION['login'], "Subject line", "Hello, it's ME."));
	echo '<br>';
	
	echo '<br>';
	
echo "Read messages of second user:";
	echo '<br>';
	print_r($db->getMessagesSentToMember($secondId));
	echo '<br>';
	
	echo '<br>';
	
echo "Read messages sent by first user:";
	echo '<br>';
	print_r($db->getMessagesSentFromMember($_SESSION['login']));
	echo '<br>';
	
	echo '<br>';
	
echo "Now, the receiver of the message (user " . $secondId . ") will 'delete' the first message sent from user " . $_SESSION['login'] . ".";
	echo '<br>';
	print_r($db->hideMessageFromReceiver($secondId, $_SESSION['login'], 1));
	echo '<br>';
	
	echo '<br>';
	
echo "Now, we will check both the receiver and sender to verify this has worked correctly.";
	echo '<br>';
	
	echo '<br>';
	
echo "Read messages of second user:";
	echo '<br>';
	print_r($db->getMessagesSentToMember($secondId));
	echo '<br>';
	
	echo '<br>';
	
echo "Read messages sent by first user:";
	echo '<br>';
	print_r($db->getMessagesSentFromMember($_SESSION['login']));
	echo '<br>';
	
	echo '<br>';
	
echo "Note that the mesage has been 'deleted' from the receiver's perspective, but not from the sender's perspective.";
	echo '<br>';
	
	echo '<br>';
	
echo "Create a group owned by first member:";
	echo '<br>';
	print_r($db->createGroup("First Group", $_SESSION['login'], "This group is for testing purposes only", NULL, NULL, NULL));
	echo '<br>';
	
	echo '<br>';
	
echo "View groups belonging to first member:";
	echo '<br>';
	print_r($db->getGroupsOfMember($_SESSION['login']));
	echo '<br>';
	
	echo '<br>';
	
echo "Get groupId of newly created group (by group Name):";
	echo '<br>';
	$result = $db->getGroupId("First Group");
	$groupId = $result['groupId'];
	echo "GroupId is: " . $groupId;
	echo '<br>';
	
	echo '<br>';
	
echo "Add second member to newly created group";
	echo '<br>';
	print_r($db->addMemberOfGroup($secondId, $groupId));
	echo '<br>';
	
	echo '<br>';
	
echo "View group belonging to second member";
	echo '<br>';
	$result = $db->getGroupsOfMember($secondId);
	print_r($result);
	echo '<br>';
	
	echo '<br>';
	
echo "First user add two contents to group:";
	echo '<br>';
	print_r($db->postGroupContent($groupId, $_SESSION['login'], 1, $_SESSION['login'], NULL, $_SESSION['login'], "text", "first content"));
	echo '<br>';
	print_r($db->postGroupContent($groupId, $_SESSION['login'], 1, $_SESSION['login'], NULL, $_SESSION['login'], "text", "second content"));
	echo '<br>';
	
	echo '<br>';
	
echo "Get group contents:";
	echo '<br>';
	print_r($db->getGroupContents($groupId));
	echo '<br>';
	
echo "Second user is going to create a new group:";
	echo '<br>';
	print_r($db->createGroup("Second Group", $secondId, "This is the second group.", NULL, NULL, NULL));
	echo '<br>';
	
	echo '<br>';
	
echo "Get groupID of newly created group (by group name):";
	echo '<br>';
	$result = $db->getGroupId("Second Group");
	$groupId2 = $result['groupId'];
	echo "GroupID is: " . $groupId2;
	echo '<br>';
	
	echo '<br>';
	
echo "First user will join second user's group:";
	echo '<br>';
	print_r($db->addMemberOfGroup($_SESSION['login'], $groupId2));
	echo '<br>';
	
	echo '<br>';
	
echo "First user will post two contents in second user's group";
	echo '<br>';
	print_r($db->postGroupContent($groupId2, $_SESSION['login'], 1, $_SESSION['login'], NULL, $_SESSION['login'], "text", "first content second group"));
	echo '<br>';
	print_r($db->postGroupContent($groupId2, $_SESSION['login'], 1, $_SESSION['login'], NULL, $_SESSION['login'], "text", "second content second group"));
	echo '<br>';
	
	echo '<br>';
	
echo "Get groups owned by first user:";
	echo '<br>';
	print_r($db->getOwnedGroups($_SESSION['login']));
	echo '<br>';
	
	echo '<br>';
	
echo "Get groups owned by second user:";
	echo '<br>';
	print_r($db->getOwnedGroups($secondId));
	echo '<br>';
	
	echo '<br>';
	
echo "Get groups that first user is a member of:";
	echo '<br>';
	print_r($db->getGroupsOfMember($_SESSION['login']));
	echo '<br>';
	
	echo '<br>';
	
echo "Get groups that second user is a member of:";
	echo '<br>';
	print_r($db->getGroupsOfMember($secondId));
	echo '<br>';
	
echo "Get members of first group:";
	echo '<br>';
	print_r($db->getMembersOfGroup($groupId));
	echo '<br>';
	
	echo '<br>';
	
echo "Get members of second group:";
	echo '<br>';
	print_r($db->getMembersOfGroup($groupId2));
	echo '<br>';
	
	echo '<br>';
	
echo "Get all group contents of second group:";
	echo '<br>';
	print_r($db->getGroupContents($groupId));
	echo '<br>';
	
	echo '<br>';
	
echo "Examine what interest types there are:";
	echo '<br>';
	print_r($db->getInterestTypes());
	echo '<br>';
	
	echo '<br>';
	
echo "Examine just the first interest type:";
	echo '<br>';
	print_r($db->getInterestTypeInfo(1));
	echo '<br>';
	
	echo '<br>';
	
echo "Add music (1st type) interest to second user:";
	echo '<br>';
	print_r($db->addInterest($secondId, 1, 'Welcome to the Jungle', 'Guns N Roses'));
	echo '<br>';
	
	echo '<br>';
	
echo "Examine just the fourth interest type:";
	echo '<br>';
	print_r($db->getInterestTypeInfo(4));
	echo '<br>';
	
	echo '<br>';
	
echo "Add painting (4th) interest to second user:";
	echo '<br>';
	print_r($db->addInterest($secondId, 4, 'Man and God', 'Michaelangelo'));
	echo '<br>';
	
	echo '<br>';
	
echo "View interests of second user";
	echo '<br>';
	print_r($db->getInterestsOfMember($secondId));
	echo '<br>';
	
	echo '<br>';
	
echo "Examine what gifts are available to give:";
	echo '<br>';
	print_r($db->getGiftTypes());
	echo '<br>';
	
	echo '<br>';
	
echo "Get info of just the first gift:";
	echo '<br>';
	$result = $db->getGiftTypeInfo(1);
	$cost = $result['cost'];
	print_r($result);
	echo '<br>';
	echo "Cost of first gift: " . $cost;
	echo '<br>';
	
	echo '<br>';
	
echo "Check if first user can afford the cost of the gift:";
	echo '<br>';
	$return = $db->checkHearts($_SESSION['login'], $cost);
	if ($return){
		echo "The user can afford it";
	}
	else{
		echo "The user cannot afford it";
	}
	echo '<br>';
	
	echo '<br>';
	
echo "Since the user can afford to give the gift, we subtract the cost from their heart count:";
	echo '<br>';
	print_r($db->updateHearts($_SESSION['login'], $cost));
	echo '<br>';
	
	echo '<br>';
	
echo "Check to see that this is done by getting user info:";
	echo '<br>';
	print_r($db->getMemberInfo($_SESSION['login']));
	echo '<br>';
	
	echo '<br>';
	
echo "Now we must formally send the gift:";
	echo '<br>';
	print_r($db->sendGift($secondId, $_SESSION['login'], 1));
	echo '<br>';
	
	echo '<br>';
	
echo "Check all gifts of second user:";
	echo '<br>';
	print_r($db->getGiftsSentToMember($secondId));
	echo '<br>';
	
	echo '<br>';
	
echo "First user will attempt to post public content:";
	echo '<br>';
	print_r($db->postPublicContent($_SESSION['login'], "text", "This is the first public content posting."));
	echo '<br>';
	
	echo '<br>';
	
echo "Display all public content:";
	echo '<br>';
	print_r($db->getPublicContents());
	echo '<br>';
	
	echo '<br>';
	
echo "Create a gift exchange in the first group:";
	echo '<br>';
	print_r($db->addGiftExchange($groupId, "First gift exchange"));
	echo '<br>';
	
	echo '<br>';
	
echo "Check that first gift exchange is in the first group";
	echo '<br>';
	$result = $db->getGiftExchangesOfGroup($groupId);
	print_r($result);
	echo '<br>';
	$giftExchangeNumber = $result[0]['giftExchangeNumber']; //Perfect example of a double-array return value
	echo "Gift exchange number of gift exchange:" . $giftExchangeNumber;
	echo '<br>';
	
	echo '<br>';
	
echo "Add first member to first gift exchange:";
	echo '<br>';
	print_r($db->addMemberOfGiftExchange($groupId, $giftExchangeNumber, $_SESSION['login']));
	echo '<br>';
	
	echo '<br>';
	
echo "Add second member to first gift exchange:";
	echo '<br>';
	print_r($db->addMemberOfGiftExchange($groupId, $giftExchangeNumber, $secondId));
	echo '<br>';
	
	echo '<br>';
	
echo "Get members of gift exchange:";
	echo '<br>';
	print_r($db->getMembersOfGiftExchange($groupId, $giftExchangeNumber));
	echo '<br>';
	
	echo '<br>';
	
echo "Find cost of gift number 2:";
	echo '<br>';
	$result = $db->getGiftTypeInfo(2);
	$cost = $result['cost'];
	echo "The cost is: " . $cost;
	echo '<br>';
	
	echo '<br>';
	
echo "Check if first user can afford cost:";
	echo '<br>';
	$result = $db->checkHearts($_SESSION['login'], $cost);
	if ($result){
		echo "User 1 can afford gift 2";
	}
	else{
		echo "User 1 cannot afford gift 2";
	}
	echo '<br>';
	
	echo '<br>';
	
echo "Update hearts to reflect that user 1 will purshcase gift 2 for gift exchange:";
	echo '<br>';
	print_r($db->updateHearts($_SESSION['login'], $cost));
	echo '<br>';
	
	echo '<br>';
	
echo "Now, we formally add 1st user's gift to add gift to gift exchange:";
	echo '<br>';
	print_r($db->addGiftToGiftExchange($groupId, $giftExchangeNumber, $_SESSION['login'], 2));
	echo '<br>';
	
	echo '<br>';
	
echo "Find cost of gift number 3:";
	echo '<br>';
	$result = $db->getGiftTypeInfo(3);
	$cost = $result['cost'];
	echo "The cost is: " . $cost;
	echo '<br>';
	
	echo '<br>';
	
echo "Check if second user can afford cost:";
	echo '<br>';
	$result = $db->checkHearts($secondId, $cost);
	if ($result){
		echo "User 2 can afford gift 3";
	}
	else{
		echo "User 2 cannot afford gift 3";
	}
	echo '<br>';
	
	echo '<br>';
	
echo "Update hearts to reflect that user 2 will purshcase gift 3 for gift exchange:";
	echo '<br>';
	print_r($db->updateHearts($secondId, $cost));
	echo '<br>';
	
	echo '<br>';
	
echo "Now, we formally add 2nd user's gift to gift exchange:";
	echo '<br>';
	print_r($db->addGiftToGiftExchange($groupId, $giftExchangeNumber, $secondId, 3));
	echo '<br>';
	
	echo '<br>';
	
echo "View gifts in gift exchange:";
	echo '<br>';
	print_r($db->getGiftsInGiftExchange($groupId, $giftExchangeNumber));
	echo '<br>';
	
	echo '<br>';
	
echo "View gift exchanges of first group:";
	echo '<br>';
	print_r($db->getGiftExchangesOfGroup($groupId));
	echo '<br>';
	
	echo '<br>';
	
echo "Get gifts exchanges of first member:";
	echo '<br>';
	print_r($db->getGiftExchangesOfMember($_SESSION['login']));
	echo '<br>';
	
	echo '<br>';
	
echo "Close gift exchange";
	echo '<br>';
	print_r($db->closeGiftExchange($groupId, $giftExchangeNumber));
	echo '<br>';
	
	echo '<br>';
	
echo "Check to see gifts given to first user:";
	echo '<br>';
	print_r($db->getGiftsSentToMember($_SESSION['login']));
	echo '<br>';
	
	echo '<br>';
	
echo "Check to see gifts given to second user:";
	echo '<br>';
	print_r($db->getGiftsSentToMember($secondId));
	echo '<br>';
	
	echo '<br>';
	
echo "Check to see that gift exchange is closed by checking open gift exchanges belonging to group 1:";
	echo '<br>';
	print_r($db->getGiftExchangesOfGroup($groupId));
	echo '<br>';
	
	echo '<br>';
	
echo "Check to see that gift exchange is closed by checked open gift exchanges belonging to first member:";
	echo '<br>';
	print_r($db->getGiftExchangesOfMember($_SESSION['login']));
	echo '<br>';
	
	echo '<br>';
	
echo "Send request from user 2 to user 1:";
	echo '<br>';
	print_r($db->sendRequest($_SESSION['login'], $secondId, "Subject line", "Upgrade status", "Please upgrade my status to senior member"));
	echo '<br>';
	
	echo '<br>';
	
echo "Examine request sent to user 1 via user 1:";
	echo '<br>';
	print_r($db->getRequestsSentToMember($_SESSION['login']));
	echo '<br>';
	
	echo '<br>';
	
echo "Examine request sent to user 1 via user 2's 'sent' folder:";
	echo '<br>';
	print_r($db->getRequestsSentFromMember($secondId));
	echo '<br>';
	
	echo '<br>';
	
echo "Respond to request by upgrading user 2 to senior member:";
	echo '<br>';
	print_r($db->setPrivilegeOfMember($secondId, "senior"));
	echo '<br>';
	
	echo '<br>';
	
echo "Change profession of second user to 'Tester' from 'Programmer':";
	echo '<br>';
	print_r($db->setProfessionOfMember($secondId, 'Tester'));
	echo '<br>';
	
	echo '<br>';
	
echo "Get user 2's info:";
	echo '<br>';
	print_r($db->getMemberInfo($secondId));
	echo '<br>';
	
	echo '<br>';
	
echo "Check if email 'a@a.com' is duplicate:";
	echo '<br>';
	$result = $db->checkEmailNotDuplicate("a@a.com");
	if ($result){
		echo "Result: email is NOT a duplicate";
	}
	else{
		echo "Result: email IS a duplicate";
	}
	echo '<br>';
	
	echo '<br>';
	
echo "Since email is not duplicate, we add a third user with this email:";
	echo '<br>';
	print_r($db->addMember('Jonathan', 'Katzman', 'a@a.com', 'password', 'Student', '314A Rue Square Saint Louis', 'Montreal', 'Canada', NULL,
	NULL, NULL, '1983-10-08', 'public'));
	echo '<br>';
	
	echo '<br>';
	
echo "Get memberId of third user:";
	echo '<br>';
	$result = $db->getMemberId('a@a.com');
	$thirdId = $result['memberId'];
	echo "Third user memberId is: " . $thirdId;
	echo '<br>';
	
	echo '<br>';
	
echo "Now, third user will block the first user:";
	echo '<br>';
	print_r($db->blockMember($thirdId, $_SESSION['login']));
	echo '<br>';
	
	echo '<br>';
	
echo "Check that third user has blocked first user:";
	echo '<br>';
	$result = $db->checkBlocked($thirdId, $_SESSION['login']);
	if ($result){
		echo "Third user has successfully blocked the first user:";
	}
	else{
		echo "Third user has unsuccessfully blocked the first user:";
	}
	echo '<br>';
	
	echo '<br>';
	
echo "List blocked members of third user:";
	echo '<br>';
	print_r($db->getBlockedMembers($thirdId));
	echo '<br>';
	
	echo '<br>';
	
echo "First user will now search for members (or groups) having 'tz' in their name:";
	echo '<br>';
	print_r($db->searchString($_SESSION['login'], 'tz'));
	echo '<br>';
	echo "Notice that only one name appears";
	echo '<br>';
	
	echo '<br>';

echo "Third user will now unblock the first member:";
	echo '<br>';
	print_r($db->unblockMember($thirdId, $_SESSION['login']));
	echo '<br>';
	
	echo '<br>';
	
echo "Check that third user has unblocked first user:";
	echo '<br>';
	$result = $db->checkBlocked($thirdId, $_SESSION['login']);
	if ($result){
		echo "Third user has unsuccessfully unblocked the first user:";
	}
	else{
		echo "Third user has successfully unblocked the first user:";
	}
	echo '<br>';
	
	echo '<br>';
	
echo "Look at blocked members of third user:";
	echo '<br>';
	print_r($db->getBlockedMembers($thirdId));
	echo '<br>';
	
	echo '<br>';
	
echo "First user will now search for members (or groups) having 'tz' in their name:";
	echo '<br>';
	print_r($db->searchString($_SESSION['login'], 'tz'));
	echo '<br>';
	echo "Notice that now two names appear, since the third user has unblocked the first user";
	echo '<br>';
	
	echo '<br>';
	
echo "First user will now search for any member of group containing the string 'o' (this should match all member names and group names, except for the searching member)";
	echo '<br>';
	$retVal = $db->searchString($_SESSION['login'], 'o');
	print_r($retVal);
	echo '<br>';
	
	echo '<br>';
	
echo "The return value of the searchString method can of course be subdivided into member values returned as well as group values returned.";
	echo '<br>';
	echo "All members returned:";
	echo '<br>';
	print_r($retVal[0]);
	echo '<br>';
	echo "All groups returned:";
	echo '<br>';
	print_r($retVal[1]);
	echo '<br>';
	
	echo '<br>';
	
	
echo "Now, we will suspend the second user, and set the third user to inactive";
echo "Be aware: this privilege requires administrator privileges!  But we will not check for the purposes of this example.";
	echo '<br>';
	print_r($db->setStatusOfMember($secondId, 'suspended'));
	echo '<br>';
	print_r($db->setStatusOfMember($thirdId, 'inactive'));
	echo '<br>';
	
	echo '<br>';
	
echo "First user will now search for any member of group containing the string 'o' (this should be the same result as before, minus the second
and third member, because they are suspended and inactive respectively)";
	echo '<br>';
	$retVal = $db->searchString($_SESSION['login'], 'o');
	echo "All members returned:";
	echo '<br>';
	print_r($retVal[0]);
	echo '<br>';
	echo "All groups returned:";
	echo '<br>';
	print_r($retVal[1]);
	echo '<br>';
	
	echo '<br>';
	
echo "Administrator privilege has the power to bypass the searchString method by retrieving all memberIds directly, which we do:";
	echo '<br>';
	print_r($db->retrieveAllMembers());
	echo '<br>';
	
	echo '<br>';
	
echo "Verify that member 2 and 3 have the correct statuses";
	echo '<br>';
	print_r($db->getMemberInfo($secondId));
	echo '<br>';
	print_r($db->getMemberInfo($thirdId));
	echo '<br>';
	
	echo '<br>';
	
echo "Now we will reset the status of the second and third member back to active";
	echo '<br>';
	print_r($db->setStatusOfMember($secondId, 'active'));
	echo '<br>';
	print_r($db->setStatusOfMember($thirdId, 'active'));
	echo '<br>';
	
	echo '<br>';
	
echo "Verify that the second and third member have the correct statuses";
	echo '<br>';
	print_r($db->getMemberInfo($secondId));
	echo '<br>';
	print_r($db->getMemberInfo($thirdId));
	echo '<br>';
	
	echo '<br>';
	
echo "First user will now search again for any member of group containing the string 'o', which should once more return all members and groups";
	echo '<br>';
	$retVal = $db->searchString($_SESSION['login'], 'o');
	echo "All members returned:";
	echo '<br>';
	print_r($retVal[0]);
	echo '<br>';
	echo "All groups returned:";
	echo '<br>';
	print_r($retVal[1]);
	echo '<br>';
	
	echo '<br>';
	
echo "First user will post wall content to their own wall with read/comment/link permission:";
	echo '<br>';
	print_r($db->postWallContent($_SESSION['login'], 3, /*currentPosterId*/$_SESSION['login'], /*previousPosterId*/NULL, /*originalPosterId*/         $_SESSION['login'], "text", "First wall post of first user"));
	echo '<br>';
	
	echo '<br>';
	
echo "Second user will post two wall content postings to their own wall with read-only permission:";
	echo '<br>';
	print_r($db->postWallContent($secondId, 1, $secondId, NULL, $secondId, "text", "First wall post of second user."));
	echo '<br>';
	print_r($db->postWallContent($secondId, 1, $secondId, NULL, $secondId, "text", "Second wall post of second user."));
	echo '<br>';
	
	echo '<br>';

echo "View wall contents of first user:";
	echo '<br>';
	print_r($db->getWallContents($_SESSION['login']));
	echo '<br>';
	
	echo '<br>';
	
echo "View wall contents of second user:";
	echo '<br>';
	print_r($db->getWallContents($secondId));
	echo '<br>';
	
	echo '<br>';
	
/*****************************************************
* What follows is the 'original' way to add comments *
* via reposting.  It should still be used in the     *
* case of reposting-with-comment, but I have devised *
* a more efficient method of commenting directly upon*
* somebody's wall without reposting.  For the 'new'  *
* method of commenting-without-reposting, please see *
* lines  of this document.                           *
******************************************************/

echo "Now, third user will repost the first (and only) post from the first user's wall to the second user's wall:";
	echo '<br>';

	echo '<br>';
	
	echo "This is a two step process.  First, we retrieve the previous wall posting:";
	echo '<br>';
	$previousPosting = $db->getWallContentInfo($_SESSION['login'], 1);
	print_r($previousPosting);
	//Note that the permissionId field here is '3', which indicates the ability to comment and link
	//It is the responsibility of the application-level program to enforce such rules.
	echo '<br>';
	
	echo '<br>';
	
echo "Now, using the information obtained, we add a comment to the content and repost to the second user's wall:";
	echo '<br>';
	$previousContent = $previousPosting['content'];
	$newContent = $previousContent . '&' . 'This is a comment on the previous post';
	//The '&' here is just a marker to divide the original content from the comment.  It will be the responsibility of the
	//application-level program to parse and render this correctly.
	print_r($db->postWallContent($secondId, 3, /*currentPosterId*/$thirdId, /*previousPosterId*/$previousPosting['currentPosterId'], /*originalPosterId*/ $previousPosting['originalPosterId'], $previousPosting['contentType'], $newContent));
	//Note that the repost must have the same (or higher) permissionId than the original post
	echo '<br>';
	
	echo '<br>';
	
echo "Second user will now view this (third) wall posting to verify is has worked correctly:";
	echo '<br>';
	print_r($db->getWallContentInfo($secondId, 3));
	echo '<br>';
	
	echo '<br>';
	
echo "Now, this second user will repost this repost to the first user's wall with another comment:";
	echo '<br>';
	$previousPosting = $db->getWallContentInfo($secondId, 3);
	$previousContent = $previousPosting['content'];
	$newContent = $previousContent . '&' . 'Look what user 3 said about you!';
	print_r($db->postWallContent($_SESSION['login'], 3, /*currentPosterId*/$secondId, /*previousPosterId*/$previousPosting['currentPosterId'], /*originalPosterId*/ $previousPosting['originalPosterId'], $previousPosting['contentType'], $newContent));
	echo '<br>';
	
	echo '<br>';
	
echo "Now, we retrieve the second posting on the first user's wall in order to verify this has worked correctly";
	echo '<br>';
	print_r($db->getWallContentInfo($_SESSION['login'], 2));
	echo '<br>';
	
	echo '<br>';
	
/********************************************
* I have devised an efficient method of     *
* commenting on a user's post in the case   *
* where there is no reposting.  It involves *
* use of the newly-created Comment table in *
* the database.  Basically, comments are now*
* treated as weak entities of wall posts.   *
*********************************************/

echo "First, we view wall contents of first user:";
	echo '<br>';
	print_r($db->getWallContents($_SESSION['login']));
	echo '<br>';
	
	echo '<br>';

echo "Next, the second user will comment on the first user's first post:";
	echo '<br>';
	print_r($db->postComment($_SESSION['login'], 1, $secondId, "I am commenting on your post"));
	echo '<br>';
	
	echo '<br>';
	
echo "Next, the third user will comment on the first user's first post:";
	echo '<br>';
	print_r($db->postComment($_SESSION['login'], 1, $thirdId, "I am commenting on your post too."));
	echo '<br>';
	
	echo '<br>';
	
echo "Now, if we view all wall contents of first member the comments DO NOT appear:";
	echo '<br>';
	print_r($db->getWallContents($_SESSION['login']));
	echo '<br>';
	
	echo '<br>';
	
echo "If we wish to view the comments of a post, we must know the wallContentNumber (as well as who's wall it is on).";
	echo '<br>';
	echo "Let us view the comments for the first user's first wall post:";
	print_r($db->getComments($_SESSION['login'], 1));
	echo '<br>';
	
	echo '<br>';

/*************************************
* End of commenting examples         *
**************************************/

echo "Now we will log out the first user:";
	echo '<br>';
	print_r($db->logout());
	echo '<br>';
	
	echo '<br>';
	
echo "Verify that the session variable has been destroyed:";
	echo '<br>';
	if (isset($_SESSION['login'])){
		echo "The session has not been destroued, and its valueis: " . $_SESSION['login'];
	}
	else{
		echo "The session variable has been destroyed";
	}
	echo '<br>';
	
	echo '<br>';

echo "Now we will log in as the second user:";
	echo '<br>';
	print_r($db->verifyLogin('s.miscione@gmail.com', 'password'));
	echo '<br>';
	echo "New value of session: " . $_SESSION['login'];
	echo '<br>';
	
	echo '<br>';
	
echo "Done the test";
	
	
	
?>