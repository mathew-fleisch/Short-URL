<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {
	function _remap($param) {
        $this->index($param);
    }
	public function index($param)
	{
		$this->load->view('main_page');
	}
}
