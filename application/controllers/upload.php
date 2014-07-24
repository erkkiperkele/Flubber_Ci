<?php
class upload extends FL_Controller {

	private $memberId = 1;
	public function __construct()
	{
		parent::__construct();
		$this->load->model('upload_model');
		$this->load->helper('url');
	}

	public function file($ContentType)
	{
		$response = false;
		if($ContentType === "profile-pic")
			$ContentType = "photograph";
		else
			$ContentType = "coverPicture";
		$fileURL = $this->upload_model->do_upload($this->memberId, $ContentType);
		if(isset($fileURL))
			$response = $this->upload_model->updateURLinDB($this->memberId, $fileURL, $ContentType);
		if($response === true)
			echo $fileURL;
	}

}