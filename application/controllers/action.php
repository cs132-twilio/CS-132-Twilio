<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Action extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
	}

	function index()
	{
		header('Status: 403 FORBIDDEN');
	}

  function send(){
    header('Content-type: application/json');
    $this->load->library('twilio');
    $n = explode(',', $_GET['to']);
		foreach ($n as $to){
      $response = $this->twilio->sms('0000000000', $to, $_GET['m']);
      if($response->IsError){
        $r[] = array('success' => 0, 'message' => $response->ErrorMessage);
      } else {
        $r[] = array('success' => 1, 'message' => 'Message succesfully sent to ' . $to);
      }
    }
    echo json_encode($r);
  }
}