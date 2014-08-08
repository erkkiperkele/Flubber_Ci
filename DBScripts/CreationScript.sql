/* Drop events/trigger if they already exist */

drop event if exists incrementHearts;

/* Drop tables if they already exist */

drop table if exists MemberOfGiftExchange;
drop table if exists MemberOfGroup;
drop table if exists Related;
drop table if exists Message;
drop table if exists Request;
drop table if exists Blocked;

drop table if exists GiftExchange;
drop table if exists GroupContent;
drop table if exists Groups;

drop table if exists PublicContent;

drop table if exists Interest;
drop table if exists Comment;
drop table if exists WallContent;
drop table if exists Gift;

drop table if exists GiftType;

drop table if exists Permission;

drop table if exists InterestType;
drop table if exists RelationshipType;
drop table if exists Member;

/* Re-create the tables anew */

CREATE TABLE Member (
	memberId INT AUTO_INCREMENT,
	firstName VARCHAR(35) NOT NULL,
	lastName VARCHAR(35) NOT NULL,
	email VARCHAR(50) NOT NULL UNIQUE,
	hashedPassword VARCHAR(255) NOT NULL,
	profession VARCHAR(30),
	address VARCHAR(40),
	city VARCHAR(20),
	country VARCHAR(20),
	photographURL NVARCHAR(255),
	coverPictureURL NVARCHAR(255),
	thumbnailURL NVARCHAR(255),
	hearts INT NOT NULL,
	dateOfBirth DATE NOT NULL,
	privacy VARCHAR(7) NOT NULL,
	privilege VARCHAR(13) NOT NULL,
	status VARCHAR(9) NOT NULL DEFAULT 'active',
	PRIMARY KEY(memberId),
	CONSTRAINT heartsPositive CHECK (hearts >= 0)
);

CREATE TABLE RelationshipType(
	relationshipTypeId INT AUTO_INCREMENT,
	description VARCHAR(20) UNIQUE NOT NULL,
	PRIMARY KEY(relationshipTypeId)
);

CREATE TABLE InterestType(
	interestTypeId INT AUTO_INCREMENT,
	description VARCHAR(20) UNIQUE NOT NULL,
	PRIMARY KEY(interestTypeId)
);

CREATE TABLE Permission(
	permissionId INT AUTO_INCREMENT,
	description VARCHAR(7) UNIQUE NOT NULL,
	PRIMARY KEY(permissionId)
);

CREATE TABLE GiftType(
	giftTypeId INT AUTO_INCREMENT,
	description VARCHAR(20) UNIQUE NOT NULL,
	photographURL VARCHAR(20),
	cost INT NOT NULL,
	PRIMARY KEY(giftTypeId),
	CONSTRAINT costPositive CHECK (cost > 0)
);

CREATE TABLE Gift(
	sentTo INT,
	sentFrom INT,
	giftNumber INT,
	giftTypeId INT,
	timeStamp TIMESTAMP NOT NULL default CURRENT_TIMESTAMP,
	PRIMARY KEY(sentTo, sentFrom, giftNumber),
	FOREIGN KEY(sentTo) REFERENCES Member(memberId) ON DELETE CASCADE,
	FOREIGN KEY(sentFrom) REFERENCES Member(memberId) ON DELETE CASCADE,
	FOREIGN KEY(giftTypeId) REFERENCES GiftType(giftTypeId) ON DELETE CASCADE
);

CREATE TABLE WallContent(
	memberId INT,
	wallContentNumber INT,
	permissionId INT NOT NULL,
	currentPosterId INT,
	previousPosterId INT,
	originalPosterId INT,
	contentType VARCHAR(15),
	content VARCHAR(255),
	timeStamp TIMESTAMP NOT NULL default CURRENT_TIMESTAMP,
	PRIMARY KEY(memberId, wallContentNumber),
	FOREIGN KEY(permissionId) REFERENCES Permission(permissionId),
	FOREIGN KEY(memberId) REFERENCES Member(memberId) ON DELETE CASCADE,
	FOREIGN KEY(currentPosterId) REFERENCES Member(memberId) ON DELETE SET NULL,
	FOREIGN KEY(previousPosterId) REFERENCES Member(memberId) ON DELETE SET NULL,
	FOREIGN KEY(originalPosterId) REFERENCES Member(memberId) ON DELETE SET NULL
);

