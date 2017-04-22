<?php
require(APPPATH.'libraries/REST_Controller.php');
 
class Api extends REST_Controller {
	// function api() {
	// 	$this->load->view('api');
	// }
	// function index() { 
	// 	echo "Blah";
	// 	// $this->response('Working', 200);
	// }
	function url() {
		$this->response('Working', 200);
	}
}