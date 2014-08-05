Flubber_Ci
==========

- Basic files not to check-in have been added to the gitignore file (config.php and database.php)
- Login system is now operational. You need to login to get to a page now. If you'd like to create a special login use crypt and get the salt before you add it to the database. If you don't know what that is, execute the code: "crypt($password, '$5$abcdefghijkl1234')" in php where $password is your password. At the moment there are 2 default logins:
		aymeric@grail.com, 11
		sohail@hooda.com, 22
- In order to access the logged-in member's data, use "$this->session->userdata('value');" where value is the field in the member table.
- Feel free to add some more if I forgot some (some other machine specific configuration files)