CREATE TABLE Comment(
	memberId INT,
	wallContentNumber INT,
	commentNumber INT,
	commenterId INT,
	content VARCHAR(255),
	timeStamp TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
	PRIMARY KEY(memberId, wallContentNumber, commentNumber),
	FOREIGN KEY(commenterId) REFERENCES Member(memberId) ON DELETE SET NULL,
	FOREIGN KEY(memberId, wallContentNumber) REFERENCES WallContent(memberId, wallContentNumber) ON DELETE CASCADE
);

CREATE TABLE Interest(
	memberId INT,
	interestNumber INT,
	interestTypeId INT,
	title VARCHAR(35),
	artist VARCHAR(35),
	PRIMARY KEY(memberId, interestNumber),
	FOREIGN KEY(memberId) REFERENCES Member(memberId) ON DELETE CASCADE,
	FOREIGN KEY(interestTypeId) REFERENCES InterestType(interestTypeId)
);

CREATE TABLE PublicContent(
	memberId INT,
	publicContentNumber INT,
	contentType VARCHAR(15),
	content VARCHAR(255),
	timeStamp TIMESTAMP NOT NULL default CURRENT_TIMESTAMP,
	PRIMARY KEY(memberId, publicContentNumber),
	FOREIGN KEY(memberId) REFERENCES Member(memberId) ON DELETE CASCADE
);

CREATE TABLE Groups(
	groupId INT AUTO_INCREMENT,
	groupName VARCHAR(35) UNIQUE NOT NULL,
	ownerId INT NOT NULL,
	description VARCHAR(255),
	photographURL NVARCHAR(255),
	coverPictureURL NVARCHAR(255),
	thumbnailURL NVARCHAR(255),
	timeStamp TIMESTAMP NOT NULL default CURRENT_TIMESTAMP,
	PRIMARY KEY(groupId),
	FOREIGN KEY(ownerId) REFERENCES Member(memberId) ON DELETE CASCADE
);

CREATE TABLE GroupContent(
	groupId INT,
	groupContentNumber INT,
	permissionId INT NOT NULL,
	currentPosterId INT NOT NULL,
	previousPosterId INT,
	originalPosterId INT,
	contentType VARCHAR(15),
	content VARCHAR(255),
	timeStamp TIMESTAMP NOT NULL default CURRENT_TIMESTAMP,
	PRIMARY KEY(groupId, groupContentNumber),
	FOREIGN KEY(groupId) REFERENCES Groups(groupId) ON DELETE CASCADE,
	FOREIGN KEY(permissionId) REFERENCES Permission(permissionId),
	FOREIGN KEY(currentPosterId) REFERENCES Member(memberId) ON DELETE CASCADE,
	FOREIGN KEY(previousPosterId) REFERENCES Member(memberId) ON DELETE SET NULL,
	FOREIGN KEY(originalPosterId) REFERENCES Member(memberId) ON DELETE SET NULL
);

CREATE TABLE GiftExchange(
	groupId INT,
	giftExchangeNumber INT,
	giftExchangeName VARCHAR(35) NOT NULL,
	status VARCHAR(6),
	timeStamp TIMESTAMP NOT NULL default CURRENT_TIMESTAMP,
	PRIMARY KEY(groupId, giftExchangeNumber),
	FOREIGN KEY(groupId) REFERENCES Groups(groupId) ON DELETE CASCADE
);

