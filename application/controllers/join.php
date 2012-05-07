<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Join extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
    $this->load->library('twilio');
	}

	function index()
	{
		header('Status: 403 FORBIDDEN');
	}

  function add(){
    if ($_SERVER['REQUEST_METHOD'] != 'GET' || !$_GET['Body'] || !$_GET['From'] || !$_GET['To']){
      $this->load->view('twiml.php', array('message' => 'Invalid request!'));
      return;
    }
    $message = preg_split('/[\s]+/', $_GET['Body'], 2);
    if (!$message[1]){
      $this->load->view('twiml.php', array('message' => 'Invalid request!'));
      return;
    }
    if (preg_match('/[\d]+/', $message[1])){
      $cid = intval($message[1]);
      if ($cid > 0){
        $r = $this->db->query('SELECT id FROM students WHERE number = ? LIMIT 1', array($_GET['From']))->result_array();
        if (count($r) && $r[0]['id']){
          $this->db->query('REPLACE INTO classmap (class_id, student_id) VALUES (?, ?)', array($cid, $r[0]['id']));
          $this->load->view('twiml.php', array('message' => 'You have been added to class ' . $cid));
        } else {
          $this->load->view('twiml.php', array('message' => 'Please add yourself to the system by sending "JOIN [your name here]" before joining a class'));
          return;
        }
      } else {
        $this->load->view('twiml.php', array('message' => 'Invalid class number!'));
        return;
      }
    } else {
      //$this->db->query('REPLACE INTO students (name, number) VALUES (?, ?)', array($message[1], $_GET['From']));
      $num = $_GET['From'];
      $name = $message[1];
      $this->db->query('IF EXISTS (SELECT id FROM students WHERE number = ?) UPDATE students SET name = ? WHERE number = ? ELSE INSERT INTO students (name, number) VALUES (?, ?)', array($num, $name, $num, $name, $num));
      $this->load->view('twiml.php', array('message' => 'You have been successfully registered. Text JOIN [id] to join a class'));
      return;
    }
  }
  
  function unjoin(){
    if ($_SERVER['REQUEST_METHOD'] != 'GET' || !$_GET['Body'] || !$_GET['From'] || !$_GET['To']){
      $this->load->view('twiml.php', array('message' => 'Invalid request!'));
      return;
    }
    $message = preg_split('/[\s]+/', $_GET['Body'], 2);
    if (!$message[1]){
      $this->load->view('twiml.php', array('message' => 'Invalid request!'));
      return;
    }
    if (preg_match('/[\d]+/', $message[1])){
      $cid = intval($message[1]);
      if ($cid > 0){
        $r = $this->db->query('SELECT id FROM students WHERE number = ? LIMIT 1', array($_GET['From']))->result_array();
        if (count($r) && $r[0]['id']){
          $this->db->query('DELETE FROM classmap WHERE class_id = ? AND student_id = ?', array($cid, $r[0]['id']));
          $this->load->view('twiml.php', array('message' => 'You are no longer in class ' . $cid));
        } else {
          $this->load->view('twiml.php', array('message' => 'You are not in the system and thus cannot unjoin any classes.'));
          return;
        }
      } else {
        $this->load->view('twiml.php', array('message' => 'Invalid class number!'));
        return;
      }
    } else {
      $this->load->view('twiml.php', array('message' => 'Text "unjoin [id]" to leave a class.'));
      return;
    }
  }
  
  function poll($thread){
    header('Content-type: application/json');
    if (!$this->tank_auth->is_logged_in()) exit(json_encode(array('success' => 0, 'username' => '<span class="stream_error_title">Twexter System Message</span>', 'message' => 'You must be <a href="/auth/login">logged in</a> to read messages!', 'execute' => 'clearInterval(Twexter.Stream.loop);')));
    $r = $this->db->query('SELECT user_id, username, message, unix_timestamp(timestamp) AS timestamp FROM stream INNER JOIN (SELECT id, username FROM users) users ON users.id = user_id WHERE thread = ? AND unix_timestamp(timestamp) > ?', array($thread, $_SERVER['QUERY_STRING']));
    $r = $r->result_array();
    foreach($r as &$s){
      $s['username'] = htmlentities($s['username']);
      $s['message'] = htmlentities($s['message']);
    }
    echo json_encode($r);
  }
}