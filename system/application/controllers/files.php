<?php

class Files extends Controller {
	
	function Files() {
		parent::Controller();
	}
	
	function add() {
		if ($this->input->post('action')) {
			if (!$this->input->post('user_id')) {
				$error['error_user'] = "User_id required";
			}
			
			$fileid = md5(uniqid(microtime()) . $_SERVER['REMOTE_ADDR'] . $_SERVER['HTTP_USER_AGENT']);
			
			$fileName = $_FILES['file']['name'];
			$tmpName = $_FILES['file']['tmp_name'];
			$fileSize = $_FILES['file']['size'];
			$fileType = $_FILES['file']['type'];
			$data = file_get_contents($tmpName);
			$content = mysql_real_escape_string($data);
			
			if(empty($error)) {
				$data = array(
					'file_id' => $fileid,
					'user_id' => $this->input->post('user_id'),
					'name' => $fileName,
					'type' => $fileType,
					'size' => $fileSize,
					'time' => date("Y-m-d H:i:s"),
					'content' => $content
				);
				
				$this->load->model('Files_model', 'files');
				$this->files->addFile($data);
			}
		}
	}
	
	function edit() {
	
	}
	
	function delete() {
	
	}
}
?>