Flubber_Ci
==========

- Basic files not to check-in have been added to the gitignore file (config.php and database.php)
- Login system is now operational. So is the registration page (however it doesn't check for existing users in the system yet, so go nuts! :D )
- In order to access the logged-in member's data, use "$this->session->userdata('value');" where value is the field in the member table.
- Feel free to add some more if I forgot some (some other machine specific configuration files)

