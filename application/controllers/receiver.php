<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Receiver extends CI_Controller
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

  function sms(){
    if ($_SERVER['REQUEST_METHOD'] != 'GET' || !$_GET['Body'] || !$_GET['From'] || !$_GET['To']){
      $this->load->view('twiml.php', array('message' => 'Invalid request!'));
      return;
    }
    switch(substr($_GET['Body'], 0, 2)){
      case 'st':
        $this->load->view('twiml.php', array('redirect' => 'http://rcchan.cs132-twilio.cs.brown.edu/stream/post'));
        break;
      default:
        $this->load->view('twiml.php', array('message' => 'Invalid module code'));
    }
  }
}
?>