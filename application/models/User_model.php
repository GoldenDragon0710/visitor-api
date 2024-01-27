<?php
class User_model extends CI_Model {
    public function __construct() {
      parent::__construct();
      $this->load->database();
    }
    
    public function register($firstName, $lastName, $company, $visitorType, $mobileNum, $state, $wwcc, $email, $password) {
      $this->db->where('email', $email);
      $result = $this->db->get('users');
      if($result->num_rows() === 1) {
        return [
          'status'	=> false,
          'message'	=> 'User is already existed'
			  ];
      } else {
        if ($firstName == "" || $lastName == "" || $mobileNum == "" || $email == "" || $password == "" || $state == "" || $wwcc == "" || $email == "" || $password == "") {
          return [
            'status'	=> false,
            'message'	=> 'Invalid user information'
          ];
        }
        $data = array(
          'firstName' => $firstName,
          'lastName' => $lastName,
          'company' => $company,
          'visitorType' => $visitorType,
          'mobileNum' => $mobileNum,
          'state' => $state,
          'wwcc' => $wwcc,
          'email' => $email,
          'password' => password_hash($password, PASSWORD_DEFAULT),
          'isLoggedIn' => true,
        );

        $this->db->insert('users', $data);
        return [
          'status' => true,
          'data'	=> $data
        ];
      }
    }
   
    public function login($email, $password) {
      $this->db->where('email', $email);
      $result = $this->db->get('users');
      if($result->num_rows() > 0) {
        $db_password = $result->row()->password;
        $passwordVerified = password_verify($password, $db_password);
        if ($passwordVerified) {
          $data = array(
            'isLoggedIn' => true
          );
          $this->db->where('email', $email);
          $this->db->update('users', $data);
          return [
            'status' => true,
            'data'	=> $result->row()
          ];
        } else {
          return [
            'status'	=> false,
            'message'	=> 'Password does not matched'
          ];
        }
      } else { 
        return [
          'status'	=> false,
          'message'	=> 'User does not exist'
        ];
        
      }
    } 

    public function logOut($email) {
      $data = array(
        'isLoggedIn' => false,
      );
      $this->db->where('email', $email);
      $this->db->update('users', $data);
      return [
        'status' => true,
        'message'	=> "Successfully logged out"
      ];
    }
  }
?>