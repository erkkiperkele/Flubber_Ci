<?php

include "DatabaseAccessObject.php";

class upload_model extends CI_Model {
	
	private $db2;

	public function __construct()
	{
		parent::__construct();
		$this->load->database();
		#$this->load->helper('fl_DatabaseAccessObject');
		
		#REFACTOR: Call the variables from the config file instead of hardcoded
		$this->db2 = new DatabaseAccessObject('127.0.0.1', 'flubber.database', 'root', '');
	}

	public function do_upload($memberId, $fileContentType)
	{
		$output_dir = "D:\\xampp\\htdocs\\Flubber_Ci\\assets\\imgs\\";
		if(isset($_FILES["file"]))
		{
			$error =$_FILES["file"]["error"];
			if(!is_array($_FILES["file"]["name"])) //Only accept single file
			{
				$fileName = $_FILES["file"]["name"];
				move_uploaded_file($_FILES["file"]["tmp_name"], $output_dir.$memberId.'-'.$fileContentType.'-'.$fileName);
				$fileURL = "http://127.0.0.1:81/Flubber_Ci/assets/imgs/".$memberId.'-'.$fileContentType.'-'.$fileName;
			}
			return $fileURL;
		}
	}

    public function updateURLinDB($memberId, $fileURL, $fileContentType)
    {
        if($fileContentType === 'photograph')
        {
        	$this->db2->setPhotographURLOfMember($memberId, $fileURL);
        	return true;
        }
        if($fileContentType === 'coverPicture')
        {
        	$this->db2->setCoverPictureURLOfMember($memberId, $fileURL);
        	return true;
        }
        return false;
    }
	
	
}