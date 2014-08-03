select * from PublicContent;
select * from Member;
select * from wallContent;

INSERT into Member
	(memberId, firstName, LastName, Email, hashedPassword, profession, hearts, DateOfBirth, privacy, privilege, status, photographURL, coverPictureURL, thumbnailURL)
	VALUES 
	-- (0, 'admin', 'flubber', 'admin@flubber.com', 'admin', 'dev', 0, CURRENT_TIMESTAMP, 1, 1, 1, NULL, NULL, NULL),
	(1, 'Aymeric', 'Grail', 'aymeric@grail.com', '$5$abcdefghijkl1234$52g569THIHtPeh1FpwlWt2iDxiWjwGlAGCYgcKTJo7B', 'dev', 0, CURRENT_TIMESTAMP, 1, 1, 1, 'https://fbcdn-profile-a.akamaihd.net/hprofile-ak-xfa1/t1.0-1/c51.0.160.160/p160x160/1800265_10151856373511364_1778780040_n.jpg','https://scontent-a-lga.xx.fbcdn.net/hphotos-xaf1/t31.0-8/c0.254.851.315/p851x315/1782352_10151860443466364_254764027_o.jpg','https://fbcdn-profile-a.akamaihd.net/hprofile-ak-xfa1/t1.0-1/c16.0.50.50/p50x50/1800265_10151856373511364_1778780040_n.jpg'), 
	(2, 'Sohail', 'Hooda', 'sohail@hooda.com', '$5$abcdefghijkl1234$0ctsrGPBcIj/eDg9s71QNirfJmjM0ir5nVwjbM43WG8', 'dev', 0, CURRENT_TIMESTAMP, 1, 1, 1, 'https://fbcdn-profile-a.akamaihd.net/hprofile-ak-xfa1/t1.0-1/c37.37.466.466/s160x160/262882_10150259758063171_5182177_n.jpg','https://lh6.googleusercontent.com/-5vG8ole8nAI/UYFKqb0Y7YI/AAAAAAAABiA/YQzKopOzN1g/w1600-h900/default_cover_1_c07bbaef481e775be41b71cecbb5cd60.jpg','https://fbcdn-profile-a.akamaihd.net/hprofile-ak-xfa1/t1.0-1/c4.4.48.48/p56x56/262882_10150259758063171_5182177_n.jpg');

INSERT into PublicContent 
	(memberId, publicContentNumber, contentType, content, `timeStamp`)
	VALUES
	(1, 1, 1, 'my first content', CURRENT_TIMESTAMP), 
	(2, 2, 1, 'Sohail first content', CURRENT_TIMESTAMP);


INSERT into WallContent 
	(memberId, wallContentNumber, permissionId, currentPosterId, previousPosterId, originalPosterID, contentType, content, `timeStamp`)
	VALUES
	 (1, 2, 1, 2, 2, 2, 1, 'Sohail first post on Aymeric\'s wall', '2014-07-10 12:39:41')
	,(1, 1, 1, 1, 1, 1, 1, 'my first wall content', '2014-07-11 12:39:41')
	,(2, 3, 1, 1, 1, 1, 1, 'Sohail first wall content', '2014-07-12 16:55:19')
	,(1, 4, 1, 2, 2, 2, 1, 'Sohail second post on Aymeric\'s wall', '2014-07-13 16:55:19')
	,(1, 5, 1, 2, 2, 2, 1, 'Sohail 3rd post on Aymeric\'s wall', '2014-07-12 14:55:19')
	,(1, 6, 1, 2, 2, 2, 1, 'Sohail 4th post on Aymeric\'s wall', '2014-07-12 15:55:19')
	,(1, 7, 1, 2, 2, 2, 1, 'Sohail 5th post on Aymeric\'s wall', '2014-07-12 16:55:19')
	,(1, 8, 1, 2, 2, 2, 1, 'Sohail 6th post on Aymeric\'s wall', '2014-07-12 11:55:19')
	,(1, 9, 1, 1, 1, 1, 1, 'my 2nd wall content', '2014-07-12 16:55:19')
	,(1, 10, 1, 1, 1, 1, 1, 'my 3rd wall content', '2014-07-13 16:55:19')
	;


INSERT into Interest
	(memberId, interestNumber, InterestTypeId, title, artist)
	VALUES
	(1, 1, 1, 'Nevermind', 'Nirvana'),
	(1, 2, 2, 'Fight Club', 'David Fincher'),
	(1, 3, 3, 'The hitchikers guide to the galaxy', 'Douglas Adams'),
	(1, 4, 4, 'Bercement silencieux', 'Paul-Émile Borduas'),

	(1, 5, 1, 'Modern Rhapsodies', 'Maxence Cyrin'),
	(1, 6, 2, 'Django', 'Tarantino'),
	(1, 7, 3, 'Le petit prince', 'St-Exupéry'),
	(1, 8, 4, 'Guernica', 'Picasso');

	
INSERT into Related
	(memberId, relatedId, relationshipTypeId)
	VALUES
	(1, 2, 2),
	(2, 1, 2);
	
INSERT into Groups
	(groupId, groupName, ownerId, description)
	VALUES
	(1, 'COMP5311G4', 1, 'Files and databases'),
	(2, 'Book club 42', 1, 'Follow the thumb...'),
	(3, 'Weird MS bugs', 2, 'Found yet another ineffable loophole in the great MS product? That is marked as treated even though you know it''s a lie? Share you stories here.'),
	(4, 'Montreal Photo Society', 1, 'Challenge of the month: go to a metro station you have never been before and take the picture of the strangest thing in the area.')

	
