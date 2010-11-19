<?php
class User_model extends Model {

	function User_model() {
		parent::Model();
		$this->db = $this->load->database('default',TRUE);
	}
	
	function getUser($filter = array()) {
		if (!is_array($filter)) return false;
		
		if (array_key_exists('facebook_uid',$filter)) {
			$this->db->where('facebook_uid',$filter['facebook_uid']);
		}
		
		if (array_key_exists('user_nick',$filter)) {
			$this->db->where('user_nick',$filter['user_nick']);
		}
		
		$query = $this->db->get('user');	
		return ($query->num_rows() > 0) ? $query->result() : array();
	}
	
	function getUserId($data) {
    	$this->db->where('facebook_uid', $data['fbuid']);
    	$this->db->select('id');
    	$this->db->from('user');
    	$this->db->limit(1);
    	$results = $this->db->get()->result();
    	if (count($results) == 0)
    		return NULL;
    	return $results[0]->id;
	}
	
	function newUser($data) {
		if (!is_array($data)) return false;
		$this->db->insert('user',$data);
		$this->db->insert('settings', array("user_id" =>$data['facebook_uid'],"content" => "{}","time" => date("Y-m-d H:i:s")));
		return true;
	}
	
	function deleteUser($data) {
		if (!is_array($data)) return false;
		if (!array_key_exists('facebook_uid', $data)) return false;
		$this->db->where('facebook_uid', $data['facebook_uid']);
		$this->db->delete('user');
		return true;
	}
	
	function updateUser($fbuid, $data) {
		$this->db->where('facebook_uid', $fbuid);
		$this->db->update('user',$data);
		return true;
	}
	
	function getSettings($data) {
		if (!is_array($data)) return false;
		if (!array_key_exists('user_id',$data)) return false;
		$this->db->where('user_id', $data['user_id']);
		$this->db->select('content');
		$this->db->from('settings');
		$this->db->limit(1);
		$results = $this->db->get()->result();
		if (count($results) == 0)
			return NULL;
		return json_encode($results[0]);
	}
	
	function updateSettings($data){
		if (!is_array($data)) return false;
		if (!array_key_exists('user_id',$data)) return false;
		$this->db->where('user_id', $data['user_id']);
		$this->db->update('settings',$data);
		return true;
	}

}
?>