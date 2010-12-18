<?php

class Browser extends Controller {

	function Browser()
	{
		parent::Controller();	
	}
	
	function get() {
	  $url = $this->input->post('url');
    return readfile( $url );
	}
	
	function get_page_title(){
    $url = $this->input->post('url');
    $file = file($url);
    $file = implode("",$file);

    if(preg_match("/<title>(.+)<\/title>/i",$file,$m)) {
      return print($m[1]);
    } else {
      return false;
    }
  }
}

/* End of file welcome.php */
/* Location: ./system/application/controllers/welcome.php */