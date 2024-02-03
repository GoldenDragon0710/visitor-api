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
			$first_name = $request['first_name'];
    	$last_name = $request['last_name'];
			$company_name = $request['company_name'];
    	$visitor_type = $request['visitor_type'];
			$mobile_number = $request['mobile_number'];
    	$person_visiting = $request['person_visiting'];
			$isSick = $request['isSick'];
    	$key_id = $request['key_id'];
    	$key_duration = $request['key_duration'];
			$key_returned = false;
			$school_name = $request['school_name'];

			$this->load->model('History_model');

			return $this->response($this->History_model->create($first_name, $last_name, $company_name, $visitor_type, $mobile_number, $person_visiting, $isSick, $school_name, $key_id, $key_duration, $key_returned));
	}

	public function getUserbyKeyID() {
		$postdata = file_get_contents("php://input");
    $request = json_decode($postdata, true);
    $key_id = $request['key_id'];

		$this->load->model('History_model');

		return $this->response($this->History_model->getUserbyKeyID($key_id));
	}

	public function getAll() {
		$postdata = file_get_contents("php://input");
    $request = json_decode($postdata, true);
		$school_name = $request['school_name'];
		$this->load->model('History_model');

		return $this->response($this->History_model->getAll());
	}

	public function getAllbyMobile() {
		$postdata = file_get_contents("php://input");
    $request = json_decode($postdata, true);
		$mobile_number = $request['mobile_number'];
		$this->load->model('History_model');

		return $this->response($this->History_model->getAllbyMobile($mobile_number));
	}

	public function getAllbyDate() {
		$postdata = file_get_contents("php://input");
    $request = json_decode($postdata, true);
		$created_at = $request['created_at'];
		$updated_at = $request['updated_at'];
		$mobile_number = $request['mobile_number'];
		$this->load->model('History_model');

		return $this->response($this->History_model->getAllbyDate($created_at, $updated_at, $mobile_number));
	}

  public function keyExpire() {
    $postdata = file_get_contents("php://input");
    $request = json_decode($postdata, true);
    $key_id = $request['key_id'];

    $this->load->model('History_model');

    return $this->response($this->History_model->keyExpire($key_id));
  }
}