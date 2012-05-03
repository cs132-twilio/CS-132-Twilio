<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Poll extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->helper('form');
	}

	function index()
	{
		header('Status: 403 FORBIDDEN');
	}

  function post(){

    // make sure all the required fields are defined
    if ($_SERVER['REQUEST_METHOD'] != 'GET' || !$_GET['Body'] || !$_GET['From'] || !$_GET['To']){
      $this->load->view('twiml.php', array('message' => 'Invalid request!'));
      return;
    }

    // make sure the module code and number are defined and save the message
    if (!preg_match('/^poll[\s]+([A-Za-z0-9]+)[\s]+(.+)$/', $_GET['Body'], $message)){
      $this->load->view('twiml.php', array('message' => 'Invalid request!'));
      return;
    }

    $poll_name = $message[1];
    $poll_id = 0;

    // first obtain the teacher's id    
//     $r = $this->db->query('SELECT user_id FROM user_profiles WHERE phone_number=?', array($_GET['To']));
//     $results = $r->result_array();
// 
//     // if there is no such teacher, throw error -- MAKE SURE THIS WORKS!
//     $teacher_id = 0;
//     if ($results == null) {
// 	$this->load->view('twiml.php', array('message' => 'Sorry, the number you are trying to reach is not registered.'));
// 	return;
//     }
//     else {
// 	$teacher_id = $results[0]['user_id'];
//     }

    $teacher_id = 2;
    
    // figure out what the class id is
    $r = $this->db->query('SELECT classID FROM polls WHERE name=? AND teacherID=?', array($poll_name, $teacher_id));
    $results = $r->result_array();

    $class_id = 0;
    if ($results == null) {
	$this->load->view('twiml.php', array('message' => 'Sorry, this poll does not belong to a class.'));
	return;
    }
    else {
	$class_id = $results[0]['classID'];
    }

    // obtain the student's id    
    $r = $this->db->query('SELECT id FROM students WHERE number=?', array($_GET['From']));
    $results = $r->result_array();

    // if there is no such number, throw error -- This works!
    $student_id = 0;
//     $student_id = 4;
    if ($results == null) {
	$this->load->view('twiml.php', array('message' => 'Sorry, your number is not registered. Please register and try again.'));
	return;
    }
    else {
	$student_id = $results[0]['id'];
    }

    // make sure student is in the class
    $r = $this->db->query('SELECT COUNT(*) FROM classmap WHERE student_id=? AND class_id=?', array($student_id, $class_id));
    $results = $r->result_array();

    // if there is no such student, throw error -- MAKE SURE THIS WORKS!
    if ($results == null) {
	$this->load->view('twiml.php', array('message' => 'Sorry, you are not enrolled in this class!'));
	return;
    }

    // obtain the poll id based on the name
    $r = $this->db->query('SELECT pollID FROM polls WHERE name =? AND teacherID =? AND classID =?', 
			    array($poll_name, $teacher_id, $class_id));
    $results = $r->result_array();

    if ($results == null) {
	$this->load->view('twiml.php', array('message' => 'Invalid thread!'));
	return;
    }
    else {
	$poll_id = $results[0]['pollID'];
    }
    
    // response should be the rest of the message
    $response = $message[2];

    // enter all the information into the database

    // first check if the student has already responded
    $r = $this->db->query('SELECT COUNT(*) AS count FROM poll_responses WHERE teacherID =? AND pollID =? 
			   AND studentID =?', array($teacher_id, $poll_id, $student_id));
    $results = $r->result_array();

    if ($results[0]['count'] == 0) {
	  $this->db->query('INSERT INTO poll_responses (pollID, teacherID, studentID, response) 
		  VALUES (?, ?, ?, ?)', array($poll_id, $teacher_id, $student_id, $response));
    }
    else {
	$this->db->query('UPDATE poll_responses SET response =? WHERE teacherID =? AND pollID =?
				AND studentID =?', array($response, $teacher_id, $poll_id, $student_id));	
    }

    // problem:  if results == null --> doesn't add a row, but updates fine
//		 if results[0][0] == 0 --> inserts a new row every time (if already a row), otherwise throws error (to num not reg)

 }

  function addPoll() {

      // first obtain all the values for the poll
      $name = isset($_POST['name']) ? trim($_POST['name']) : '';
      $teacherID = intval($_POST['teacherID']);
      $classID = intval($_POST['classID']);
      $closingTime = ($_POST['closingtime']);

      // once we know all the values, we want to add a poll entry to the database table polls

      $this->db->query('INSERT INTO polls (name, teacherID, classID, closing_time)
		      VALUES (?, ?, ?, FROM_UNIXTIME(?))', array($name, $teacherID, $classID, strtotime($closingTime)));

  
  }
  
  function poll($teacherID, $pollID){
    header('Content-type: application/json');
    if (!$this->tank_auth->is_logged_in()) exit(json_encode(array('success' => 0, 'username' => '<span class="stream_error_title">Twexter System Message</span>', 'message' => 'You must be <a href="/auth/login">logged in</a> to read messages!', 'execute' => 'clearInterval(Twexter.Stream.loop);')));
    
    $r = $this->db->query('SELECT studentID, response FROM poll_responses WHERE teacherID = ? AND pollID = ?', 
			   array($teacherID, $pollID));
    $r = $r->result_array();

    foreach($r as &$s){
      $s['studentID'] = htmlentities($s['studentID']);
      $s['response'] = htmlentities($s['response']);
    }
    echo json_encode($r);
  }
}