CREATE TABLE Blocked(
	blockerId INT,
	blockedId INT,
	PRIMARY KEY(blockerId, blockedId),
	FOREIGN KEY(blockerId) REFERENCES Member(memberId) ON DELETE CASCADE,
	FOREIGN KEY(blockedId) REFERENCES Member(memberId) ON DELETE CASCADE
);

CREATE TABLE Request(
	sentTo INT,
	sentFrom INT,
	requestNumber INT,
	isRead BOOL NOT NULL DEFAULT FALSE,
	title VARCHAR(55),
	requestType VARCHAR(15),
	content VARCHAR(255),
	timeStamp TIMESTAMP NOT NULL default CURRENT_TIMESTAMP,
	PRIMARY KEY(sentTo, sentFrom, requestNumber),
	FOREIGN KEY(sentTo) REFERENCES Member(memberId) ON DELETE CASCADE,
	FOREIGN KEY(sentFrom) REFERENCES Member(memberId) ON DELETE CASCADE
);

CREATE TABLE Message(
	sentTo INT,
	sentFrom INT,
	messageNumber INT,
	isRead BOOL NOT NULL DEFAULT FALSE,
	title VARCHAR(55),
	content VARCHAR(255),
	timeStamp TIMESTAMP NOT NULL default CURRENT_TIMESTAMP,
	PRIMARY KEY(sentTo, sentFrom, messageNumber),
	FOREIGN KEY(sentTo) REFERENCES Member(memberId) ON DELETE CASCADE,
	FOREIGN KEY(sentFrom) REFERENCES Member(memberId) ON DELETE CASCADE
);

CREATE TABLE Related(
	memberId INT NOT NULL,
	relatedId INT NOT NULL,
	relationshipTypeId INT NOT NULL,
	timeStamp TIMESTAMP NOT NULL default CURRENT_TIMESTAMP,
	PRIMARY KEY(memberId, relatedId),
	FOREIGN KEY(memberId) REFERENCES Member(memberId) ON DELETE CASCADE,
	FOREIGN KEY(relatedId) REFERENCES Member(memberId) ON DELETE CASCADE,
	FOREIGN KEY(relationshipTypeId) REFERENCES RelationshipType(relationshipTypeId) ON DELETE CASCADE
);

CREATE TABLE MemberOfGroup(
	memberId INT,
	groupId INT,
	timeStamp TIMESTAMP NOT NULL default CURRENT_TIMESTAMP,
	PRIMARY KEY(memberId, groupId),
	FOREIGN KEY(memberId) REFERENCES Member(memberId),
	FOREIGN KEY(groupId) REFERENCES Groups(groupId)
);

CREATE TABLE MemberOfGiftExchange(
	groupId INT,
	giftExchangeNumber INT,
	memberId INT,
	giftTypeId INT,
	PRIMARY KEY(groupId, giftExchangeNumber, memberId),
	FOREIGN KEY(groupId, giftExchangeNumber) REFERENCES GiftExchange(groupId, giftExchangeNumber) ON DELETE CASCADE,
	FOREIGN KEY(memberId) REFERENCES Member(memberId) ON DELETE CASCADE,
	FOREIGN KEY(giftTypeId) REFERENCES GiftType(giftTypeId)
);

/* Add events and triggers */

CREATE EVENT incrementHearts
ON SCHEDULE EVERY 1 DAY
DO UPDATE Member SET hearts = hearts + 100;

/* Add data members */

INSERT INTO Permission(description)
VALUES ('view'), ('comment'), ('link');

INSERT INTO GiftType(description, photographURL, cost)
VALUES ('Palm Tree', NULL, 10), ('Chocolate Cake', NULL, 15), ('Kitten', NULL, 35), ('Pony', NULL, 150);

INSERT INTO RelationshipType(description)
VALUES ('Family'), ('Friend'), ('Colleague');

INSERT INTO InterestType(description)
VALUES ('Music'), ('Movies'), ('Books'), ('Paintings');