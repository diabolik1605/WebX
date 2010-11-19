<?php

class Canvas extends Controller {

	function Canvas()
	{
		parent::Controller();	
	}
	
	function index() { 
       $appId = $this->config->item('fb_app_id');
       $data['appId'] = $appId;
       $secret = $this->config->item('fb_secret');
       
       $this->load->library('facebook', array('appId' => $appId, 'secret' => $secret, 'cookie' => true));
       $session = $this->facebook->getSession();
       $loginUrl = $this->facebook->getLoginUrl(
               array(
               'canvas'    => 1,
               'fbconnect' => 0,
               'req_perms' => 'email,publish_stream,status_update'
               )
       );
       
       
       // if(!empty($session['access_token'])){
       //   $this->session->set_userdata('access_token', $session['access_token']);
       // } else {
       //   $auth_config['req_perms'] = 'publish_stream';
       //   $auth_config['display'] = 'popup';
       //   $auth_config['next'] = base_url().'webx';
       //   
       //   $login_url = $this->facebook->getLoginUrl($auth_config);
       //   header('Location: '.$login_url);
       // }
    
        $me = null;

        if (!$session) {
          header('Location: '.$loginUrl);
          exit;
        } else {
          try {
            $uid = $this->facebook->getUser();
            $me = $this->facebook->api('/me');
          } catch (FacebookApiException $e) {
            error_log($e);
          }
        }
       
       if($me) {
         $data['me'] = $me;
         $data['uid'] = $me['id'];
         $data['first_name'] = $me['first_name'];
         $data['last_name'] = $me['last_name'];
         $data['friends'] = $this->facebook->api('/me/friends');
         $data['pic_albums'] = $this->facebook->api('/me/albums');
         $data['logoutUrl'] = $this->facebook->getLogoutUrl();
       } else {
         $data['me'] = null;
         $data['uid'] = 0;
         $data['first_name'] = "";
         $data['last_name'] = "";
         $data['friends'] = array();
         $data['pic_albums'] = array();
         $data['loginUrl'] = $this->facebook->getLoginUrl(array('canvas' => 1, 'fbconnect' => 0, 'req_perms' => 'email,publish_stream,status_update'));
       }
        
       #$query = "SELECT first_name, last_name, name, pic_square FROM user WHERE ".$uid." IN (uid)";
       #$userInfo = $facebook->api_client->fql_query($query);
       $data['userInfo'] = array('first_name' => $data['first_name'], "last_name" => $data['last_name'], "pic_square" => "", "friends" => $data['friends'], "pic_albums" => $data['pic_albums']);
       
    $this->load->view('fb/canvas', $data);
    // $this->load->view('fb/canvas');
		// $this->load->view('fb/webx_tab.php');
	}
	
	function webx_tab()
	{
		$this->load->view('fb/webx_tab.php');
		// $this->load->view('fb/canvas.php');
	}
}
