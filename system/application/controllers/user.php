<?php

class User extends Controller {
	
	function User() {
		parent::Controller();
		$this->load->model('user_model', 'user');
	}
	
	function newUser() {
		if (!$_POST['user_nick']) {
			$error['error_nick'] = "Nickname required";
		}
		if(empty($error)) {
			$data = array(
				'facebook_uid' => $_POST['facebook_uid'],
				'first_name' => $_POST['first_name'],
				'last_name' => $_POST['last_name'],
				'user_nick' => $_POST['user_nick'],
				'image_url' => $_POST['image_url']
			);
			
			
			$user = $this->user->newUser($data);
			echo $user;
		} else {
			print_r($error);
		}
	}
	
	function update() {
	
	}
	
	function edit() {
	
	}
	
	function delete() {
	
	}
	
	function getUserId() {
    	if (!isset($_POST['fb_uid'])) { $_POST['fb_uid'] = "undefined"; }; 
		$fb_user = $_POST['fb_uid'];
		$userID = $this->user->getUserId(array('fbuid' => $fb_user));
		echo $userID;
	}
	
	function getSettings() {
		if (!isset($_POST['fb_uid'])) { $_POST['fb_uid'] = "undefined"; };
		$user = $_POST['fb_uid'];
		if(empty($error)) {
			$data = array('user_id' => $user);
			$settings = $this->user->getSettings($data);
			header('Cache-Control: no-cache, must-revalidate');
			header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
			header('Content-type: application/json');
			echo $settings;
		}
	}
	
	function getDefaultSettings() {
		$settings = '{
        "menubar": {
    		"items": [
    				"start",
    				"dock"
    		],
    		"panels": {
    			"start": [
    				"about",
    				"update"
    			],
    			"dock": [
    				"toggle"
    			],
    			"login": [
    				"register",
    				"login"
    			]
    		}
    	},
    	"dock":{
    		"items": [
    		  "dashboard",
    			"files",
    			"paste",
    			"settings"
    		],
    		"settings":{
    		    "name": "Settings"
    		},
    		"files":{
    		    "name": "Files"
    		},
    		"paste":{
    		    "name": "Paste"
    		},
    		"dashboard":{
    		    "name": "Dashboard"
    		}		
    	}
    }';
		header('Cache-Control: no-cache, must-revalidate');
		header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
		header('Content-type: application/json');
		echo $settings;
	}
	
	function updateSettings() {
		if (!$_POST['fb_uid']){
			$error['login'] = "Must be logged In.";
		}
		if (!isset($_POST['fb_uid'])) { $_POST['fb_uid'] = "undefined"; };
		if (!isset($_POST['settings'])) { $_POST['settings'] = "{}"; };
		$settings = (string)$_POST['settings'];
		if(empty($error)) {
			$data = array('user_id' => $_POST['fb_uid'], 'content' => $settings, 'time' => date("Y-m-d H:i:s"));
			$result = $this->user->updateSettings($data);
			echo $result;
		}
	}
}
?>