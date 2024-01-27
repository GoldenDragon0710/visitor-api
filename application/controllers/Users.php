<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Users extends CI_Controller {

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
			$firstName = $request['firstName'];
    	$lastName = $request['lastName'];
			$company = $request['company'];
    	$visitorType = $request['visitorType'];
			$mobileNum = $request['mobileNum'];
    	$state = $request['state'];
			$wwcc = $request['wwcc'];
    	$email = $request['email'];
    	$password = $request['password'];

			$this->load->model('User_model');

			return $this->response($this->User_model->register($firstName, $lastName, $company, $visitorType, $mobileNum, $state, $wwcc, $email, $password));
	}

	public function login() {
		$postdata = file_get_contents("php://input");
    $request = json_decode($postdata, true);
    $email = $request['email'];
    $password = $request['password'];

		$this->load->model('User_model');

		return $this->response($this->User_model->login($email, $password));
	}

	public function logout() {
		$postdata = file_get_contents("php://input");
    $request = json_decode($postdata, true);
    $email = $request['email'];

		$this->load->model('User_model');
		
		return $this->response($this->User_model->logOut($email));
	}
}