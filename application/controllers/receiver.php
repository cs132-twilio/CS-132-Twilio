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
    $code = preg_split('/[\s]+/', $_GET['Body'], 2);
    $code = strtolower($code[0]);
    switch($code){
      case 'j':
      case 'join':
        $this->load->view('twiml.php', array('redirect' => '/join/add'));
        break;
      case 's':
      case 'str':
      case 'stream':
        $this->load->view('twiml.php', array('redirect' => '/modules/stream/post'));
        break;
      case 'p':
      case 'poll':
        $this->load->view('twiml.php', array('redirect' => '/modules/poll/post'));
        break;
      default:
        $this->load->view('twiml.php', array('message' => 'Invalid module code'));
    }
  }
}
?>