<?php

class Image extends Controller {

	function Image()
	{
		parent::Controller();	
	}
	
	function get() {
	  $url = $this->input->get_post('url');
	  $width = ($this->input->get_post('width')) ? $this->input->get_post('width') : "auto";
	  $height = ($this->input->get_post('height')) ? $this->input->get_post('height') : "auto";
    echo "<img src='".$url."' alt='' width='".$width."' height='".$height."' />";
	}
}

/* End of file welcome.php */
/* Location: ./system/application/controllers/welcome.php */