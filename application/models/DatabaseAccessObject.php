<?php

	error_reporting(E_ALL);
	ini_set('display_errors', '1');

	/****************************************************************
	* This class encapsulates access to the project database.  It   *
	* provides an extensive interface to insert, update, delete     *
	* and query the various members and content items in a way that *
	* is consistent with the use cases described in the project     *
	* documentation.                                                *
	****************************************************************/
	
    
	class DatabaseAccessObject{
		private $db;
		
		/**************** CONSTRUCTORS ****************/
		
		// Constructor which establishes a connection based on user provided values
		public function __construct($mysql_host, $mysql_database, $mysql_username, $mysql_password){
			$this->db = new PDO('mysql:host=' . $mysql_host . ';dbname=' . $mysql_database . ';charset=utf8', $mysql_username, $mysql_password);
		}
		
		/********** DATABASE ACCESS FUNCTIONS *********/
		
		//MEMBER Table
			
			public function retrieveAllMembers(){
				try{
					$statement = $this->db->prepare('SELECT memberId FROM Member;');
					$statement->execute();
					if ($statement->rowCount() > 0){
						return $statement->fetchAll();
					}
					else{
						return false;
					}
				}
				catch (PDOException $ex){
					echo 'MySQL has generated an error: ' . $ex->getMessage() . '<br>';
					return null;
				}
			}
			
			public function deleteAllMembers(){
				try{
					$statement = $this->db->prepare('DELETE FROM Member;');
					$statement->execute();
					if ($statement->rowCount() > 0){
						return true;
					}
					else{
						return false;
					}
				}
				catch (PDOException $ex){
					echo 'MySQL has generated an error: ' . $ex->getMessage() . '<br>';
					return null;
				}
			}
		
			public function checkEmailNotDuplicate($email){
				try{
					$statement = $this->db->prepare('SELECT * FROM Member WHERE email = :email');
					$statement->bindValue(':email', $email, PDO::PARAM_STR);
					$statement->execute();
					if ($statement->rowCount() == 0){
						return true;
					}
					else{
						return false;
					}
				}
				catch (PDOException $ex){
					echo 'MySQL has generated an error: ' . $ex->getMessage() . '<br>';
					return null;
				}
			}
			
			/********************************************************
			* Verifies whether the email, password combination      *
			* is valid.  If so, it returns true and logs the user   *
			* in by setting $_SESSION['login'] equal to their       *
			* memberId.  If not, it returns false.  In the case of  *
			* an error, it returns null.                            *
			********************************************************/
			public function verifyLogin($email, $password){
				try{
					$statement = $this->db->prepare('SELECT memberId, hashedPassword, status FROM Member WHERE email = :email;');
					$statement->bindValue(':email', $email, PDO::PARAM_STR);
					$statement->execute();
					if ($statement->rowCount() > 0){
						$row = $statement->fetch(PDO::FETCH_ASSOC);
						if ( ( crypt($password, '$5$abcdefghijkl1234') == $row['hashedPassword'] ) && ( $row['status'] != "suspended" ) ){
							$_SESSION['login'] = $row['memberId'];
							return true;
						}
						else{
							return false;
						}
					}
					else{
						return false;
					}
				}
				catch (PDOException $ex){
					echo 'MySQL has generated an error: ' . $ex->getMessage() . '<br>';
					return null;
				}
			}
			
			public function logOut(){
				if (isset($_SESSION['login'])){
					unset($_SESSION['login']);
					return true;
				}
				else{
					return false;
				}
			}
		
			public function addMember($firstName,$lastName,$email,$password,$profession,$address,$city,$country,$photographURL,$coverPictureURL,$thumbnailURL,$dateOfBirth,$privacy){
				try{
					$hashedPassword = crypt($password, '$5$abcdefghijkl1234');
					$defaultPrivilege = 3; //1=admin, 2=senior, 3=junior
					$defaultStatus = "active";
					$statement = $this->db->prepare('INSERT INTO Member(firstName,lastName,email,hashedPassword,profession,address,city,country,photographURL,coverPictureURL,thumbnailURL,hearts,
					dateOfBirth,privacy,privilege,status)
					VALUES(:firstName, :lastName, :email, :hashedPassword, :profession, :address, :city, :country, :photographURL, :coverPictureURL, 
					:thumbnailURL, :hearts, :dateOfBirth, :privacy, :defaultPrivilege, :defaultStatus);');
					$statement->bindValue(':firstName', $firstName, PDO::PARAM_STR);
					$statement->bindValue(':lastName', $lastName, PDO::PARAM_STR);
					$statement->bindValue(':email', $email, PDO::PARAM_STR);
					$statement->bindValue(':hashedPassword', $hashedPassword, PDO::PARAM_STR);
					$statement->bindValue(':profession', $profession, PDO::PARAM_STR);
					$statement->bindValue(':address', $address, PDO::PARAM_STR);
					$statement->bindValue(':city', $city, PDO::PARAM_STR);
					$statement->bindValue(':country', $country, PDO::PARAM_STR);
					$statement->bindValue(':photographURL', $photographURL, PDO::PARAM_STR);
					$statement->bindValue(':coverPictureURL', $coverPictureURL, PDO::PARAM_STR);
					$statement->bindValue(':thumbnailURL', $thumbnailURL, PDO::PARAM_STR);
					$statement->bindValue(':hearts', 100, PDO::PARAM_INT);
					$statement->bindValue(':dateOfBirth', $dateOfBirth, PDO::PARAM_STR);
					$statement->bindValue(':privacy', $privacy, PDO::PARAM_STR);
					$statement->bindValue(':defaultPrivilege', $defaultPrivilege, PDO::PARAM_STR);
					$statement->bindValue(':defaultStatus', $defaultStatus, PDO::PARAM_STR);
					$statement->execute();
					if ($statement->rowCount() > 0){
						return true;
					}
					else{
						return false;
					}
				}
				catch (PDOException $ex){
					echo 'MySQL has generated an error: ' . $ex->getMessage() . '<br>';
					return null;
				}
			}
			
			public function removeMember($memberId){
				try{
					$statement = $this->db->prepare('DELETE FROM Member WHERE memberId = :memberId;');
					$statement->bindValue(':memberId', $memberId, PDO::PARAM_INT);
					$statement->execute();
					if ($statement->rowCount() > 0){
						return true;
					}
					else{
						return false;
					}
				}
				catch (PDOException $ex){
					echo 'MySQL has generated an error: ' . $ex->getMessage() . '<br>';
					return null;
				}
			}
			
			public function getMemberInfo($memberId){
				try{
					$statement = $this->db->prepare('SELECT memberId, firstName, lastName, email, profession, address, city, country, photographURL, coverPictureURL, thumbnailURL, hearts, dateOfBirth, privacy, privilege, status FROM Member WHERE memberId = :memberId;');
					$statement->bindValue(':memberId', $memberId, PDO::PARAM_STR);
					$statement->execute();
					if ($statement->rowCount() > 0){
						return $statement->fetch(PDO::FETCH_ASSOC);
					}
					else{
						return null;
					}
				}
				catch (PDOException $ex){
					echo 'MySQL has generated an error: ' . $ex->getMessage() . '<br>';
					return null;
				}
			}
			
			public function getMemberId($email){
				try{
					$statement = $this->db->prepare('SELECT memberId FROM Member WHERE email = :email;');
					$statement->bindValue(':email', $email, PDO::PARAM_STR);
					$statement->execute();
					if ($statement->rowCount() > 0){
						return $statement->fetch(PDO::FETCH_ASSOC);
					}
					else{
						return null;
					}
				}
				catch (PDOException $ex){
					echo 'MySQL has generated an error: ' . $ex->getMessage() . '<br>';
					return null;
				}
			}
			
			public function setPasswordOfMember($memberId, $newPassword){
				try{
					$newHashedPassword = crypt($newPassword, '$5$abcdefghijkl1234');
					$statement = $this->db->prepare('UPDATE Member SET hashedPassword = :newHashedPassword WHERE memberId = :memberId;');
					$statement->bindValue(':newHashedPassword', $newHashedPassword, PDO::PARAM_STR);
					$statement->bindValue(':memberId', $memberId, PDO::PARAM_STR);
					$statement->execute();
					if ($statement->rowCount() > 0){
						return true;
					}
					else{
						return false;
					}
				}
				catch (PDOException $ex){
					echo 'MySQL has generated an error: ' . $ex->getMessage() . '<br>';
					return null;
				}
			}
			
			public function setAddressOfMember($memberId, $newAddress, $newCity, $newCountry){
				try{
					$statement = $this->db->prepare('UPDATE Member SET address = :newAddress, city = :newCity, country = :newCountry WHERE memberId = :memberId;');
					$statement->bindValue(':newAddress', $newAddress, PDO::PARAM_STR);
					$statement->bindValue(':newCity', $newCity, PDO::PARAM_STR);
					$statement->bindValue(':newCountry', $newCountry, PDO::PARAM_STR);
					$statement->bindValue(':memberId', $memberId, PDO::PARAM_INT);
					$statement->execute();
					if ($statement->rowCount() > 0){
						return true;
					}
					else{
						return false;
					}
				}
				catch (PDOException $ex){
					echo 'MySQL has generated an error: ' . $ex->getMessage() . '<br>';
					return null;
				}
			}
			
			public function setProfessionOfMember($memberId, $newProfession){
				try{
					$statement = $this->db->prepare('UPDATE Member SET profession = :newProfession WHERE memberId = :memberId;');
					$statement->bindValue(':newProfession', $newProfession, PDO::PARAM_STR);
					$statement->bindValue(':memberId', $memberId, PDO::PARAM_INT);
					$statement->execute();
					if ($statement->rowCount() > 0){
						return true;
					}
					else{
						return false;
					}
				}
				catch (PDOException $ex){
					echo 'MySQL has generated an error: ' . $ex->getMessage() . '<br>';
					return null;
				}
			}
			
			public function setPrivacyOfMember($memberId, $newPrivacy){
				try{
					$statement = $this->db->prepare('UPDATE Member SET privacy = :newPrivacy WHERE memberId = :memberId;');
					$statement->bindValue(':newPrivacy', $newPrivacy, PDO::PARAM_STR);
					$statement->bindValue(':memberId', $memberId, PDO::PARAM_INT);
					$statement->execute();
					if ($statement->rowCount() > 0){
						return true;
					}
					else{
						return false;
					}
				}
				catch (PDOException $ex){
					echo 'MySQL has generated an error: ' . $ex->getMessage() . '<br>';
					return null;
				}
			}
			
			public function setPrivilegeOfMember($memberId, $newPrivilege){
				try{
					$statement = $this->db->prepare('UPDATE Member SET privilege = :newPrivilege WHERE memberId = :memberId;');
					$statement->bindValue(':newPrivilege', $newPrivilege, PDO::PARAM_STR);
					$statement->bindValue(':memberId', $memberId, PDO::PARAM_INT);
					$statement->execute();
					if ($statement->rowCount() > 0){
						return true;
					}
					else{
						return false;
					}
				}
				catch (PDOException $ex){
					echo 'MySQL has generated an error: ' . $ex->getMessage() . '<br>';
					return null;
				}
			}
			
			public function setStatusOfMember($memberId, $newStatus){
				try{
					$statement = $this->db->prepare('UPDATE Member SET status = :newStatus WHERE memberId = :memberId;');
					$statement->bindValue(':newStatus', $newStatus, PDO::PARAM_STR);
					$statement->bindValue(':memberId', $memberId, PDO::PARAM_INT);
					$statement->execute();
					if ($statement->rowCount() > 0){
						return true;
					}
					else{
						return false;
					}
				}
				catch (PDOException $ex){
					echo 'MySQL has generated an error: ' . $ex->getMessage() . '<br>';
					return null;
				}
			}
			
			public function setEmailOfMember($memberId, $newEmail){
				try{
					if ($this->checkEmailNotDuplicate($newEmail)){
						$statement = $this->db->prepare('UPDATE Member SET email = :newEmail WHERE memberId = :memberId;');
						$statement->bindValue(':newEmail', $newEmail, PDO::PARAM_STR);
						$statement->bindValue(':memberId', $memberId, PDO::PARAM_INT);
						$statement->execute();
						if ($statement->rowCount() > 0){
							return true;
						}
						else{
							return false;
						}
					}
					else{
						return false;
					}
				}
				catch (PDOException $ex){
					echo 'MySQL has generated an error: ' . $ex->getMessage() . '<br>';
					return null;
				}
			}
			
			public function setPhotographURLOfMember($memberId, $newPhotographURL){
				try{
					$statement = $this->db->prepare('UPDATE Member SET photographURL = :newPhotographURL WHERE memberId = :memberId;');
					$statement->bindValue(':newPhotographURL', $newPhotographURL, PDO::PARAM_STR);
					$statement->bindValue(':memberId', $memberId, PDO::PARAM_INT);
					$statement->execute();
					if ($statement->rowCount() > 0){
						return true;
					}
					else{
						return false;
					}
				}
				catch (PDOException $ex){
					echo 'MySQL has generated an error: ' . $ex->getMessage() . '<br>';
					return null;
				}
			}
			
			public function setCoverPictureURLOfMember($memberId, $newCoverPictureURL){
				try{
					$statement = $this->db->prepare('UPDATE Member SET coverPictureURL = :newCoverPictureURL WHERE memberId = :memberId;');
					$statement->bindValue(':newCoverPictureURL', $newCoverPictureURL, PDO::PARAM_STR);
					$statement->bindValue(':memberId', $memberId, PDO::PARAM_INT);
					$statement->execute();
					if ($statement->rowCount() > 0){
						return true;
					}
					else{
						return false;
					}
				}
				catch (PDOException $ex){
					echo 'MySQL has generated an error: ' . $ex->getMessage() . '<br>';
					return null;
				}
			}
			
			public function setThumbnailURLOfMember($memberId, $newThumbnailURL){
				try{
					$statement = $this->db->prepare('UPDATE Member SET thumbnailURL = :newThumbnailURL WHERE memberId = :memberId;');
					$statement->bindValue(':newThumbnailURL', $newThumbnailURL, PDO::PARAM_STR);
					$statement->bindValue(':memberId', $memberId, PDO::PARAM_INT);
					$statement->execute();
					if ($statement->rowCount() > 0){
						return true;
					}
					else{
						return false;
					}
				}
				catch (PDOException $ex){
					echo 'MySQL has generated an error: ' . $ex->getMessage() . '<br>';
					return null;
				}
			}
			
			public function checkHearts($memberId, $quantity){
				try{
					$statement = $this->db->prepare('SELECT hearts FROM Member WHERE memberId = :memberId;');
					$statement->bindValue(':memberId', $memberId, PDO::PARAM_INT);
					$statement->execute();
					$row = $statement->fetch(PDO::FETCH_ASSOC);
					if ($row['hearts'] >= $quantity){
						return true;
					}
					else{
						return false;
					}
				}
				catch (PDOException $ex){
					echo 'MySQL has generated an error: ' . $ex->getMessage() . '<br>';
					return null;
				}
			}
			
			public function updateHearts($memberId, $quantityToSubtract){
				try{
					$statement = $this->db->prepare('UPDATE Member SET hearts = hearts - :quantityToSubtract WHERE memberId = :memberId;');
					$statement->bindValue(':quantityToSubtract', $quantityToSubtract, PDO::PARAM_INT);
					$statement->bindValue(':memberId', $memberId, PDO::PARAM_INT);
					$statement->execute();
					if ($statement->rowCount() > 0){
						return true;
					}
					else{
						return false;
					}
				}
				catch (PDOException $ex){
					echo 'MySQL has generated an error: ' . $ex->getMessage() . '<br>';
					return null;
				}
			}
			
		// RELATIONSHIPTYPE Table
		
			public function addRelationshipType($description){
				try{
					$statement = $this->db->prepare('INSERT INTO RelationshipType(description) VALUES (:description);');
					$statement->bindValue(':description', $description, PDO::PARAM_STR);
					$statement->execute();
					if ($statement->rowCount() > 0){
						return true;
					}
					else{
						return false;
					}
				}
				catch (PDOException $ex){
					echo 'MySQL has generated an error: ' . $ex->getMessage() . '<br>';
					return null;
				}
			}
			
			public function getRelationshipTypeInfo($relationshipTypeId){
				try{
					$statement = $this->db->prepare('SELECT relationshipTypeId, description FROM RelationshipType WHERE relationshipTypeId = :relationshipTypeId;');
					$statement->bindValue(':relationshipTypeId', $relationshipTypeId, PDO::PARAM_STR);
					$statement->execute();
					if ($statement->rowCount() > 0){
						return $statement->fetch(PDO::FETCH_ASSOC);
					}
					else{
						return false;
					}
				}
				catch (PDOException $ex){
					echo 'MySQL has generated an error: ' . $ex->getMessage() . '<br>';
					return null;
				}
			}
			
			public function getRelationshipTypeId($description){
				try{
					$statement = $this->db->prepare('SELECT relationshipTypeId FROM RelationshipType WHERE description = :description;');
					$statement->bindValue(':description', $description, PDO::PARAM_STR);
					$statement->execute();
					if ($statement->rowCount() > 0){
						return $statement->fetch(PDO::FETCH_ASSOC);
					}
					else{
						return false;
					}
				}
				catch (PDOException $ex){
					echo 'MySQL has generated an error: ' . $ex->getMessage() . '<br>';
					return null;
				}
			}
			
			public function getRelationshipTypes(){
				try{
					$statement = $this->db->prepare('SELECT relationshipTypeId, description FROM RelationshipType;');
					$statement->execute();
					if ($statement->rowCount() > 0){
						return $statement->fetchAll(PDO::FETCH_ASSOC);
					}
					else{
						return false;
					}
				}
				catch (PDOException $ex){
					echo 'MySQL has generated an error: ' . $ex->getMessage() . '<br>';
					return null;
				}
			}
			
		// GIFTTYPE Table

			public function addGiftType($description, $photographURL, $cost){
				try{
					$statement = $this->db->prepare('INSERT INTO GiftType(description, photographURL, cost)
					VALUES ("' . $description . '", "' . $photographURL . '", ' . $cost . ');');
					$statement->execute();
					if ($statement->rowCount() > 0){
						return true;
					}
					else{
						return false;
					}
				}
				catch (PDOException $ex){
					echo 'MySQL has generated an error: ' . $ex->getMessage() . '<br>';
					return null;
				}
			}
			
			public function getGiftTypeInfo($giftTypeId){
				try{
					$statement = $this->db->prepare('SELECT giftTypeId, description, photographURL, cost FROM GiftType WHERE giftTypeId = :giftTypeId;');
					$statement->bindValue(':giftTypeId', $giftTypeId);
					$statement->execute();
					if ($statement->rowCount() > 0){
						return $statement->fetch(PDO::FETCH_ASSOC);
					}
					else{
						return false;
					}
				}
				catch (PDOException $ex){
					echo 'MySQL has generated an error: ' . $ex->getMessage() . '<br>';
					return null;
				}
			}
			
			public function getGiftTypeId($description){
				try{
					$statement = $this->db->prepare('SELECT giftTypeId FROM GiftType WHERE description = :description;');
					$statement->bindValue(':description', $description);
					$statement->execute();
					if ($statement->rowCount() > 0){
						return $statement->fetch(PDO::FETCH_ASSOC);
					}
					else{
						return false;
					}
				}
				catch (PDOException $ex){
					echo 'MySQL has generated an error: ' . $ex->getMessage() . '<br>';
					return null;
				}
			}
			
			public function getGiftTypes(){
				try{
					$statement = $this->db->prepare('SELECT giftTypeId, description, photographURL, cost FROM GiftType;');
					$statement->execute();
					if ($statement->rowCount() > 0){
						return $statement->fetchAll(PDO::FETCH_ASSOC);
					}
					else{
						return false;
					}
				}
				catch (PDOException $ex){
					echo 'MySQL has generated an error: ' . $ex->getMessage() . '<br>';
					return null;
				}
			}
		
		// INTERESTTYPE Table
		
			public function addInterestType($description){
				try{
					$statement = $this->db->prepare('INSERT INTO InterestType(description) VALUES (:description);');
					$statement->bindValue(':description', $description, PDO::PARAM_STR);
					$statement->execute();
					if ($statement->rowCount() > 0){
						return true;
					}
					else{
						return false;
					}
				}
				catch (PDOException $ex){
					echo 'MySQL has generated an error: ' . $ex->getMessage() . '<br>';
					return null;
				}
			}
			
			public function getInterestTypeInfo($interestTypeId){
				try{
					$statement = $this->db->prepare('SELECT interestTypeId, description FROM InterestType WHERE interestTypeId = :interestTypeId;');
					$statement->bindValue(':interestTypeId', $interestTypeId);
					$statement->execute();
					if ($statement->rowCount() > 0){
						return $statement->fetch(PDO::FETCH_ASSOC);
					}
					else{
						return false;
					}
				}
				catch (PDOException $ex){
					echo 'MySQL has generated an error: ' . $ex->getMessage() . '<br>';
					return null;
				}
			}
			
			public function getInterestTypeId($description){
				try{
					$statement = $this->db->prepare('SELECT interestTypeId FROM InterestType WHERE description = :description;');
					$statement->bindValue(':description', $description);
					$statement->execute();
					if ($statement->rowCount() > 0){
						return $statement->fetch(PDO::FETCH_ASSOC);
					}
					else{
						return false;
					}
				}
				catch (PDOException $ex){
					echo 'MySQL has generated an error: ' . $ex->getMessage() . '<br>';
					return null;
				}
			}
		
			public function getInterestTypes(){
				try{
					$statement = $this->db->prepare('SELECT interestTypeId, description FROM InterestType;');
					$statement->execute();
					if ($statement->rowCount() > 0){
						return $statement->fetchAll(PDO::FETCH_ASSOC);
					}
					else{
						return false;
					}
				}
				catch (PDOException $ex){
					echo 'MySQL has generated an error: ' . $ex->getMessage() . '<br>';
					return null;
				}
			}
			
		// RELATED Table
			
			public function addRelation($memberId, $relatedId, $relationshipTypeId){
				try{
					$statement = $this->db->prepare('INSERT INTO Related(memberId, relatedId, relationshipTypeId)
					VALUES(:memberId, :relatedId, :relationshipTypeId);');
					$statement->bindValue(':memberId', $memberId, PDO::PARAM_INT);
					$statement->bindValue(':relatedId', $relatedId, PDO::PARAM_INT);
					$statement->bindValue(':relationshipTypeId', $relationshipTypeId, PDO::PARAM_INT);
					$statement->execute();
					$statement = $this->db->prepare('INSERT INTO Related(memberId, relatedId, relationshipTypeId)
					VALUES(:relatedId, :memberId, :relationshipTypeId);');
					$statement->bindValue(':memberId', $memberId, PDO::PARAM_INT);
					$statement->bindValue(':relatedId', $relatedId, PDO::PARAM_INT);
					$statement->bindValue(':relationshipTypeId', $relationshipTypeId, PDO::PARAM_INT);
					$statement->execute();
					if ($statement->rowCount() > 0){
						return true;
					}
					else{
						return false;
					}
				}
				catch (PDOException $ex){
					echo 'MySQL has generated an error: ' . $ex->getMessage() . '<br>';
					return null;
				}
			}
			
			public function removeRelation($memberId, $relatedId){
				try{
					$statement = $this->db->prepare('DELETE FROM Related WHERE memberId = :memberId AND relatedId = :relatedId;');
					$statement->bindValue(':memberId', $memberId, PDO::PARAM_INT);
					$statement->bindValue(':relatedId', $relatedId, PDO::PARAM_INT);
					$statement->execute();
					if ($statement->rowCount() > 0){
						return true;
					}
					else{
						return false;
					}
				}
				catch (PDOException $ex){
					echo 'MySQL has generated an error: ' . $ex->getMessage() . '<br>';
					return null;
				}
			}
			
			public function getRelated($memberId, $relationshipTypeId){
				try{
					$statement = $this->db->prepare('SELECT r.relatedId as relatedId, rt.description as description, r.timeStamp
					FROM Related r JOIN RelationshipType rt
					ON r.relationshipTypeId = rt.relationshipTypeId
					JOIN Member m
					ON m.memberId = r.relatedId
					WHERE r.memberId = :memberId
					AND r.relationshipTypeId = :relationshipTypeId
					ORDER BY m.lastName;');
					$statement->bindValue(':memberId', $memberId, PDO::PARAM_INT);
					$statement->bindValue(':relationshipTypeId', $relationshipTypeId, PDO::PARAM_INT);
					$statement->execute();
					if ($statement->rowCount() > 0){
						return $statement->fetchAll(PDO::FETCH_ASSOC);
					}
					else{
						return false;
					}
				}
				catch (PDOException $ex){
					echo 'MySQL has generated an error: ' . $ex->getMessage() . '<br>';
					return null;
				}
			}
		
		// BLOCKED Table
		
			public function blockMember($blockerId, $blockedId){
				try{
					$statement = $this->db->prepare('INSERT INTO Blocked VALUES (:blockerId, :blockedId);');
					$statement->bindValue(':blockerId', $blockerId, PDO::PARAM_INT);
					$statement->bindValue(':blockedId', $blockedId, PDO::PARAM_INT);
					$statement->execute();
					if ($statement->rowCount() > 0){
						return true;
					}
					else{
						return false;
					}
				}
				catch (PDOException $ex){
					echo 'MySQL has generated an error: ' . $ex->getMessage() . '<br>';
					return null;
				}
			}
			
			public function unblockMember($blockerId, $blockedId){
				try{
					$statement = $this->db->prepare('DELETE FROM Blocked WHERE blockerId = :blockerId AND blockedId = :blockedId;');
					$statement->bindValue(':blockerId', $blockerId, PDO::PARAM_INT);
					$statement->bindValue(':blockedId', $blockedId, PDO::PARAM_INT);
					$statement->execute();
					if ($statement->rowCount() > 0){
						return true;
					}
					else{
						return false;
					}
				}
				catch (PDOException $ex){
					echo 'MySQL has generated an error: ' . $ex->getMessage() . '<br>';
					return null;
				}
			}
			
			public function checkBlocked($blockerId, $blockedId){
				try{
					$statement = $this->db->prepare('SELECT * FROM Blocked WHERE blockerId = :blockerId AND blockedId = :blockedId;');
					$statement->bindValue(':blockerId', $blockerId, PDO::PARAM_INT);
					$statement->bindValue(':blockedId', $blockedId, PDO::PARAM_INT);
					$statement->execute();
					if ($statement->rowCount() > 0){
						return true;
					}
					else{
						return false;
					}
				}
				catch (PDOException $ex){
					echo 'MySQL has generated an error: ' . $ex->getMessage() . '<br>';
					return null;
				}
			}
			
			public function getBlockedMembers($blockerId){
				try{
					$statement = $this->db->prepare('SELECT blockerId, blockedId FROM Blocked WHERE blockerId = :blockerId;');
					$statement->bindValue(':blockerId', $blockerId, PDO::PARAM_INT);
					$statement->execute();
					if ($statement->rowCount() > 0){
						return $statement->fetchAll(PDO::FETCH_ASSOC);
					}
					else{
						return false;
					}
				}
				catch (PDOException $ex){
					echo 'MySQL has generated an error: ' . $ex->getMessage() . '<br>';
					return null;
				}
			}
		
		// MESSAGE Table
		
			public function sendMessage($sentTo, $sentFrom, $title, $content){
				$newValue = 1;
				try{
					$statement = $this->db->prepare('SELECT count(*) as countValue, max(messageNumber) as maxValueTemp FROM Message WHERE sentTo = :sentTo;');
					$statement->bindValue(':sentTo', $sentTo, PDO::PARAM_INT);
					$statement->execute();
					$row = $statement->fetch(PDO::FETCH_ASSOC);
					if ($row['countValue'] > 0){
						$newValue = $row['maxValueTemp'] + 1;
					}
				}
				catch (PDOException $ex){
					echo 'MySQL has generated an error: ' . $ex->getMessage() . '<br>';
					return null;
				}
				try{
					$statement = $this->db->prepare('INSERT INTO Message(sentTo, sentFrom, messageNumber, title, content)
					VALUES(:sentTo, :sentFrom, :messageNumber, :title, :content);');
					$statement->bindValue(':sentTo', $sentTo, PDO::PARAM_INT);
					$statement->bindValue(':sentFrom', $sentFrom, PDO::PARAM_INT);
					$statement->bindValue(':messageNumber', $newValue, PDO::PARAM_INT);
					$statement->bindValue(':title', $title, PDO::PARAM_STR);
					$statement->bindValue(':content', $content, PDO::PARAM_STR);
					$statement->execute();
					if ($statement->rowCount() > 0){
						return true;
					}
					else{
						return false;
					}
				}
				catch (PDOException $ex){
					echo 'MySQL has generated an error: ' . $ex->getMessage() . '<br>';
					return null;
				}
			}
			
			public function deleteMessage($sentTo, $sentFrom, $messageNumber){
				try{
					$statement = $this->db->prepare('DELETE FROM Message WHERE sentTo = :sentTo AND sentFrom = :sentFrom AND messageNumber = :messageNumber;');
					$statement->bindValue(':sentTo', $sentTo, PDO::PARAM_INT);
					$statement->bindValue(':sentFrom', $sentFrom, PDO::PARAM_INT);
					$statement->bindValue(':messageNumber', $messageNumber, PDO::PARAM_INT);
					$statement->execute();					
					if ($statement->rowCount() > 0){
						return true;
					}
					else{
						return false;
					}
				}
				catch (PDOException $ex){
					echo 'MySQL has generated an error: ' . $ex->getMessage() . '<br>';
					return null;
				}
			}
			
			public function markMessageAsRead($sentTo, $sentFrom, $messageNumber){
				try{
					$statement = $this->db->prepare('UPDATE Message SET isRead = TRUE WHERE sentTo = :sentTo AND sentFrom = :sentFrom AND messageNumber = :messageNumber;');
					$statement->bindValue(':sentTo', $sentTo, PDO::PARAM_INT);
					$statement->bindValue(':sentFrom', $sentFrom, PDO::PARAM_INT);
					$statement->bindValue(':messageNumber', $messageNumber, PDO::PARAM_INT);
					$statement->execute();					
					if ($statement->rowCount() > 0){
						return true;
					}
					else{
						return false;
					}
				}
				catch (PDOException $ex){
					echo 'MySQL has generated an error: ' . $ex->getMessage() . '<br>';
					return null;
				}
			}
			
			public function markMessageAsUnread($sentTo, $sentFrom, $messageNumber){
				try{
					$statement = $this->db->prepare('UPDATE Message SET isRead = FALSE WHERE sentTo = :sentTo AND sentFrom = :sentFrom AND messageNumber = :messageNumber;');
					$statement->bindValue(':sentTo', $sentTo, PDO::PARAM_INT);
					$statement->bindValue(':sentFrom', $sentFrom, PDO::PARAM_INT);
					$statement->bindValue(':messageNumber', $messageNumber, PDO::PARAM_INT);
					$statement->execute();					
					if ($statement->rowCount() > 0){
						return true;
					}
					else{
						return false;
					}
				}
				catch (PDOException $ex){
					echo 'MySQL has generated an error: ' . $ex->getMessage() . '<br>';
					return null;
				}
			}
			
			public function getMessageInfo($sentTo, $sentFrom, $messageNumber){
				try{
					$statement = $this->db->prepare('SELECT sentTo, sentFrom, messageNumber, hideFromReceiver, hideFromSender, isRead, title, content, timeStamp FROM Message WHERE sentTo = :sentTo AND sentFrom = :sentFrom AND messageNumber = :messageNumber;');
					$statement->bindValue(':sentTo', $sentTo, PDO::PARAM_INT);
					$statement->bindValue(':sentFrom', $sentFrom, PDO::PARAM_INT);
					$statement->bindValue(':messageNumber', $messageNumber, PDO::PARAM_INT);
					$statement->execute();
					if ($statement->rowCount() > 0){
						return $statement->fetchAll(PDO::FETCH_ASSOC);
					}
					else{
						return false;
					}
				}
				catch (PDOException $ex){
					echo 'MySQL has generated an error: ' . $ex->getMessage() . '<br>';
					return null;
				}
			}
			
			public function getMessagesSentToMember($memberId){
				try{
					$statement = $this->db->prepare('SELECT sentTo, sentFrom, messageNumber, hideFromReceiver, hideFromSender, isRead, title, content, timeStamp FROM Message WHERE sentTo = :sentTo AND hideFromReceiver = FALSE ORDER BY timeStamp DESC;');
					$statement->bindValue(':sentTo', $memberId, PDO::PARAM_INT);
					$statement->execute();
					if ($statement->rowCount() > 0){
						return $statement->fetchAll(PDO::FETCH_ASSOC);
					}
					else{
						return false;
					}
				}
				catch (PDOException $ex){
					echo 'MySQL has generated an error: ' . $ex->getMessage() . '<br>';
					return null;
				}
			}
			
			public function getMessagesSentFromMember($memberId){
				try{
					$statement = $this->db->prepare('SELECT sentTo, sentFrom, messageNumber, hideFromReceiver, hideFromSender, isRead, title, content, timeStamp FROM Message WHERE sentFrom = :sentFrom AND hideFromSender = FALSE ORDER BY timeStamp DESC;');
					$statement->bindValue(':sentFrom', $memberId, PDO::PARAM_INT);
					$statement->execute();
					if ($statement->rowCount() > 0){
						return $statement->fetchAll(PDO::FETCH_ASSOC);
					}
					else{
						return false;
					}
				}
				catch (PDOException $ex){
					echo 'MySQL has generated an error: ' . $ex->getMessage() . '<br>';
					return null;
				}
			}
			
			public function hideMessageFromReceiver($sentTo, $sentFrom, $messageNumber){
				try{
					$statement = $this->db->prepare('UPDATE Message SET hideFromReceiver = TRUE WHERE sentTo = :sentTo AND sentFrom = :sentFrom AND messageNumber = :messageNumber;');
					$statement->bindValue(':sentTo', $sentTo, PDO::PARAM_INT);
					$statement->bindValue(':sentFrom', $sentFrom, PDO::PARAM_INT);
					$statement->bindValue(':messageNumber', $messageNumber, PDO::PARAM_INT);
					$statement->execute();					
					if ($statement->rowCount() > 0){
						return true;
					}
					else{
						return false;
					}
				}
				catch (PDOException $ex){
					echo 'MySQL has generated an error: ' . $ex->getMessage() . '<br>';
					return null;
				}
			}
			
			public function hideMessageFromSender($sentTo, $sentFrom, $messageNumber){
				try{
					$statement = $this->db->prepare('UPDATE Message SET hideFromSender = TRUE WHERE sentTo = :sentTo AND sentFrom = :sentFrom AND messageNumber = :messageNumber;');
					$statement->bindValue(':sentTo', $sentTo, PDO::PARAM_INT);
					$statement->bindValue(':sentFrom', $sentFrom, PDO::PARAM_INT);
					$statement->bindValue(':messageNumber', $messageNumber, PDO::PARAM_INT);
					$statement->execute();					
					if ($statement->rowCount() > 0){
						return true;
					}
					else{
						return false;
					}
				}
				catch (PDOException $ex){
					echo 'MySQL has generated an error: ' . $ex->getMessage() . '<br>';
					return null;
				}
			}
			
		// REQUEST Table
		
			public function sendRequest($sentTo, $sentFrom, $title, $requestType, $content){
				$newValue = 1;
				try{
					$statement = $this->db->prepare('SELECT count(*) as countValue, max(requestNumber) as maxValueTemp FROM Request WHERE sentTo = :sentTo;');
					$statement->bindValue(':sentTo', $sentTo, PDO::PARAM_INT);
					$statement->execute();
					$row = $statement->fetch(PDO::FETCH_ASSOC);
					if ($row['countValue'] > 0){
						$newValue = $row['maxValueTemp'] + 1;
					}
				}
				catch (PDOException $ex){
					echo 'MySQL has generated an error: ' . $ex->getMessage() . '<br>';
					return null;
				}
				try{
					$statement = $this->db->prepare('INSERT INTO Request(sentTo, sentFrom, requestNumber, title, requestType, content)
					VALUES(:sentTo, :sentFrom, :requestNumber, :title, :requestType, :content);');
					$statement->bindValue(':sentTo', $sentTo, PDO::PARAM_INT);
					$statement->bindValue(':sentFrom', $sentFrom, PDO::PARAM_INT);
					$statement->bindValue(':requestNumber', $newValue, PDO::PARAM_INT);
					$statement->bindValue(':title', $title, PDO::PARAM_STR);
					$statement->bindValue(':requestType', $requestType, PDO::PARAM_STR);
					$statement->bindValue(':content', $content, PDO::PARAM_STR);
					$statement->execute();
					if ($statement->rowCount() > 0){
						return true;
					}
					else{
						return false;
					}
				}
				catch (PDOException $ex){
					echo 'MySQL has generated an error: ' . $ex->getMessage() . '<br>';
					return null;
				}
			}
			
			public function deleteRequest($sentTo, $sentFrom, $requestNumber){
				try{
					$statement = $this->db->prepare('DELETE FROM Request WHERE sentTo = :sentTo AND sentFrom = :sentFrom AND requestNumber = :requestNumber;');
					$statement->bindValue(':sentTo', $sentTo, PDO::PARAM_INT);
					$statement->bindValue(':sentFrom', $sentFrom, PDO::PARAM_INT);
					$statement->bindValue(':requestNumber', $requestNumber, PDO::PARAM_INT);
					$statement->execute();					
					if ($statement->rowCount() > 0){
						return true;
					}
					else{
						return false;
					}
				}
				catch (PDOException $ex){
					echo 'MySQL has generated an error: ' . $ex->getMessage() . '<br>';
					return null;
				}
			}
			
			public function markRequestAsRead($sentTo, $sentFrom, $requestNumber){
				try{
					$statement = $this->db->prepare('UPDATE Request SET isRead = TRUE WHERE sentTo = :sentTo AND sentFrom = :sentFrom AND requestNumber = :requestNumber;');
					$statement->bindValue(':sentTo', $sentTo, PDO::PARAM_INT);
					$statement->bindValue(':sentFrom', $sentFrom, PDO::PARAM_INT);
					$statement->bindValue(':requestNumber', $requestNumber, PDO::PARAM_INT);
					$statement->execute();					
					if ($statement->rowCount() > 0){
						return true;
					}
					else{
						return false;
					}
				}
				catch (PDOException $ex){
					echo 'MySQL has generated an error: ' . $ex->getMessage() . '<br>';
					return null;
				}
			}
			
			public function markRequestAsUnread($sentTo, $sentFrom, $requestNumber){
				try{
					$statement = $this->db->prepare('UPDATE Request SET isRead = FALSE WHERE sentTo = :sentTo AND sentFrom = :sentFrom AND requestNumber = :requestNumber;');
					$statement->bindValue(':sentTo', $sentTo, PDO::PARAM_INT);
					$statement->bindValue(':sentFrom', $sentFrom, PDO::PARAM_INT);
					$statement->bindValue(':requestNumber', $requestNumber, PDO::PARAM_INT);
					$statement->execute();					
					if ($statement->rowCount() > 0){
						return true;
					}
					else{
						return false;
					}
				}
				catch (PDOException $ex){
					echo 'MySQL has generated an error: ' . $ex->getMessage() . '<br>';
					return null;
				}
			}
			
			public function getRequestInfo($sentTo, $sentFrom, $requestNumber){
				try{
					$statement = $this->db->prepare('SELECT sentTo, sentFrom, requestNumber, requestType, content, timeStamp FROM Request WHERE sentTo = :sentTo AND sentFrom = :sentFrom AND requestNumber = :requestNumber;');
					$statement->bindValue(':sentTo', $sentTo, PDO::PARAM_INT);
					$statement->bindValue(':sentFrom', $sentFrom, PDO::PARAM_INT);
					$statement->bindValue(':requestNumber', $requestNumber, PDO::PARAM_INT);
					$statement->execute();
					if ($statement->rowCount() > 0){
						return $statement->fetchAll(PDO::FETCH_ASSOC);
					}
					else{
						return false;
					}
				}
				catch (PDOException $ex){
					echo 'MySQL has generated an error: ' . $ex->getMessage() . '<br>';
					return null;
				}
			}
			
			public function getRequestsSentToMember($memberId){
				try{
					$statement = $this->db->prepare('SELECT sentTo, sentFrom, requestNumber, requestType, content, timeStamp FROM Request WHERE sentTo = :sentTo ORDER BY timeStamp DESC;');
					$statement->bindValue(':sentTo', $memberId, PDO::PARAM_INT);
					$statement->execute();
					if ($statement->rowCount() > 0){
						return $statement->fetchAll(PDO::FETCH_ASSOC);
					}
					else{
						return false;
					}
				}
				catch (PDOException $ex){
					echo 'MySQL has generated an error: ' . $ex->getMessage() . '<br>';
					return null;
				}
			}
			
			public function getRequestsSentFromMember($memberId){
				try{
					$statement = $this->db->prepare('SELECT sentTo, sentFrom, requestNumber, requestType, content, timeStamp FROM Request WHERE sentFrom = :sentFrom ORDER BY timeStamp DESC;');
					$statement->bindValue(':sentFrom', $memberId, PDO::PARAM_INT);
					$statement->execute();
					if ($statement->rowCount() > 0){
						return $statement->fetchAll(PDO::FETCH_ASSOC);
					}
					else{
						return false;
					}
				}
				catch (PDOException $ex){
					echo 'MySQL has generated an error: ' . $ex->getMessage() . '<br>';
					return null;
				}
			}
			
		// INTEREST Table
		
			public function addInterest($memberId, $interestTypeId, $title, $artist){
				$newValue = 1;
				try{
					$statement = $this->db->prepare('SELECT count(*) as countValue, max(interestNumber) as maxValueTemp
					FROM Interest WHERE memberId = :memberId;');
					$statement->bindValue(':memberId', $memberId, PDO::PARAM_INT);
					$statement->execute();
					$row = $statement->fetch(PDO::FETCH_ASSOC);
					if ($row['countValue'] > 0){
						$newValue = $row['maxValueTemp'] + 1;
					}
				}
				catch (PDOException $ex){
					echo 'MySQL has generated an error: ' . $ex->getMessage() . '<br>';
					return null;
				}
				try{
					$statement = $this->db->prepare('INSERT INTO Interest VALUES(:memberId, :interestNumber, :interestTypeId, :title, :artist);');
					$statement->bindValue(':memberId', $memberId, PDO::PARAM_INT);
					$statement->bindValue(':interestNumber', $newValue, PDO::PARAM_INT);
					$statement->bindValue(':interestTypeId', $interestTypeId, PDO::PARAM_INT);
					$statement->bindValue(':title', $title, PDO::PARAM_STR);
					$statement->bindValue(':artist', $artist, PDO::PARAM_STR);
					$statement->execute();
					if ($statement->rowCount() > 0){
						return true;
					}
					else{
						return false;
					}
				}
				catch (PDOException $ex){
					echo 'MySQL has generated an error: ' . $ex->getMessage() . '<br>';
					return null;
				}
			}
			
			public function deleteInterest($memberId, $interestNumber){
				try{
					$statement = $this->db->prepare('DELETE FROM Interest WHERE memberId = :memberId AND interestNumber = :interestNumber;');
					$statement->bindValue(':memberId', $memberId, PDO::PARAM_INT);
					$statement->bindValue(':interestNumber', $interestNumber, PDO::PARAM_INT);
					$statement->execute();
					if ($statement->rowCount() > 0){
						return true;
					}
					else{
						return false;
					}
				}
				catch (PDOException $ex){
					echo 'MySQL has generated an error: ' . $ex->getMessage() . '<br>';
					return null;
				}
			}
			
			public function getInterestInfo($memberId, $interestNumber){
				try{
					$statement = $this->db->prepare('SELECT memberId, interestNumber, interestTypeId, title, artist
					FROM Interest WHERE memberId = :memberId AND interestNumber = :interestNumber;');
					$statement->bindValue(':memberId', $memberId, PDO::PARAM_INT);
					$statement->bindValue(':interestNumberId', $interestNumber, PDO::PARAM_INT);
					$statement->execute();
					if ($statement->rowCount() > 0){
						return $statement->fetch(PDO::FETCH_ASSOC);
					}
					else{
						return false;
					}
				}
				catch (PDOException $ex){
					echo 'MySQL has generated an error: ' . $ex->getMessage() . '<br>';
					return null;
				}
			}
			
			public function getInterestsOfMember($memberId){
				try{
					$statement = $this->db->prepare('SELECT memberId, interestNumber, interestTypeId, title, artist
					FROM Interest WHERE memberId = :memberId;');
					$statement->bindValue(':memberId', $memberId, PDO::PARAM_INT);
					$statement->execute();
					if ($statement->rowCount() > 0){
						return $statement->fetchAll(PDO::FETCH_ASSOC);
					}
					else{
						return false;
					}
				}
				catch (PDOException $ex){
					echo 'MySQL has generated an error: ' . $ex->getMessage() . '<br>';
					return null;
				}
			}
			
		// GIFT Table
		
			public function sendGift($sentTo, $sentFrom, $giftTypeId){
				$newValue = 1;
				try{
					$statement = $this->db->prepare('SELECT count(*) as countValue, max(giftNumber) as maxValueTemp FROM Gift WHERE sentTo = :sentTo;');
					$statement->bindValue(':sentTo', $sentTo, PDO::PARAM_INT);
					$statement->execute();
					$row = $statement->fetch(PDO::FETCH_ASSOC);
					if ($row['countValue'] > 0){
						$newValue = $row['maxValueTemp'] + 1;
					}
				}
				catch (PDOException $ex){
					echo 'MySQL has generated an error: ' . $ex->getMessage() . '<br>';
					return null;
				}
				try{
					$statement = $this->db->prepare('INSERT INTO Gift(sentTo, sentFrom, giftNumber, giftTypeId)
					VALUES(:sentTo, :sentFrom, :giftNumber, :giftTypeId);');
					$statement->bindValue(':sentTo', $sentTo, PDO::PARAM_INT);
					$statement->bindValue(':sentFrom', $sentFrom, PDO::PARAM_INT);
					$statement->bindValue(':giftNumber', $newValue, PDO::PARAM_INT);
					$statement->bindValue(':giftTypeId', $giftTypeId, PDO::PARAM_INT);
					$statement->execute();
					if ($statement->rowCount() > 0){
						return true;
					}
					else{
						return false;
					}
				}
				catch (PDOException $ex){
					echo 'MySQL has generated an error: ' . $ex->getMessage() . '<br>';
					return null;
				}
			}
		
			public function deleteGift($sentTo, $sentFrom, $giftNumber){
				try{
					$statement = $this->db->prepare('DELETE FROM Gift WHERE sentTo = :sentTo AND sentFrom = :sentFrom AND giftNumber = :giftNumber;');
					$statement->bindValue(':sentTo', $sentTo, PDO::PARAM_INT);
					$statement->bindValue(':sentFrom', $sentFrom, PDO::PARAM_INT);
					$statement->bindValue(':giftNumber', $giftNumber, PDO::PARAM_INT);
					$statement->execute();					
					if ($statement->rowCount() > 0){
						return true;
					}
					else{
						return false;
					}
				}
				catch (PDOException $ex){
					echo 'MySQL has generated an error: ' . $ex->getMessage() . '<br>';
					return null;
				}
			}
			
			public function getGiftInfo($sentTo, $sentFrom, $giftNumber){
				try{
					$statement = $this->db->prepare('SELECT sentTo, sentFrom, giftNumber, giftTypeId, timeStamp FROM Gift WHERE sentTo = :sentTo AND sentFrom = :sentFrom AND giftNumber = :giftNumber;');
					$statement->bindValue(':sentTo', $sentTo, PDO::PARAM_INT);
					$statement->bindValue(':sentFrom', $sentFrom, PDO::PARAM_INT);
					$statement->bindValue(':giftNumber', $giftNumber, PDO::PARAM_INT);
					$statement->execute();
					if ($statement->rowCount() > 0){
						return $statement->fetch(PDO::FETCH_ASSOC);
					}
					else{
						return false;
					}
				}
				catch (PDOException $ex){
					echo 'MySQL has generated an error: ' . $ex->getMessage() . '<br>';
					return null;
				}
			}
			
			public function getGiftsSentToMember($memberId){
				try{
					$statement = $this->db->prepare('SELECT sentTo, sentFrom, giftNumber, giftTypeId, timeStamp FROM Gift WHERE sentTo = :sentTo ORDER BY timeStamp DESC;');
					$statement->bindValue(':sentTo', $memberId, PDO::PARAM_INT);
					$statement->execute();
					if ($statement->rowCount() > 0){
						return $statement->fetchAll(PDO::FETCH_ASSOC);
					}
					else{
						return false;
					}
				}
				catch (PDOException $ex){
					echo 'MySQL has generated an error: ' . $ex->getMessage() . '<br>';
					return null;
				}
			}
			
			public function getGiftsSentFromMember($memberId){
				try{
					$statement = $this->db->prepare('SELECT sentTo, sentFrom, giftNumber, giftTypeId, timeStamp FROM Gift WHERE sentFrom = :sentFrom ORDER BY timeStamp DESC;');
					$statement->bindValue(':sentFrom', $memberId, PDO::PARAM_INT);
					$statement->execute();
					if ($statement->rowCount() > 0){
						return $statement->fetchAll(PDO::FETCH_ASSOC);
					}
					else{
						return false;
					}
				}
				catch (PDOException $ex){
					echo 'MySQL has generated an error: ' . $ex->getMessage() . '<br>';
					return null;
				}
			}
		
		// WALL CONTENT Table
		
			public function postWallContent($memberId, $permissionId, $currentPosterId, $previousPosterId, $originalPosterId, $contentType, $content){
				$newValue = 1;
				try{
					$statement = $this->db->prepare('SELECT count(*) as countValue, max(wallContentNumber) as maxValueTemp
					FROM WallContent WHERE memberId = :memberId;');
					$statement->bindValue(':memberId', $memberId, PDO::PARAM_INT);
					$statement->execute();
					$row = $statement->fetch(PDO::FETCH_ASSOC);
					if ($row['countValue'] > 0){
						$newValue = $row['maxValueTemp'] + 1;
					}
				}
				catch (PDOException $ex){
					echo 'MySQL has generated an error: ' . $ex->getMessage() . '<br>';
					return null;
				}
				try{
					$statement = $this->db->prepare('INSERT INTO WallContent(memberId, wallContentNumber, permissionId, currentPosterId, previousPosterId, originalPosterId, contentType, content)
					VALUES(:memberId, :wallContentNumber, :permissionId, :currentPosterId, :previousPosterId, :originalPosterId, :contentType, :content);');
					$statement->bindValue(':memberId', $memberId, PDO::PARAM_INT);
					$statement->bindValue(':wallContentNumber', $newValue, PDO::PARAM_INT);
					$statement->bindValue(':permissionId', $permissionId, PDO::PARAM_INT);
					$statement->bindValue(':currentPosterId', $currentPosterId, PDO::PARAM_INT);
					$statement->bindValue(':previousPosterId', $previousPosterId, PDO::PARAM_INT);
					$statement->bindValue(':originalPosterId', $originalPosterId, PDO::PARAM_INT);
					$statement->bindValue(':contentType', $contentType, PDO::PARAM_STR);
					$statement->bindValue(':content', $content, PDO::PARAM_STR);
					$statement->execute();
					if ($statement->rowCount() > 0){
						return true;
					}
					else{
						return false;
					}
				}
				catch (PDOException $ex){
					echo 'MySQL has generated an error: ' . $ex->getMessage() . '<br>';
					return null;
				}
			}
			
			public function deleteWallContent($memberId, $wallContentNumber){
				try{
					$statement = $this->db->prepare('DELETE FROM WallContent WHERE memberId = :memberId AND wallContentNumber = :wallContentNumber;');
					$statement->bindValue(':memberId', $memberId, PDO::PARAM_INT);
					$statement->bindValue(':wallContentNumber', $wallContentNumber, PDO::PARAM_INT);
					$statement->execute();
					if ($statement->rowCount() > 0){
						return true;
					}
					else{
						return false;
					}
				}
				catch (PDOException $ex){
					echo 'MySQL has generated an error: ' . $ex->getMessage() . '<br>';
					return null;
				}
			}
			
			public function getWallContentInfo($memberId, $wallContentNumber){
				try{
					$statement = $this->db->prepare('SELECT memberId, wallContentNumber, permissionId, currentPosterId, previousPosterId, originalPosterId, contentType, content, timeStamp
					FROM WallContent WHERE memberId = :memberId AND wallContentNumber = :wallContentNumber;');
					$statement->bindValue(':memberId', $memberId, PDO::PARAM_INT);
					$statement->bindValue(':wallContentNumber', $wallContentNumber, PDO::PARAM_INT);
					$statement->execute();
					if ($statement->rowCount() > 0){
						return $statement->fetch(PDO::FETCH_ASSOC);
					}
					else{
						return false;
					}
				}
				catch (PDOException $ex){
					echo 'MySQL has generated an error: ' . $ex->getMessage() . '<br>';
					return null;
				}
			}
			
			public function getWallContents($memberId){
				try{
					$statement = $this->db->prepare('SELECT memberId,wallContentNumber,permissionId,currentPosterId,previousPosterId,originalPosterId,contentType,content,timeStamp
					FROM WallContent WHERE memberId = :memberId ORDER BY timeStamp DESC;');
					$statement->bindValue(':memberId', $memberId, PDO::PARAM_INT);
					$statement->execute();
					if ($statement->rowCount() > 0){
						return $statement->fetchAll(PDO::FETCH_ASSOC);
					}
					else{
						return false;
					}
				}
				catch (PDOException $ex){
					echo 'MySQL has generated an error: ' . $ex->getMessage() . '<br>';
					return null;
				}
			}
			
			// COMMENT Table
		
			public function postComment($memberId, $wallContentNumber, $commenterId, $content){
				$newValue = 1;
				try{
					$statement = $this->db->prepare('SELECT count(*) as countValue, max(commentNumber) as maxValueTemp
					FROM Comment WHERE memberId = :memberId AND wallContentNumber = :wallContentNumber;');
					$statement->bindValue(':memberId', $memberId, PDO::PARAM_INT);
					$statement->bindValue(':wallContentNumber', $wallContentNumber, PDO::PARAM_INT);
					$statement->execute();
					$row = $statement->fetch(PDO::FETCH_ASSOC);
					if ($row['countValue'] > 0){
						$newValue = $row['maxValueTemp'] + 1;
					}
				}
				catch (PDOException $ex){
					echo 'MySQL has generated an error: ' . $ex->getMessage() . '<br>';
					return null;
				}
				try{
					$statement = $this->db->prepare('INSERT INTO Comment(memberId, wallContentNumber, commentNumber, commenterId, content)
					VALUES(:memberId, :wallContentNumber, :commentNumber, :commenterId, :content);');
					$statement->bindValue(':memberId', $memberId, PDO::PARAM_INT);
					$statement->bindValue(':wallContentNumber', $wallContentNumber, PDO::PARAM_INT);
					$statement->bindValue(':commentNumber', $newValue, PDO::PARAM_INT);
					$statement->bindValue(':commenterId', $commenterId, PDO::PARAM_INT);
					$statement->bindValue(':content', $content, PDO::PARAM_STR);
					$statement->execute();
					if ($statement->rowCount() > 0){
						return true;
					}
					else{
						return false;
					}
				}
				catch (PDOException $ex){
					echo 'MySQL has generated an error: ' . $ex->getMessage() . '<br>';
					return null;
				}
			}
			
			public function deleteComment($memberId, $wallContentNumber, $commentNumber){
				try{
					$statement = $this->db->prepare('DELETE FROM Comment
					WHERE memberId = :memberId AND wallContentNumber = :wallContentNumber AND commentNumber = :commentNumber;');
					$statement->bindValue(':memberId', $memberId, PDO::PARAM_INT);
					$statement->bindValue(':wallContentNumber', $wallContentNumber, PDO::PARAM_INT);
					$statement->bindValue(':commentNumber', $commentNumber, PDO::PARAM_INT);
					$statement->execute();
					if ($statement->rowCount() > 0){
						return true;
					}
					else{
						return false;
					}
				}
				catch (PDOException $ex){
					echo 'MySQL has generated an error: ' . $ex->getMessage() . '<br>';
					return null;
				}
			}
			
			public function getCommentInfo($memberId, $wallContentNumber, $commentNumber){
				try{
					$statement = $this->db->prepare('SELECT memberId,wallContentNumber,commentNumber,commenterId,content,timeStamp
					FROM Comment WHERE memberId = :memberId AND wallContentNumber = :wallContentNumber AND commentNumber = :commentNumber;');
					$statement->bindValue(':memberId', $memberId, PDO::PARAM_INT);
					$statement->bindValue(':wallContentNumber', $wallContentNumber, PDO::PARAM_INT);
					$statement->bindValue(':commentNumber', $commentNumber, PDO::PARAM_INT);
					$statement->execute();
					if ($statement->rowCount() > 0){
						return $statement->fetch(PDO::FETCH_ASSOC);
					}
					else{
						return false;
					}
				}
				catch (PDOException $ex){
					echo 'MySQL has generated an error: ' . $ex->getMessage() . '<br>';
					return null;
				}
			}
			
			public function getComments($memberId, $wallContentNumber){
				try{
					$statement = $this->db->prepare('SELECT memberId,wallContentNumber,commentNumber,commenterId,content,timeStamp
					FROM Comment WHERE memberId = :memberId AND wallContentNumber = :wallContentNumber
					ORDER BY timeStamp DESC;');
					$statement->bindValue(':memberId', $memberId, PDO::PARAM_INT);
					$statement->bindValue(':wallContentNumber', $wallContentNumber, PDO::PARAM_INT);
					$statement->execute();
					if ($statement->rowCount() > 0){
						return $statement->fetchAll(PDO::FETCH_ASSOC);
					}
					else{
						return false;
					}
				}
				catch (PDOException $ex){
					echo 'MySQL has generated an error: ' . $ex->getMessage() . '<br>';
					return null;
				}
			}
			
		// PUBLICCONTENT Table
			
			public function postPublicContent($memberId, $contentType, $content){
				$newValue = 1;
				try{
					$statement = $this->db->prepare('SELECT count(*) as countValue, max(publicContentNumber) as maxValueTemp FROM PublicContent WHERE memberId = :memberId;');
					$statement->bindValue(':memberId', $memberId, PDO::PARAM_INT);
					$statement->execute();
					$row = $statement->fetch(PDO::FETCH_ASSOC);
					if ($row['countValue'] > 0){
						$newValue = $row['maxValueTemp'] + 1;
					}
				}
				catch (PDOException $ex){
					echo 'MySQL has generated an error: ' . $ex->getMessage() . '<br>';
					return null;
				}
				try{
					$statement = $this->db->prepare('INSERT INTO PublicContent(memberId, publicContentNumber, contentType, content)
					VALUES(:memberId, :publicContentNumber, :contentType, :content);');
					$statement->bindValue(':memberId', $memberId, PDO::PARAM_INT);
					$statement->bindValue(':publicContentNumber', $newValue, PDO::PARAM_INT);
					$statement->bindValue(':contentType', $contentType, PDO::PARAM_STR);
					$statement->bindValue(':content', $content, PDO::PARAM_STR);
					$statement->execute();
					if ($statement->rowCount() > 0){
						return true;
					}
					else{
						return false;
					}
				}
				catch (PDOException $ex){
					echo 'MySQL has generated an error: ' . $ex->getMessage() . '<br>';
					return null;
				}
			}
			
			public function deletePublicContent($memberId, $publicContentNumber){
				try{
					$statement = $this->db->prepare('DELETE FROM PublicContent WHERE memberId = :memberId AND publicContentNumber = :publicContentNumber;');
					$statement->bindValue(':memberId', $memberId, PDO::PARAM_INT);
					$statement->bindValue(':publicContentNumber', $publicContentNumber, PDO::PARAM_INT);
					$statement->execute();
					if ($statement->rowCount() > 0){
						return true;
					}
					else{
						return false;
					}
				}
				catch (PDOException $ex){
					echo 'MySQL has generated an error: ' . $ex->getMessage() . '<br>';
					return null;
				}
			}
			
			public function getPublicContentInfo($memberId, $publicContentNumber){
				try{
					$statement = $this->db->prepare('SELECT memberId, publicContentNumber, contentType, content, timeStamp
					FROM PublicContent WHERE memberId = :memberId AND publicContentNumber = :publicContentNumber;');
					$statement->bindValue(':memberId', $memberId, PDO::PARAM_INT);
					$statement->bindValue(':publicContentNumber', $publicContentNumber, PDO::PARAM_INT);
					$statement->execute();
					if ($statement->rowCount() > 0){
						return $statement->fetch(PDO::FETCH_ASSOC);
					}
					else{
						return false;
					}
				}
				catch (PDOException $ex){
					echo 'MySQL has generated an error: ' . $ex->getMessage() . '<br>';
					return null;
				}
			}
			
			public function getPublicContents(){
				try{
					$statement = $this->db->prepare('SELECT memberId,publicContentNumber,contentType,content,timeStamp
					FROM PublicContent ORDER BY timeStamp DESC;');
					$statement->execute();
					if ($statement->rowCount() > 0){
						return $statement->fetchAll(PDO::FETCH_ASSOC);
					}
					else{
						return false;
					}
				}
				catch (PDOException $ex){
					echo 'MySQL has generated an error: ' . $ex->getMessage() . '<br>';
					return null;
				}
			}
		
		// GROUPS Table
		
			public function retrieveAllGroups(){
				try{
					$statement = $this->db->prepare('SELECT groupId FROM Groups;');
					$statement->execute();
					if ($statement->rowCount() > 0){
						return $statement->fetchAll();
					}
					else{
						return false;
					}
				}
				catch (PDOException $ex){
					echo 'MySQL has generated an error: ' . $ex->getMessage() . '<br>';
					return null;
				}
			}
		
			public function createGroup($groupName, $ownerId, $description, $photographURL, $coverPictureURL, $thumbnailURL){
				try{
					$statement = $this->db->prepare('INSERT INTO Groups(groupName, ownerId, description, photographURL, coverPictureURL, thumbnailURL)
					VALUES (:groupName, :ownerId, :description, :photographURL, :coverPictureURL, :thumbnailURL);');
					$statement->bindValue(':groupName', $groupName, PDO::PARAM_STR);
					$statement->bindValue(':ownerId', $ownerId, PDO::PARAM_INT);
					$statement->bindValue(':description', $description, PDO::PARAM_STR);
					$statement->bindValue(':photographURL', $photographURL, PDO::PARAM_STR);
					$statement->bindValue(':coverPictureURL', $coverPictureURL, PDO::PARAM_STR);
					$statement->bindValue(':thumbnailURL', $thumbnailURL, PDO::PARAM_STR);
					$statement->execute();
					if ($statement->rowCount() > 0){
						$groupId = $this->db->lastInsertId();
						$this->addMemberOfGroup($ownerId, $groupId);
						return true;
					}
					else{
						return false;
					}
				}
				catch (PDOException $ex){
					echo 'MySQL has generated an error: ' . $ex->getMessage() . '<br>';
					return null;
				}
			}
			
			public function deleteGroup($groupId){
				try{
					$statement = $this->db->prepare('DETELE FROM Groups WHERE groupId = :groupId;');
					$statement->bindValue(':groupId', $groupId, PDO::PARAM_INT);
					$statement->execute();
					if ($statement->rowCount() > 0){
						return true;
					}
					else{
						return false;
					}
				}
				catch (PDOException $ex){
					echo 'MySQL has generated an error: ' . $ex->getMessage() . '<br>';
					return null;
				}
			}
			
			public function getGroupInfo($groupId){
				try{
					$statement = $this->db->prepare('SELECT groupId, groupName, ownerId, description,
					photographURL, coverPictureURL, thumbnailURL, timeStamp FROM Groups WHERE groupId = :groupId;');
					$statement->bindValue(':groupId', $groupId, PDO::PARAM_INT);
					$statement->execute();
					if ($statement->rowCount() > 0){
						return $statement->fetch(PDO::FETCH_ASSOC);
					}
					else{
						return false;
					}
				}
				catch (PDOException $ex){
					echo 'MySQL has generated an error: ' . $ex->getMessage() . '<br>';
					return null;
				}
			}
			
			public function getGroupId($groupName){
				try{
					$statement = $this->db->prepare('SELECT groupId FROM Groups WHERE groupName = :groupName;');
					$statement->bindValue(':groupName', $groupName, PDO::PARAM_INT);
					$statement->execute();
					if ($statement->rowCount() > 0){
						return $statement->fetch(PDO::FETCH_ASSOC);
					}
					else{
						return false;
					}
				}
				catch (PDOException $ex){
					echo 'MySQL has generated an error: ' . $ex->getMessage() . '<br>';
					return null;
				}
			}
			
			public function getOwnedGroups($ownerId){
				try{
					$statement = $this->db->prepare('SELECT groupId, groupName, ownerId, description,
					photographURL, coverPictureURL, thumbnailURL, timeStamp FROM Groups WHERE ownerId = :ownerId ORDER BY groupName;');
					$statement->bindValue(':ownerId', $ownerId, PDO::PARAM_INT);
					$statement->execute();
					if ($statement->rowCount() > 0){
						return $statement->fetchAll(PDO::FETCH_ASSOC);
					}
					else{
						return false;
					}
				}
				catch (PDOException $ex){
					echo 'MySQL has generated an error: ' . $ex->getMessage() . '<br>';
					return null;
				}
			}
			
			public function setPhotographURLOfGroup($groupId, $newPhotographURL){
				try{
					$statement = $this->db->prepare('UPDATE Groups SET photographURL = :newPhotographURL WHERE groupId = :groupId;');
					$statement->bindValue(':newPhotographURL', $newPhotographURL, PDO::PARAM_STR);
					$statement->bindValue(':groupId', $groupId, PDO::PARAM_INT);
					$statement->execute();
					if ($statement->rowCount() > 0){
						return true;
					}
					else{
						return false;
					}
				}
				catch (PDOException $ex){
					echo 'MySQL has generated an error: ' . $ex->getMessage() . '<br>';
					return null;
				}
			}
			
			public function setCoverPictureURLOfGroup($groupId, $newCoverPictureURL){
				try{
					$statement = $this->db->prepare('UPDATE Groups SET coverPictureURL = :newCoverPictureURL WHERE groupId = :groupId;');
					$statement->bindValue(':newCoverPictureURL', $newCoverPictureURL, PDO::PARAM_STR);
					$statement->bindValue(':groupId', $groupId, PDO::PARAM_INT);
					$statement->execute();
					if ($statement->rowCount() > 0){
						return true;
					}
					else{
						return false;
					}
				}
				catch (PDOException $ex){
					echo 'MySQL has generated an error: ' . $ex->getMessage() . '<br>';
					return null;
				}
			}
			
			public function setThumbnailURLOfGroup($groupId, $newThumbnailURL){
				try{
					$statement = $this->db->prepare('UPDATE Groups SET thumbnailURL = :newThumbnailURL WHERE groupId = :groupId;');
					$statement->bindValue(':newThumbnailURL', $newThumbnailURL, PDO::PARAM_STR);
					$statement->bindValue(':groupId', $groupId, PDO::PARAM_INT);
					$statement->execute();
					if ($statement->rowCount() > 0){
						return true;
					}
					else{
						return false;
					}
				}
				catch (PDOException $ex){
					echo 'MySQL has generated an error: ' . $ex->getMessage() . '<br>';
					return null;
				}
			}
			
		// MEMBEROFGROUP Table
		
			public function addMemberOfGroup($memberId, $groupId){
				try{
					$statement = $this->db->prepare('INSERT INTO MemberOfGroup(memberId, groupId) VALUES(' . $memberId . ', ' . $groupId . ')');
					$statement->execute();
					if ($statement->rowCount() > 0){
						return true;
					}
					else{
						return false;
					}
				}
				catch (PDOException $ex){
					echo 'MySQL has generated an error: ' . $ex->getMessage() . '<br>';
					return null;
				}
			}
			
			public function removeMemberOfGroup($memberId, $groupId){
				try{
					$statement = $this->db->prepare('DELETE FROM MemberOfGroup WHERE memberId = :memberId AND groupId = :groupId;');
					$statement->bindValue(':groupId', $groupId, PDO::PARAM_INT);
					$statement->bindValue(':memberId', $memberId, PDO::PARAM_INT);
					$statement->execute();
					if ($statement->rowCount() > 0){
						return true;
					}
					else{
						return false;
					}
				}
				catch (PDOException $ex){
					echo 'MySQL has generated an error: ' . $ex->getMessage() . '<br>';
					return null;
				}
			}
			
			public function getMembersOfGroup($groupId){
				try{
					$statement = $this->db->prepare('SELECT mg.memberId as memberId, mg.groupId AS groupId
					FROM MemberOfGroup mg JOIN Member m
					ON  mg.memberId = m.memberId
					WHERE mg.groupId = :groupId
					ORDER BY m.lastName;');
					$statement->bindValue(':groupId', $groupId, PDO::PARAM_INT);
					$statement->execute();
					if ($statement->rowCount() > 0){
						return $statement->fetchAll(PDO::FETCH_ASSOC);
					}
					else{
						return false;
					}
				}
				catch (PDOException $ex){
					echo 'MySQL has generated an error: ' . $ex->getMessage() . '<br>';
					return null;
				}
			}
			
			public function getGroupsOfMember($memberId){
				try{
					$statement = $this->db->prepare('SELECT mg.memberId as memberId, mg.groupId AS groupId
					FROM MemberOfGroup mg JOIN Groups g
					ON mg.groupId = g.groupId
					WHERE mg.memberId = :memberId
					ORDER BY g.groupName;');
					$statement->bindValue(':memberId', $memberId, PDO::PARAM_INT);
					$statement->execute();
					if ($statement->rowCount() > 0){
						return $statement->fetchAll(PDO::FETCH_ASSOC);
					}
					else{
						return false;
					}
				}
				catch (PDOException $ex){
					echo 'MySQL has generated an error: ' . $ex->getMessage() . '<br>';
					return null;
				}
			}
		
		// GROUPCONTENT Table
		
			public function postGroupContent($groupId,$permissionId,$currentPosterId,$previousPosterId,$originalPosterId,$contentType,$content){
				$newValue = 1;
				try{
					$statement = $this->db->prepare('SELECT count(*) as countValue, max(groupContentNumber) as maxValueTemp FROM GroupContent WHERE groupId = :groupId;');
					$statement->bindValue(':groupId', $groupId, PDO::PARAM_INT);
					$statement->execute();
					$row = $statement->fetch(PDO::FETCH_ASSOC);
					if ($row['countValue'] > 0){
						$newValue = $row['maxValueTemp'] + 1;
					}
				}
				catch (PDOException $ex){
					echo 'MySQL has generated an error: ' . $ex->getMessage() . '<br>';
					return null;
				}
				try{
					$statement = $this->db->prepare('INSERT INTO GroupContent(groupId, groupContentNumber, permissionId, currentPosterId, previousPosterId, originalPosterId, contentType, content)
					VALUES(:groupId, :groupContentNumber, :permissionId, :currentPosterId, :previousPosterId, :originalPosterId, :contentType, :content);');
					$statement->bindValue(':groupId', $groupId, PDO::PARAM_INT);
					$statement->bindValue(':groupContentNumber', $newValue, PDO::PARAM_INT);
					$statement->bindValue(':permissionId', $permissionId, PDO::PARAM_INT);
					$statement->bindValue(':currentPosterId', $currentPosterId, PDO::PARAM_INT);
					$statement->bindValue(':previousPosterId', $previousPosterId, PDO::PARAM_INT);
					$statement->bindValue(':originalPosterId', $originalPosterId, PDO::PARAM_INT);
					$statement->bindValue(':contentType', $contentType, PDO::PARAM_STR);
					$statement->bindValue(':content', $content, PDO::PARAM_STR);
					$statement->execute();
					if ($statement->rowCount() > 0){
						return true;
					}
					else{
						return false;
					}
				}
				catch (PDOException $ex){
					echo 'MySQL has generated an error: ' . $ex->getMessage() . '<br>';
					return null;
				}
			}
			
			public function deleteGroupContent($groupId, $groupContentNumber){
				try{
					$statement = $this->db->prepare('DELETE FROM GroupContent WHERE groupId = :groupId AND groupContentNumber = :groupContentNumber;');
					$statement->bindValue(':groupId', $groupId, PDO::PARAM_INT);
					$statement->bindValue(':groupContentNumber', $groupContentNumber, PDO::PARAM_INT);
					$statement->execute();
					if ($statement->rowCount() > 0){
						return true;
					}
					else{
						return false;
					}
				}
				catch (PDOException $ex){
					echo 'MySQL has generated an error: ' . $ex->getMessage() . '<br>';
					return null;
				}
			}
			
			public function getGroupContentInfo($groupId, $groupContentNumber){
				try{
					$statement = $this->db->prepare('SELECT groupId, groupContentNumber, permissionId, currentPosterId, previousPosterId, originalPosterId, contentType, content, timeStamp
					FROM GroupContent WHERE groupId = :groupId AND groupContentNumber = :groupContentNumber;');
					$statement->bindValue(':groupId', $groupId, PDO::PARAM_INT);
					$statement->bindValue(':groupContentNumber', $groupContentNumber, PDO::PARAM_INT);
					$statement->execute();
					if ($statement->rowCount() > 0){
						return $statement->fetch(PDO::FETCH_ASSOC);
					}
					else{
						return false;
					}
				}
				catch (PDOException $ex){
					echo 'MySQL has generated an error: ' . $ex->getMessage() . '<br>';
					return null;
				}
			}
			
			public function getGroupContents($groupId){
				try{
					$statement = $this->db->prepare('SELECT groupId,groupContentNumber,permissionId,currentPosterId,previousPosterId,originalPosterId,contentType,content,timeStamp
					FROM GroupContent WHERE groupId = :groupId ORDER BY timeStamp DESC;');
					$statement->bindValue(':groupId', $groupId, PDO::PARAM_INT);
					$statement->execute();
					if ($statement->rowCount() > 0){
						return $statement->fetchAll(PDO::FETCH_ASSOC);
					}
					else{
						return false;
					}
				}
				catch (PDOException $ex){
					echo 'MySQL has generated an error: ' . $ex->getMessage() . '<br>';
					return null;
				}
			}
		
		// GIFTEXCHANGE Table
		
			public function addGiftExchange($groupId, $giftExchangeName){
				$newValue = 1;
				try{
					$statement = $this->db->prepare('SELECT count(*) as countValue, max(giftExchangeNumber) as maxValueTemp FROM GiftExchange WHERE groupId = :groupId;');
					$statement->bindValue(':groupId', $groupId, PDO::PARAM_INT);
					$statement->execute();
					$row = $statement->fetch(PDO::FETCH_ASSOC);
					if ($row['countValue'] > 0){
						$newValue = $row['maxValueTemp'] + 1;
					}
				}
				catch (PDOException $ex){
					echo 'MySQL has generated an error: ' . $ex->getMessage() . '<br>';
					return null;
				}
				try{
					$statement = $this->db->prepare('INSERT INTO GiftExchange(groupId, giftExchangeNumber, giftExchangeName, status)
					VALUES(:groupId, :giftExchangeNumber, :giftExchangeName, "open");');
					$statement->bindValue(':groupId', $groupId, PDO::PARAM_INT);
					$statement->bindValue(':giftExchangeNumber', $newValue, PDO::PARAM_INT);
					$statement->bindValue(':giftExchangeName', $giftExchangeName, PDO::PARAM_INT);
					$statement->execute();
					if ($statement->rowCount() > 0){
						return true;
					}
					else{
						return false;
					}
				}
				catch (PDOException $ex){
					echo 'MySQL has generated an error: ' . $ex->getMessage() . '<br>';
					return null;
				}
			}
			
			public function deleteGiftExchange($groupId, $giftExchangeNumber){
				try{
					$statement = $this->db->prepare('DELETE FROM GiftExchange WHERE groupId = :groupId, AND giftExchangeNumber = :giftExchangeNumber;');
					$statement->bindValue(':groupId', $groupId, PDO::PARAM_INT);
					$statement->bindValue(':giftExchangeNumber', $giftExchangeNumber, PDO::PARAM_INT);
					$statement->execute();
					if ($statement->rowCount() > 0){
						return $statement->fetchAll(PDO::FETCH_ASSOC);
					}
					else{
						return false;
					}
				}
				catch (PDOException $ex){
					echo 'MySQL has generated an error: ' . $ex->getMessage() . '<br>';
					return null;
				}
			}
			
			public function closeGiftExchange($groupId, $giftExchangeNumber){
				try{
					$statement = $this->db->prepare('UPDATE GiftExchange SET status = "closed"
					WHERE groupId = :groupId AND giftExchangeNumber = :giftExchangeNumber;');
					$statement->bindValue(':groupId', $groupId, PDO::PARAM_INT);
					$statement->bindValue(':giftExchangeNumber', $giftExchangeNumber, PDO::PARAM_INT);
					$statement->execute();
				}
				catch (PDOException $ex){
					echo 'MySQL has generated an error: ' . $ex->getMessage() . '<br>';
					return null;
				}
				
				$retVal = $this->getGiftsInGiftExchange($groupId, $giftExchangeNumber);
				$giftTypeIds;
				for ($i = 0; $i < count($retVal)-1; $i++){
					$giftTypeIds[$i+1] = $retVal[$i]['giftTypeId'];
				}
				$giftTypeIds[0] = $retVal[count($retVal)-1]['giftTypeId'];
				
				$retVal = $this->getMembersOfGiftExchange($groupId, $giftExchangeNumber);
				$toIds;
				for ($i = 0; $i < count($retVal); $i++){
					$toIds[$i] = $retVal[$i]['memberId'];
				}
				$fromIds;
				for ($i = 0; $i < count($retVal)-1; $i++){
					$fromIds[$i+1] = $retVal[$i]['memberId'];
				}
				$fromIds[0] = $retVal[count($retVal)-1]['memberId'];
				
				for ($i = 0; $i < count($retVal); $i++){
					$this->sendGift($toIds[$i], $fromIds[$i], $giftTypeIds[$i]);
				}
				
				//$this->deleteGiftExchange($groupId, $giftExchangeNumber);
			}
			
			public function getGiftExchangeInfo($groupId, $giftExchangeNumber){
				try{
					$statement = $this->db->prepare('SELECT groupId, giftExchangeNumber, giftExchangeName, status FROM GiftExchange WHERE groupId = :groupId AND giftExchangeNumber = :giftExchangeNumber;');
					$statement->bindValue(':groupId', $groupId, PDO::PARAM_IN);
					$statement->bindValue(':giftExchangeNumber', $giftExchangeNumber, PDO::PARAM_INT);
					$statement->execute();
					if ($statement->rowCount() > 0){
						return $statement->fetch(PDO::FETCH_ASSOC);
					}
					else{
						return false;
					}
				}
				catch (PDOException $ex){
					echo 'MySQL has generated an error: ' . $ex->getMessage() . '<br>';
					return null;
				}
			}
			
			public function getGiftExchangesOfGroup($groupId){
				try{
					$statement = $this->db->prepare('SELECT groupId, giftExchangeNumber, giftExchangeName, status FROM GiftExchange
					WHERE groupId = :groupId AND status = "open";');
					$statement->bindValue(':groupId', $groupId, PDO::PARAM_INT);
					$statement->execute();
					if ($statement->rowCount() > 0){
						return $statement->fetchAll(PDO::FETCH_ASSOC);
					}
					else{
						return false;
					}
				}
				catch (PDOException $ex){
					echo 'MySQL has generated an error: ' . $ex->getMessage() . '<br>';
					return null;
				}
			}
		
		// MEMBEROFGIFTEXCHANGE Table
		
			public function addMemberOfGiftExchange($groupId, $giftExchangeNumber, $memberId){
				try{
					$statement = $this->db->prepare('INSERT INTO MemberOfGiftExchange(groupId, giftExchangeNumber, memberId)
					VALUES(:groupId, :giftExchangeNumber, :memberId);');
					$statement->bindValue(':groupId', $groupId, PDO::PARAM_INT);
					$statement->bindValue(':giftExchangeNumber', $giftExchangeNumber, PDO::PARAM_INT);
					$statement->bindValue(':memberId', $memberId, PDO::PARAM_INT);
					$statement->execute();
					if ($statement->rowCount() > 0){
						return true;
					}
					else{
						return false;
					}
				}
				catch (PDOException $ex){
					echo 'MySQL has generated an error: ' . $ex->getMessage() . '<br>';
					return null;
				}
			}
			
			public function addGiftToGiftExchange($groupId, $giftExchangeNumber, $memberId, $giftTypeId){
				try{
					$statement = $this->db->prepare('UPDATE MemberOfGiftExchange
					SET giftTypeId = :giftTypeId
					WHERE groupId = :groupId AND giftExchangeNumber = :giftExchangeNumber AND memberId = :memberId;');
					$statement->bindValue(':groupId', $groupId, PDO::PARAM_INT);
					$statement->bindValue(':giftExchangeNumber', $giftExchangeNumber, PDO::PARAM_INT);
					$statement->bindValue(':memberId', $memberId, PDO::PARAM_INT);
					$statement->bindValue(':giftTypeId', $giftTypeId, PDO::PARAM_INT);
					$statement->execute();
					if ($statement->rowCount() > 0){
						return true;
					}
					else{
						return false;
					}
				}
				catch (PDOException $ex){
					echo 'MySQL has generated an error: ' . $ex->getMessage() . '<br>';
					return null;
				}
			}
			
			public function getGiftsInGiftExchange($groupId, $giftExchangeNumber){
				try{
					$statement = $this->db->prepare('SELECT giftTypeId FROM MemberOfGiftExchange WHERE groupId = :groupId AND giftExchangeNumber = :giftExchangeNumber;');
					$statement->bindValue(':groupId', $groupId, PDO::PARAM_INT);
					$statement->bindValue(':giftExchangeNumber', $giftExchangeNumber, PDO::PARAM_INT);
					$statement->execute();
					if ($statement->rowCount() > 0){
						return $statement->fetchAll(PDO::FETCH_ASSOC);
					}
					else{
						return false;
					}
				}
				catch (PDOException $ex){
					echo 'MySQL has generated an error: ' . $ex->getMessage() . '<br>';
					return null;
				}
			}
			
			public function getMembersOfGiftExchange($groupId, $giftExchangeNumber){
				try{
					$statement = $this->db->prepare('SELECT memberId FROM MemberOfGiftExchange WHERE groupId = :groupId AND giftExchangeNumber = :giftExchangeNumber;');
					$statement->bindValue(':groupId', $groupId, PDO::PARAM_INT);
					$statement->bindValue(':giftExchangeNumber', $giftExchangeNumber, PDO::PARAM_INT);
					$statement->execute();
					if ($statement->rowCount() > 0){
						return $statement->fetchAll(PDO::FETCH_ASSOC);
					}
					else{
						return false;
					}
				}
				catch (PDOException $ex){
					echo 'MySQL has generated an error: ' . $ex->getMessage() . '<br>';
					return null;
				}
			}
			
			public function getGiftExchangesOfMember($memberId){
				try{
					$statement = $this->db->prepare('SELECT mge.groupId as groupId, mge.giftExchangeNumber as giftExchangeNumber
					FROM MemberOfGiftExchange mge JOIN GiftExchange ge
					WHERE mge.groupId = ge.groupId AND mge.giftExchangeNumber = ge.giftExchangeNumber
					AND mge.memberId = :memberId AND ge.status = "open";');
					$statement->bindValue(':memberId', $memberId, PDO::PARAM_INT);
					$statement->execute();
					if ($statement->rowCount() > 0){
						return $statement->fetchAll(PDO::FETCH_ASSOC);
					}
					else{
						return false;
					}
				}
				catch (PDOException $ex){
					echo 'MySQL has generated an error: ' . $ex->getMessage() . '<br>';
					return null;
				}
			}
			
		//OTHER FEATURES
		
			public function searchString($searchingMember/*The member doing the searching*/, $input){
				try{
                    
					$input1 = "%" . $input . "%";
					$input2 = "%" . $input . "%";
					$input3 = "%" . $input . "%";
					
					$statement1 = $this->db->prepare('SELECT memberId, firstName, lastName FROM Member WHERE (firstName LIKE :input1 OR lastName LIKE :input2)
					AND memberId != :searchingMember AND NOT EXISTS (SELECT * FROM Blocked WHERE blockerId = memberId AND blockedId = :searchingMember)
					AND memberId NOT IN (SELECT memberId FROM Member WHERE status = "inactive" OR status = "suspended");');
					$statement1->bindValue(':input1', $input1, PDO::PARAM_STR);
					$statement1->bindValue(':input2', $input2, PDO::PARAM_STR);
					$statement1->bindValue(':searchingMember', $searchingMember, PDO::PARAM_INT);
					$statement1->execute();
					
					$statement2 = $this->db->prepare('SELECT groupId, groupName FROM Groups WHERE groupName LIKE :input3;');
					$statement2->bindValue(':input3', $input3);
					$statement2->execute();
					
					if($statement1->rowCount() > 0 || $statement2->rowCount() > 0){
						return array($statement1->fetchAll(PDO::FETCH_ASSOC), $statement2->fetchAll(PDO::FETCH_ASSOC));
					}
					else{
						return false;
					}
				}
				catch (PDOException $ex){
					echo 'MySQL has generated an error: ' . $ex->getMessage() . '<br>';
					return null;
				}
			}
	}

?>
