<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class History extends CI_Controller {

	//dynamic response
	public function response($data, $status = 200){
		$this->output
			->set_content_type('application/json')
			->set_status_header($status)
			->set_output(json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES))
			->_display();
		exit;
	}

	//Create function
	public function create() {
			$postdata = file_get_contents("php://input");
			$request = json_decode($postdata, true);
			$firstName = $request['firstName'];
    	$lastName = $request['lastName'];
			$company = $request['company'];
    	$visitorType = $request['visitorType'];
			$mobileNum = $request['mobileNum'];
    	$personVisiting = $request['personVisiting'];
			$isSick = $request['isSick'];
    	$keyID = $request['keyID'];

			$this->load->model('History_model');

			return $this->response($this->History_model->create($firstName, $lastName, $company, $visitorType, $mobileNum, $personVisiting, $isSick, $keyID));
	}

  public function returnKey() {
    $postdata = file_get_contents("php://input");
    $request = json_decode($postdata, true);
    $mobile = $request['search_mobile'];
    $name = $request['search_name'];

    $this->load->model('History_model');

    return $this->response($this->History_model->keyExpire($mobile, $name));
  }
}