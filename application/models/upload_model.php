<?php
require_once APPPATH.'models/flubber_model.php';
class upload_model extends flubber_model {

	private $output_dir;

	public function __construct()
	{
		parent::__construct();
		$this->output_dir = "D:\\xampp\\htdocs\\Flubber_Ci\\assets\\content\\";	}

	public function do_upload($id, $fileContentType)
	{
		if(isset($_FILES["file"]))
		{
			$error =$_FILES["file"]["error"];
			if(!is_array($_FILES["file"]["name"])) //Only accept single file
			{
				$ext = explode(".", $_FILES["file"]["name"]);
				$extSize = count($ext);
				$ext = $ext[$extSize-1];
				$fileName = uniqid($id .'-') .'.' .$ext; 
				if(move_uploaded_file($_FILES["file"]["tmp_name"], $this->output_dir.$id.'-'.$fileContentType.'-'.$fileName))
					$fileURL = base_url() ."assets/content/".$id.'-'.$fileContentType.'-'.$fileName;
				else
					$fileURL = $error;
			}
			return $fileURL;
		}
	}

    public function updateProfileURLinDB($memberId, $fileURL, $fileContentType)
    {
        if($fileContentType === 'photograph')
        {
        	return $this->db2->setPhotographURLOfMember($memberId, $fileURL);        	
        }
        if($fileContentType === 'coverPicture')
        {
        	return $this->db2->setCoverPictureURLOfMember($memberId, $fileURL);
        }
        return false;
    }

    public function updateGroupURLinDB($groupId, $fileURL, $fileContentType)
    {
        if($fileContentType === 'photograph')
        {					//REPLACE THIS FUNCTION WITH FUNCTION FOR GROUPS
        	$photoUpdate = $this->db2->setPhotographURLOfGroup($groupId, $fileURL);

			return ($photoUpdate);
        	
        }
        if($fileContentType === 'coverPicture')
        {			//REPLACE THIS FUNCTION WITH FUNCTION FOR GROUPS
        	return $this->db2->setCoverPictureURLOfGroup($groupId, $fileURL);
        }
        return false;
    }
	
	public function createThumbnail($fileURL)
	{
		$thumbUpdate = false;

		$config['image_library'] = 'gd2';
		$config['create_thumb'] = TRUE;
		$config['maintain_ratio'] = TRUE;
		$config['width']	= 100;
		$config['height']	= 100;

		$image = explode('/', $fileURL);
		$imageFile = $this->output_dir .$image[count($image)-1];
		$thumb = explode('.', $fileURL);
		$thumbURL = "";
		$thumb[count($thumb) - 2] .= "_thumb";
		$thumbURL .= implode('.', $thumb);	
		$thumb = explode('/', $thumbURL);
		$thumbFile = "";
		$thumbFile .= $this->output_dir .$thumb[count($thumb)-1];
		$config['source_image']	= $imageFile;
		$config['new_image']	= $thumbFile;
		$config['thumb_marker'] = "";
		$this->load->library('image_lib', $config); 
		if($this->image_lib->resize())
			return $thumbURL;
	}
	public function updateThumbnailURLinDB($memberId, $thumbURL)
	{
		return $this->db2->setThumbnailURLOfMember($memberId, $thumbURL);
	}
}