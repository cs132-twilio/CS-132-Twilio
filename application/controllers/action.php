<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Action extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
    $this->load->library('twilio');
    $this->load->library('tank_auth');
	}

	function index()
	{
		header('Status: 403 FORBIDDEN');
	}

  function send(){
    header('Content-type: application/json');
    if (!$this->tank_auth->is_logged_in()) exit(json_encode(array('success' => 0, 'message' => 'You must be logged in to send messages!')));
    if ($_SERVER['REQUEST_METHOD'] != 'POST') exit(json_encode(array('success' => 0, 'message' => 'Invalid Request!')));
    if (!$_POST['n'] || !$_POST['m']) exit(json_encode(array('success' => 0, 'messsage' => 'You must fill in all fields')));
    $n = explode(',', $_POST['n']);
		foreach ($n as $to){
      $response = $this->twilio->sms('0000000000', $to, $_POST['m']);
      if($response->IsError){
        $r[] = array('success' => 0, 'message' => $response->ErrorMessage);
      } else {
        $r[] = array('success' => 1, 'message' => 'Message succesfully sent to ' . $to);
      }
    }
    echo json_encode($r);
  }
}