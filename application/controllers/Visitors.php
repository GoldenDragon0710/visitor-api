<?php
defined('BASEPATH') OR exit('No direct script access allowed');
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Methods: GET,POST,OPTIONS,DELETE,PUT");

class Visitors extends CI_Controller {

	//dynamic response
	public function response($data, $status = 200){
		$this->output
			->set_content_type('application/json')
			->set_status_header($status)
			->set_output(json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES))
			->_display();
		exit;
	}

	//Sign Up function
	public function register() {
			$postdata = file_get_contents("php://input");
			$request = json_decode($postdata, true);
			$first_name = $request['first_name'];
    	$last_name = $request['last_name'];
			$company_name = $request['company_name'];
    	$visitor_type = $request['visitor_type'];
			$mobile_number = $request['mobile_number'];
    	$state = $request['state'];
			$wwcc = $request['wwcc'];
    	$email = $request['email'];
    	$password = $request['password'];

			$this->load->model('Visitors_model');

			return $this->response($this->Visitors_model->register($first_name, $last_name, $company_name, $visitor_type, $mobile_number, $state, $wwcc, $email, $password));
	}

	public function login() {
		$postdata = file_get_contents("php://input");
    $request = json_decode($postdata, true);
    $email = $request['email'];
    $password = $request['password'];

		$this->load->model('Visitors_model');

		return $this->response($this->Visitors_model->login($email, $password));
	}

	public function search() {
		$postdata = file_get_contents("php://input");
    $request = json_decode($postdata, true);
    $mobile_number = $request['mobile_number'];
    $first_name = $request['first_name'];
    $key = $request['key'];

		$this->load->model('Visitors_model');

		return $this->response($this->Visitors_model->search($mobile_number, $first_name, $key));
		// return $this->response($mobile_number);
	}
}