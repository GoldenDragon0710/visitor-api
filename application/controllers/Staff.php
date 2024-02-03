<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Staff extends CI_Controller {

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
			$school_name = $request['school_name'];
    	$role = $request['role'];
			$mobile_number = $request['mobile_number'];
    	$email = $request['email'];
    	$password = $request['password'];

			$this->load->model('Staff_model');

			return $this->response($this->Staff_model->register($first_name, $last_name, $school_name, $role, $mobile_number, $email, $password));
	}

	public function login() {
		$postdata = file_get_contents("php://input");
    $request = json_decode($postdata, true);
    $email = $request['email'];
    $password = $request['password'];

		$this->load->model('Staff_model');

		return $this->response($this->Staff_model->login($email, $password));
	}

}