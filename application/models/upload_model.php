<?php
require_once APPPATH.'models/core_model.php';
class upload_model extends core_model {
	
	private $db2;

	public function __construct()
	{
		parent::__construct();
	}

	public function do_upload($memberId, $fileContentType)
	{
		$output_dir = "D:\\xampp\\htdocs\\Flubber_Ci\\assets\\content\\";
		if(isset($_FILES["file"]))
		{
			$error =$_FILES["file"]["error"];
			if(!is_array($_FILES["file"]["name"])) //Only accept single file
			{
				$ext = explode(".", $_FILES["file"]["name"]);
				$extSize = count($ext);
				$ext = $ext[$extSize-1];
				$fileName = uniqid($memberId .'-') .'.' .$ext; 
				if(move_uploaded_file($_FILES["file"]["tmp_name"], $output_dir.$memberId.'-'.$fileContentType.'-'.$fileName))
					$fileURL = base_url() ."assets/content/".$memberId.'-'.$fileContentType.'-'.$fileName;
				else
					$fileURL = $error;
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