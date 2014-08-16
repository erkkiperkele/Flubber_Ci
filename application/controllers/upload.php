<?php
require_once APPPATH.'controllers/core.php';
class upload extends core {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('upload_model');
		$this->load->helper('url');
	}

	public function file($ContentType)
	{
		$response = false;
		$fileURL = $this->upload_model->do_upload($this->session->userdata('memberId'), $ContentType);
		$ext = explode(".", $fileURL);
		$sizeOfExt = count($ext);
		$ext = strtolower($ext[$sizeOfExt-1]);
		if(isset($fileURL)){
			if($ContentType === "profile-pic" && ($ext == "jpg" || $ext == "gif" || $ext == "png"))
				$ContentType = "photograph";
			else if($ContentType === "profile-name" && ($ext == "jpg" || $ext == "gif" || $ext == "png"))
				$ContentType = "coverPicture";
			$response = $this->upload_model->updateURLinDB($this->session->userdata('memberId'), $fileURL, $ContentType);
			if($response === true)
			{
				$user = $this->session->all_userdata();
				if($ContentType == "photograph")
					$user['photographURL'] = $fileURL;
				else if($ContentType == "coverPicture")
					$user['coverPictureURL'] = $fileURL;
				$this->session->set_userdata( $user );
				echo $fileURL;
				die();
			}
			if($ContentType === "addContentBox")
			{
				$ContentType = "coverPicture";
				if( $ext != "jpg" && $ext != "gif" && $ext != "png" && $ext != "mp4")
				{
					//unlink($fileURL); //Delete the file! It's not what we like to keep on our server!
					die(); 
				}
				echo $fileURL;
				die();

			}
		}		
	}
}