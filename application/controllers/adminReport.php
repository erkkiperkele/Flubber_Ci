<?php

require_once APPPATH.'core/FL_Controller.php';
class adminReport extends FL_Controller {
	
	private $admin;

	public function __construct()
	{
		parent::__construct();
		$this->load->model('admin_model');
		$this->load->helper('form');
	}

	public function index()
	{
		//initialize
		
		$admin = $this->session->userdata('memberId');
		$data['currentPage'] = 'Reports';
		//Report Lists as (Type => String , Count => int)
		$data['interestList'] = $this->admin_model->getInterests(); 
		
		$data['ageList'] = $this->admin_model->getAges();
		$data['ageGroups'] = $this->groupByAge( 10 , 90 , $data['ageList']);
		$data['ageGroups'] = $this->modifyArray($data['ageGroups']);
		
		$data['cityList'] = $this->admin_model->getCities();
		$data['countryList'] = $this->admin_model->getCountries();
		$data['professionList'] = $this->admin_model->getProfessions();
		
		//Needed for header?
		$data['title'] = "Admin" . "Reports";
		$data['member'] = $this->member;
		$data['groupList'] = $this->groupList;
		$data['newRequestNb'] = 0;
		$data['newMessageNb'] = 0;
		//end need
		
		//TESTING
		$data['test'] = array([ [1 , 1] , [2 , 2] , [3 , 3] ]);
		
		//Age grouping
		
		$this->render('pages/adminReport', $data);
	}
	
	public function groupByAge($interval, $max, $ageList)
	{
		$groupedAges = array();
		
		for( $i = 0 ; $i < $max + $interval; $i += $interval)
		{
			$groupedAges[$i] = 0;
			foreach ($ageList as $age => $count)
			{
				if($age >= $i && $age < $i + $interval)
				{
					$groupedAges[$i] += $count;
				}
				else if($age > $i + $interval)
				{
					break;
				}
			}
		}
		return $groupedAges;
	}

	//Changes an array from array(key => value) to array( array(key,value))
	public function modifyArray($targetArray)
	{
		$finalArray = array();
		
		foreach($targetArray as $key => $value)
		{
			$finalArray[] = array($key , $value);
		}
		
		return $finalArray;
	}

	public function generateReport()
	{
		$chosen = $this->input->post('Options');
		echo $chosen;
	}
	
	
	
}