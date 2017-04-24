<?php
class Model_Api extends CI_Model {
    function __construct() {
        parent::__construct();
    }

	/**
	 * check_existing() - Url db lookup
	 *
	 * @param       string  $url    Input url
	 * @return      (true ? string : -1)
	 */
    function check_existing($url) {
    	$sql = "SELECT u.alias, COUNT(v.id) AS visits FROM urls AS u, visits AS v WHERE u.url = ? AND u.alias = v.alias;";
    	$query = $this->db->query($sql, array($url));
    	return (count($query->result()) ? $query->result()[0] : -1);
    }


	/**
	 * get_url() - Returns the original url based on the url id/alias 
	 *
	 * @param       string  $alias    Input id
	 * @return      string
	 */
    function get_url($alias) {
    	$sql = "SELECT url FROM urls WHERE alias = ?";
    	$query = $this->db->query($sql, array($alias));
    	return (count($query->result()) ? $query->result()[0]->url : -1);
    }

	/**
	 * shorten_url() - Inserts user's url into db and 
	 *                 returns a random string of about 7 characters
	 *
	 * @param       string  $url    Input url
	 * @param       string  $ip     User's IP
	 * @return      string
	 */
    function shorten_url($url, $ip) {
    	$short = base_convert(rand(0,10).time(), 10, 36);
		$sql = "INSERT INTO urls (url,alias,ip) VALUES (?,?,?)";
		$this->db->query($sql, array($url,$short,$ip));
    	return $short;
    }

	/**
	 * visit() - Logs visit in db  
	 *
	 * @param       string  $alias     Random string used in the short url
	 * @param       string  $ip        User's IP
	 * @param       text    $browser   User's 'User Agent'
	 * @param       text    $referrer  User's referring url
	 * @return      string
	 */
    function visit($alias, $ip, $browser, $referrer) {
		$sql = "INSERT INTO visits (alias, ip, browser, referrer) VALUES (?,?,?,?)";
		$this->db->query($sql, array($alias, $ip, $browser, $referrer));
    	return ($this->db->affected_rows() ? 1 : 0);
    }

	/**
	 * get_error() - Url db lookup
	 *
	 * @param       string  $error_code     Unique identifier for errors
	 * @param       array   $vars           Array of strings to make error messages dynamic
	 * @return      (true ? string : -1)
	 */
    function get_error($error_code, $vars) {
    	$sql = "SELECT message FROM errors WHERE error_code = ?";
    	$query = $this->db->query($sql, array($error_code));
    	return (count($query->result()) ? $this->parse_error($query->result()[0]->message, $vars) : 'error_code not found.');
    }

	/**
	 * log_error() - Url db lookup
	 *
	 * @param       string  $error_code     Unique identifier for errors
	 * @param       array   $msg           Array of strings to make error messages dynamic
	 * @return      (true ? string : -1)
	 */
    function log_error($error_code, $msg, $ip, $browser, $referrer) {
    	$sql = "INSERT INTO error_log (error_code, message, ip, browser, referrer) VALUES (?,?,?,?,?)";
    	$query = $this->db->query($sql, array($error_code, $msg, $ip, $browser, $referrer));
    	return ($this->db->affected_rows() ? 1 : 0);
    }

	/**
	 * parse_error() - Replaces keywords with elements from an array
	 *
	 * @param       string  $msg    Raw error message with replace string
	 * @param       array   $vars   Array of strings
	 * @return      (true ? string : -1)
	 */
    private function parse_error($msg, $vars) {
    	for($i = 0; $i < count($vars); $i++) { 
    		$msg = preg_replace("/{".ERROR_REPLACE_STRING."\[".$i."\]}/", $vars[$i], $msg);
    	}
    	return $msg;
    }

}