<?php
class History_model extends CI_Model {
    public function __construct() {
      parent::__construct();
      $this->load->database();
    }
    
    public function create($firstName, $lastName, $company, $visitorType, $mobileNum, $personVisiting, $isSick, $keyID) {
      if ($firstName == "" || $lastName == "" || $mobileNum == "" || $company == "" || $visitorType == "" || $personVisiting == "" || $keyID == "") {
          return [
            'status'	=> false,
            'message'	=> 'Invalid information'
          ];
        }
      $data = array(
        'firstName' => $firstName,
        'lastName' => $lastName,
        'company' => $company,
        'visitorType' => $visitorType,
        'mobileNum' => $mobileNum,
        'personVisiting' => $personVisiting,
        'isSick' => $isSick,
        'keyID' => $keyID,
        'isExpired' => false
      );

      return $this->db->insert('history', $data);
    }

    public function keyExpire($mobile, $name) {
      $this->db->select('*');
      $this->db->from('history');

      if (!empty($name) && !empty($mobile)) {
        // Both values exist, use AND
        $this->db->where('firstName', $name);
        $this->db->where('mobileNum', $mobile);
      } else {
        // Only one value exists, use OR
        if (!empty($name)) {
          $this->db->where('firstName', $name);
        }
        if (!empty($mobile)) {
          $this->db->or_where('mobileNum', $mobile);
        }
      }

      $result = $this->db->get();

      $data = array(
        'isExpired' => true,
      );
      
      if ($result->num_rows() > 0) {
        
        $search_mobile = $result->row()->mobileNum;
        $this->db->where('mobileNum', $search_mobile);
        $this->db->update('history', $data);
        return [
          'status' => true,
          'message'	=> "Successfully expired"
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