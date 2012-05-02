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
    $message = preg_split('/[\s]+/', $_GET['Body'], 3);
    if (count($message) != 3){
      $this->load->view('twiml.php', array('message' => 'Invalid request!'));
      return;
    }
    $id = intval($message[1]);
    if ($id <= 0 || $message[2] === '' || $message[2] === null || $message[2] === false){
      $this->load->view('twiml.php', array('message' => 'Invalid thread!'));
      return;
    }
    $this->db->query('INSERT INTO stream (thread, student_id, message, timestamp) VALUES (?, (SELECT id FROM students WHERE number = ?), ?, NOW())', array($id, $_GET['From'], $message[2]));
  }
  
  function poll($thread){
    header('Content-type: application/json');
    if (!$this->tank_auth->is_logged_in()) exit(json_encode(array('success' => 0, 'username' => '<span class="stream_error_title">Twexter System Message</span>', 'message' => 'You must be <a href="/auth/login">logged in</a> to read messages!', 'execute' => 'clearInterval(Twexter.Stream.loop);')));
    $r = $this->db->query('SELECT student_id, name, message, unix_timestamp(timestamp) AS timestamp FROM stream, students s WHERE s.id = student_id AND thread = ? AND unix_timestamp(timestamp) > ?', array($thread, $_SERVER['QUERY_STRING']))->result_array();
    foreach($r as &$s){
      $s['name'] = htmlentities($s['name']);
      $s['message'] = htmlentities($s['message']);
    }
    echo json_encode($r);
  }
}