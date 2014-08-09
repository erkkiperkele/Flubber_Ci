Flubber_Ci
==========

- Basic files not to check-in have been added to the gitignore file (config.php and database.php)
- Login and registration system is now fully operational and complete.
- Uploading is now fully operational and complete.
- In order to access the logged-in member's data, use "$this->session->userdata('value');" where value is the field in the member table.
- If uploading is not working, it's probably because of two reasons:
	1. upload_model has a hard coded path which may not be correct on your system
	2. You are uploading files that are too big. Try checking your php.ini variables upload_max_filesize and post_max_size
- Feel free to add some more if I forgot some (some other machine specific configuration files)

