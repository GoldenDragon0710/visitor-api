<?php
class Visitors_model extends CI_Model {
    public function __construct() {
      parent::__construct();
      $this->load->database();
    }

    public function generate_key() {
      $characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789_#$!';
      $random_text = '';
      $length = 15;

      for ($i = 0; $i < $length; $i++) {
          $random_text .= $characters[rand(0, strlen($characters) - 1)];
      }
      
      return $random_text;
    }
    
    public function register($first_name, $last_name, $company_name, $visitor_type, $mobile_number, $state, $wwcc, $email, $password) {
      $this->db->where('email', $email);
      $result = $this->db->get('visitors');
      if($result->num_rows() === 1) {
        return [
          'status'	=> false,
          'message'	=> 'Email is already existed'
			  ];
      }
      $this->db->where('mobile_number', $mobile_number);
      $result = $this->db->get('visitors');
      if($result->num_rows() === 1) {
        return [
          'status'	=> false,
          'message'	=> 'Mobile Number is already existed'
			  ];
      }
      if ($first_name == "" || $last_name == "" || $company_name == "" || $visitor_type == "" || $mobile_number == "" || $state == "" || $wwcc == "" || $email == "" || $password == "") {
        return [
          'status'	=> false,
          'message'	=> 'Invalid user information'
        ];
      }
      $data = array(
        'first_name' => $first_name,
        'last_name' => $last_name,
        'company_name' => $company_name,
        'visitor_type' => $visitor_type,                                                                                                                                                                                    
        'mobile_number' => $mobile_number,
        'state' => $state,
        'wwcc'=> $wwcc,
        'email' => $email,
        'password' => password_hash($password, PASSWORD_DEFAULT),
        'key' => $this->generate_key(),
        'created_at' => date('Y-m-d H:i:s'),
      );

      $this->db->insert('visitors', $data);
      return [
        'status' => true,
        'message'	=> "Successfully signed up"
      ];
    }
   
    public function login($email, $password) {
      $this->db->where('email', $email);
      $result = $this->db->get('visitors');
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

    public function search($mobile_number, $first_name, $key) {
      $this->db->where('key', $key);
      $this->db->or_where('mobile_number', $mobile_number);
      $this->db->or_where('first_name', $first_name);
      $result = $this->db->get('visitors');
      if($result->num_rows() > 0) {
        return [
          'status'	=> true,
          'data'	=> $result->row()
        ];
      } else {
        return [
          'status'	=> false,
          'message'	=> 'User does not exist'
        ];
      }
    }
  }
?>