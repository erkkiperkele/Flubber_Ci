<?php

class upload extends FL_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('upload_model');
		$this->load->helper('url');
	}

	public function file($ContentType, $id)
	{
		$response = false;
		if($id != $this->session->userdata('memberId') && $ContentType != 'addContentBox' )
			die();
		$fileURL = $this->upload_model->do_upload($id, $ContentType);
		$ext = explode(".", $fileURL);
		$sizeOfExt = count($ext);
		$ext = strtolower($ext[$sizeOfExt-1]);
		if(isset($fileURL)){
			if($ext == "jpg" || $ext == "gif" || $ext == "png"){
				if($ContentType === "profile-pic" || $ContentType === "profile-name"){
					if($ContentType === "profile-pic")
						$ContentType = "photograph";
					else if($ContentType === "profile-name")
						$ContentType = "coverPicture";
					$response = $this->upload_model->updateProfileURLinDB($id, $fileURL, $ContentType);
					if($response == true && $ContentType === "photograph" && $id == $this->session->userdata('memberId')){
						$thumbURL = $this->upload_model->createThumbnail($fileURL);
						$response = $this->upload_model->updateThumbnailURLinDB($id, $thumbURL);
					}
				} else if ($ContentType === "group-pic" || $ContentType === "group-name"){
					if($ContentType === "group-pic" && ($ext == "jpg" || $ext == "gif" || $ext == "png"))
						$ContentType = "photograph";
					else if($ContentType === "group-name" && ($ext == "jpg" || $ext == "gif" || $ext == "png"))
						$ContentType = "coverPicture";
					$response = $this->upload_model->updateGroupURLinDB($id, $fileURL, $ContentType);
				}
			}
			if($response === true)
			{
				$user = $this->session->all_userdata();
				if($ContentType == "photograph"){
					$user['photographURL'] = $fileURL;
					$user['thumbnailURL'] = $fileURL;
				}
				else if($ContentType == "coverPicture")
					$user['coverPictureURL'] = $fileURL;
				$this->session->set_userdata( $user );
				$result = array($id, $fileURL);
				echo json_encode($result);
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
				echo json_encode(array($id, $fileURL));
				die();

			}
		}		
	}
}