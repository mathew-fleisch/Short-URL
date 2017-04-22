<?php
require(APPPATH.'libraries/REST_Controller.php');
 
class Api extends REST_Controller {
	function url_post() {
		$this->response('Working', 200);
	}
}