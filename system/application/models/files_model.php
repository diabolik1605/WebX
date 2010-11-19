<?php
class Files_model extends Model {

	function Files_model() {
		parent::Model();
		$this->db = $this->load->database("default",TRUE);
	}
	
	function getFile($filter = array()) {
		if (!is_array($filter)) return false;
		
		if (array_key_exists('id',$filter)) {
			$this->db->where('id',$filter['id']);
		}
		
		if (array_key_exists('file_id',$filter)) {
			$this->db->where('file_id',$filter['file_id']);
		}
		
		if (array_key_exists('name',$filter)) {
			$this->db->where('name',$filter['name']);
		}
		
		if (array_key_exists('type',$filter)) {
			$this->db->where('type',$filter['type']);
		}
		
		if (array_key_exists('limit',$filter)) {
		  $this->db->limit($filter['limit']);
		}
		
		$query = $this->db->get('files');	
		return ($query->num_rows() > 0) ? $query->result() : array();
	}
	
	function addFile($data) {
		if (!is_array($data)) return false;
		$this->db->insert("files",$data);
		return $this->db->insert_id();
	}
	
	function deleteFile($data) {
		if (!is_array($data)) return false;
		if (array_key_exists('id',$data)){
			 this->db->where("id", $data['id']);
		} else if (array_key_exists('file_id',$data)){
			this->db->where("file_id", $data['file_id']);
		} else { return false } ;
		this->db->delete("files");
		return true;
	}
	
	function updateFile($id, $data) {
		$this->db->where('id', $id);
		$this->db->update("files",$data)
		return true;
	}

}
?>