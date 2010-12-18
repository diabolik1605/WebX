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
        "finder": {
          "Start": {
            "About": {
              "click": "false"
            },
            "Prefrences": {
              "click": "false"
            },
            "Dock": {
              "click": "false",
              "list": {
                "Hide": {
                  "click": "WebX.Dock.hide"
                },
                "Show": {
                  "click": "WebX.Dock.show"
                },
                "Toggle": {
                  "click": "WebX.Dock.toggle"
                }
              }
            }
          }
        },
        "browser": {
          "Start": {
            "About": {
              "click": "false"
            },
            "Prefrences": {
              "click": "false"
            },
            "Dock": {
              "click": "false",
              "list": {
                "Hide": {
                  "click": "WebX.Dock.hide"
                },
                "Show": {
                  "click": "WebX.Dock.show"
                },
                "Toggle": {
                  "click": "WebX.Dock.toggle"
                }
              }
            }
          },
          "File": {
            "New Window": {
              "click": "WebX.browser.create"
            },
            "New Tab": {
              "click": "false"
            }
          }
        }
      },
    	"dock":{
    		"finder":{
    		    "name": "Finder",
    		    "click": "WebX.finder.create",
    		    "right_click": "function(){ console.log(\"finder right click\");}",
    		    "right_click_menu": [{
      		      "item": "New Finder Window",
      		      "click": "function(){ console.log(\"New Finder window click\");}"
      		    },
      		    {
      		      "item": "Hide",
      		      "click": "function(){ console.log(\"Hide Finder click\");}"
      		    }
    		    ]
    		},
    		"dashboard":{
    		    "name": "Dashboard",
    		    "click": "WebX.Dashboard.start",
    		    "right_click": "function(){ console.log(\"dashboard right click\");}",
    		    "right_click_menu": [{
      		      "item": "Show Dashboard",
      		      "click": "function(){ console.log(\"Show Dashboard click\");}"
      		    }
    		    ]
    		},
    		"paste":{
    		    "name": "Paste",
    		    "click": "false",
    		    "right_click": "function(){ console.log(\"paste right click\");}",
    		    "right_click_menu": [{
      		      "item": "Open",
      		      "click": "function(){ console.log(\"Open Paste click\");}"
      		    }
    		    ]
    		},
    		"files":{
    		    "name": "Files",
    		    "click": "false",
    		    "right_click": "function(){ console.log(\"files right click\");}",
    		    "right_click_menu": [{
      		      "item": "Open",
      		      "click": "function(){ console.log(\"Open Files click\");}"
      		    }
    		    ]
    		},
    		"browser": {
    		  "name": "Browser",
    		  "click": "WebX.browser.create",
    		  "right_click": "function(){ console.log(\"browser right click\");}",
  		    "right_click_menu": [{
    		      "item": "New Window",
    		      "click": "function(){ console.log(\"New Window Browser click\");}"
    		    },
    		    {
    		      "item": "Hide",
    		      "click": "function(){ console.log(\"Hide Browser click\");}"
    		    }
  		    ]
    		},
    		"settings": {
    		    "name": "Settings",
    		    "click": "false",
    		    "right_click": "function(){ console.log(\"settings right click\");}",
    		    "right_click_menu": [{
      		      "item": "Open",
      		      "click": "function(){ console.log(\"Open Settings click\");}"
      		    }
    		    ]
    		},
    		"separator": {
    		  
    		},
    		"trash": {
    		    "name": "Trash",
    		    "click": "false",
    		    "right_click": "function(){ console.log(\"trash right click\");}",
    		    "right_click_menu": [{
      		      "item": "Open",
      		      "click": "function(){ console.log(\"Open trash click\");}"
      		    },
      		    {
      		      "item": "Empty Trash",
      		      "click": "function(){ console.log(\"Empty Trash click\");}"
      		    }
    		    ]
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