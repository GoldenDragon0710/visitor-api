<?php
class History_model extends CI_Model {
    public function __construct() {
      parent::__construct();
      $this->load->database();
    }
    
    public function create($first_name, $last_name, $company_name, $school_name, $visitor_type, $mobile_number, $person_visiting, $isSick, $key_id, $key_duration, $key_returned) {
      if ($first_name == "" || $last_name == "" || $company_name == "" || $school_name == "" || $visitor_type == "" || $mobile_number == "" || $person_visiting == "" || $key_id == "" || $key_duration == "") {
          return [
            'status'	=> false,
            'message'	=> 'Invalid information'
          ];
        }
      $data = array(
        'first_name' => $first_name,
        'last_name' => $last_name,
        'company_name' => $company_name,
        'school_name' => $school_name,
        'visitor_type' => $visitor_type,
        'mobile_number' => $mobile_number,
        'person_visiting' => $person_visiting,
        'isSick' => $isSick,
        'key_id' => $key_id,
        'key_duration' => $key_duration,
        'key_returned' => $key_returned,
        'created_at' => date('Y-m-d H:i:s'),
        'updated_at' => date('Y-m-d H:i:s'),
      );

      return [
        'status'	=> true,
        'message' => $this->db->insert('history', $data)
      ];
    }

    public function getUserbyKeyID($key_id) {
      $this->db->where('key_id', $key_id);
      $result = $this->db->get('history');
      if ($result->num_rows() > 0) {
        return [
          'status'=> true,
          'data'	=> $result->row()
        ];
      } else {
        return [
          'status' => false,
          'message'	=> 'User does not exist'
        ];
      }
    }

    public function getAll($school_name) {
      $this->db->select('*');
      $this->db->from('history');
      $this->db->where('school_name', $school_name);
      $this->db->where('key_returned', false);
      $query = $this->db->get();
      return [
        'status'=> true,
        'data'=> $query->result()
      ];
    }

    public function getAllbyMobile($mobile_number) {
      $this->db->select('*');
      $this->db->from('history');
      $this->db->where('mobile_number', $mobile_number);
      $this->db->where('key_returned', false);
      $query = $this->db->get();
      return [
        'status'=> true,
        'data'=> $query->result()
      ];
    }

    public function getAllbyDate($created_at, $updated_at, $mobile_number) {
      $query =  $this->db->query("SELECT * from history WHERE created_at > ".$created_at." AND updated_at < ".$updated_at." AND mobile_number = ".$mobile_number.";");
      return [
        'status'=> true,
        'data'=> $query->result()
      ];
    }

    public function keyExpire($key_id) {
      $this->db->where('key_id', $key_id);
      $result = $this->db->get('history');

      $data = array(
        'key_returned' => true,
        'updated_at' => date('Y-m-d H:i:s')
      );
      
      if ($result->num_rows() > 0) {
        
        $search_key_id = $result->row()->key_id;
        $this->db->where('key_id', $search_key_id);
        $this->db->update('history', $data);

        $this->db->select('*');
        $this->db->from('history');
        $this->db->where('key_returned', false);
        $query = $this->db->get();
        return [
          'status'=> true,
          'data'=> $query->result(),
          'message' => "Successfully Key Expired"
        ];
      } else {
        return [
          'status' => false,
          'message'	=> "Does not expire"
        ];
      }
    }
  }
?>