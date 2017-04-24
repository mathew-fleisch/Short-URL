<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class a extends CI_Controller {
	function _remap($param) {
        $this->index($param);
    }
	public function index($param) {
		$ip = $this->input->ip_address();
		$browser = $this->input->user_agent();
		if (isset($_SERVER['HTTP_REFERER'])) { 
			$referrer = $_SERVER['HTTP_REFERER']; 
		} else { $referrer = NULL; }

		if($this->Model_Api->visit($param, $ip, $browser, $referrer)) {
			$url = $this->Model_Api->get_url($param);
			if(is_string($url)) { 				
				header('Location: '.$url);
			} else { echo $url.ERROR_NOT_FOUND; exit(); }
		} else { 
			echo ERROR_REDIRECT_LOG_FAIL;
			exit();
		}
	}
}
