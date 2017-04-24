<?php
require(APPPATH.'libraries/REST_Controller.php');
 
class Api extends REST_Controller {

	/**
	 * url_post() - Submits user's external url and returns a shortened url
	 *
	 * @param       string  $url    Input url
	 * @return      string
	 */
	function url_post() {
		if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
			$ip = $_SERVER['HTTP_CLIENT_IP'];
		} elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
			$ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
		} else {
			$ip = $_SERVER['REMOTE_ADDR'];
		}
		if (isset($_SERVER['HTTP_USER_AGENT'])) { 
			$browser = $_SERVER['HTTP_USER_AGENT']; 
		} else { $browser = NULL; }
		if (isset($_SERVER['HTTP_REFERER'])) { 
			$referrer = $_SERVER['HTTP_REFERER']; 
		} else { $referrer = NULL; }

		$url  = strip_tags(urldecode(strip_tags($this->post('url'))));

		$success = false;
		$logged  = false;
		$message = '';
		$short   = '';
		$existing;

		if(strlen($url)) {
			$this->load->model('Model_Api');

			if($this->isPhishy($url)) {
				//To do : add log for attempts;
				$success = false;
				$message = $this->Model_Api->get_error(SOMETHING_SMELLS_PHISHY, array($this->isPhishy($url)));
				$logged  = $this->Model_Api->log_error(SOMETHING_SMELLS_PHISHY, $message, $ip, $browser, $referrer);
				$this->response(json_encode(
					array(
						KEYS_SUCCESS=>$success,
						KEYS_LOGGED=>$logged,
						KEYS_MESSAGE=>$message
					)
				), 200);
			} else { 
				$success = true;


				$existing = $this->Model_Api->check_existing($url);
				if(is_string($existing->alias)) {
					$short = $existing->alias;
					$message = MESSAGE_SUCCESSFUL;
				} else { 
					$short = $this->Model_Api->shorten_url($url, $ip);
					$message = MESSAGE_SHORT_URL_CREATED;
				}

				$this->response(json_encode(
					array(
						KEYS_SUCCESS=>$success,
						KEYS_MESSAGE=>$message,
						KEYS_URL=>$url,
						KEYS_EXISTING=>$existing->visits,
						KEYS_SHORT=>$short
					)
				), 200);
			}
		} else { 
			$this->response(null, 400);
		}
	}


	/**
	 * url_get() - Gets the original url based on an alias/url-id
	 *
	 * @param       string  $alias    Input url-id
	 * @return      string
	 */
	function url_get() {
		if(!$this->get('alias')) { $this->response(null, 400); }
		$this->load->model('Model_Api');
		$this->response($this->Model_Api->get_url($this->get('alias')), 200);
	}


	/**
	 * isPhishy() - Compares user submitted url to the Phish Tank blacklist 
	 *
	 * @param       string  $url    Input url
	 * @return      string
	 */
	private function isPhishy($url) {
		$phish = json_decode(PHISH_JSON, true);
		if(isset($phish[$url])) {
			return $phish[$url];
		} else { return 0;}

	}
}