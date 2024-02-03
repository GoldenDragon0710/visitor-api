<?php
class Staff_model extends CI_Model {
    public function __construct() {
      parent::__construct();
      $this->load->database();
    }

    public function register($first_name, $last_name, $school_name, $role, $mobile_number, $email, $password) {
      $this->db->where('email', $email);
      $result = $this->db->get('staff');
      if($result->num_rows() === 1) {
        return [
          'status'	=> false,
          'message'	=> 'Email is already existed'
			  ];
      }
      $this->db->where('mobile_number', $mobile_number);
      $result = $this->db->get('staff');
      if($result->num_rows() === 1) {
        return [
          'status'	=> false,
          'message'	=> 'Mobile Number is already existed'
			  ];
      }
      if ($first_name == "" || $last_name == "" || $school_name == "" || $role == "" || $mobile_number == "" || $email == "" || $password == "") {
        return [
          'status'	=> false,
          'message'	=> 'Invalid user information'
        ];
      }
      $this->load->helper('date');
      $now = now();
      $data = array(
        'first_name' => $first_name,
        'last_name' => $last_name,
        'school_name' => $school_name,
        'role' => $role,                                                                                                                                                                                    
        'mobile_number' => $mobile_number,
        'email' => $email,
        'password' => password_hash($password, PASSWORD_DEFAULT),
        'created_at' => date('Y-m-d H:i:s'),
      );

      $this->db->insert('staff', $data);
      return [
        'status' => true,
        'message'	=> "Successfully signed up"
      ];
    }
   
    public function login($email, $password) {
      $this->db->where('email', $email);
      $result = $this->db->get('staff');
      if($result->num_rows() > 0) {
        $db_password = $result->row()->password;
        $passwordVerified = password_verify($password, $db_password);
        if ($passwordVerified) {
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
  }
?>