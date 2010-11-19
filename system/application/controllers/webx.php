<?php

class Webx extends Controller {

	function Webx()
	{
		parent::Controller();	
	}
	
	function index() {
	    $data = array(
	        'base_url' => base_url(),
	        'uid' => 0,
            'first_name' => "",
            'last_name' => "",
            'friends' => array(),
            'pic_albums' => array(),
            'userInfo' => array('first_name' => "", "last_name" => "", "pic_square" => "", "friends" => array(), "pic_albums" => array())
	    );
		$this->load->view('js/index', $data);
	}
}

/* End of file welcome.php */
/* Location: ./system/application/controllers/welcome.php */