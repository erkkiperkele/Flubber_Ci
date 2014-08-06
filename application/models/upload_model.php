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
				$fileURL = base_url() ."assets/imgs/".$memberId.'-'.$fileContentType.'-'.$fileName;
			}
			return $fileURL;
		}
	}

    public function updateURLinDB($memberId, $fileURL, $fileContentType)
    {
        if($fileContentType === 'photograph')
        {
        	$photoUpdate = $this->db2->setPhotographURLOfMember($memberId, $fileURL);
			//$thumbCreated = createThumbnail($fileURL);

			return ($photoUpdate /*&& $thumbCreated*/);
        	
        }
        if($fileContentType === 'coverPicture')
        {
        	return $this->db2->setCoverPictureURLOfMember($memberId, $fileURL);
        }
        return false;
    }
	
	public function createThumbnail($fileURL)
	{
		$config['image_library'] = 'gd2';
		$config['source_image']	= $fileURL;
		$config['create_thumb'] = TRUE;
		$config['maintain_ratio'] = TRUE;
		$config['width']	= 100;
		$config['height']	= 100;

		$thumb = explode('.', $fileURL);
		$i = 0;
		while($i + 1 < count($thumb)){
			$thumbURL .= $thumb[$i];
			$i++;
		}
		$thumbURL .= '_thumb.' .$thumb[$i];

		$config['new_image']	= $thumbURL;
		$this->load->library('image_lib', $config); 
		if($this->image_lib->resize())
			$thumbUpdate = $this->db2->setThumbnailURLOfMember($memberId, $thumbURL);
		if($thumbUpdate == false)
			return $this->image_lib->display_errors();

		return $thumbUpdate;
	}
}