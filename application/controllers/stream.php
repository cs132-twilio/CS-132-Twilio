<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Stream extends CI_Controller
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

  function post(){
    if ($_SERVER['REQUEST_METHOD'] != 'GET' || !$_GET['Body'] || !$_GET['From'] || !$_GET['To']){
      $this->load->view('twiml.php', array('message' => 'Invalid request!'));
      return;
    }
    if (!preg_match('/^([\d]+) (.+)$/', substr($_GET['Body'], 2), $message)){
      $this->load->view('twiml.php', array('message' => 'Invalid request!'));
      return;
    }
    $id = intval($message[1]);
    if ($id <= 0){
      $this->load->view('twiml.php', array('message' => 'Invalid thread!'));
      return;
    }
    $message = $message[2];
    $this->db->query('INSERT INTO stream (thread, user_id, message, timestamp) VALUES (?, ?, ?, NOW())', array($id, 1, $message));
  }
  
  function poll($thread){
    header('Content-type: application/json');
    if (!$this->tank_auth->is_logged_in()) exit(json_encode(array('success' => 0, 'message' => 'You must be logged in to send messages!')));
    $r = $this->db->query('SELECT user_id, username, message, unix_timestamp(timestamp) AS timestamp FROM stream INNER JOIN (SELECT id, username FROM users) users ON users.id = user_id WHERE thread = ? AND unix_timestamp(timestamp) > ?', array($thread, $_SERVER['QUERY_STRING']));
    $r = $r->result_array();
    echo json_encode($r);
  }
}