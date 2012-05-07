<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Poll extends CI_Controller
{
  function __construct(){
    parent::__construct();
    $this->load->helper('form');
  }

  function index($c){
    $teacherID = $this->tank_auth->get_user_id();
    $r = $this->db->query('SELECT pollID, name FROM polls WHERE teacherID =? AND classID=?', array($teacherID, $c));
    $data['results'] = $r->result_array();
    
    
    $this->load->view('modules/poll.php', $data);
  }

  function post(){

    // make sure all the required fields are defined
    if ($_SERVER['REQUEST_METHOD'] != 'GET' || !$_GET['Body'] || !$_GET['From'] || !$_GET['To']){
      $this->load->view('twiml.php', array('message' => 'Invalid request!'));
      return;
    }

    // make sure the module code and number are defined and save the message
    if (!preg_match('/^poll[\s]+([A-Za-z0-9]+)[\s]+(.+)$/', strtolower($_GET['Body']), $message)){
      $this->load->view('twiml.php', array('message' => 'Invalid request here!'));
      return;
    }


    $poll_name = $message[1];
    $poll_id = 0;

    // first obtain the teacher's id    
    $r = $this->db->query('SELECT user_id FROM user_profiles WHERE phone_number=?', array($_GET['To']));
    $results = $r->result_array();

    // if there is no such teacher, throw error -- error works!
    $teacher_id = 0;
    if ($results == null) {
	$this->load->view('twiml.php', array('message' => 'Sorry, the number you are trying to reach is not registered.'));
	return;
    }
    else {
	$teacher_id = $results[0]['user_id'];
    }
    
    // figure out what the class id is - error works!
    $r = $this->db->query('SELECT classID FROM polls WHERE name=? AND teacherID=?', array($poll_name, $teacher_id));
    $results = $r->result_array();

    $class_id = 0;
    if ($results == null) {
	$this->load->view('twiml.php', array('message' => 'Sorry, there is no such poll for your class.'));
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

    // make sure the poll is still open before posting a response
    $r = $this->db->query('SELECT UNIX_TIMESTAMP(closing_time) AS c FROM polls WHERE pollID =? AND teacherID =? AND classID =?', 
			    array($poll_id, $teacher_id, $class_id));
    $results = $r->result_array();

    $closing_time = ($results[0]['c']);
    $now = time();
    if ($now > $closing_time) {
	$this->load->view('twiml.php', array('message' => 'Sorry, this poll has closed.'));
	return;
    }
      
    // response should be the rest of the message
    $response = $message[2];

    // make sure the message matches the type of poll
    $r = $this->db->query('SELECT type FROM polls WHERE pollID=? AND teacherID=? AND classID=?', array($poll_id, $teacher_id, $class_id));
    $results = $r->result_array();
    $type = $results[0]['type'];

    if ($type == 'mc') {
	// make sure the responses are a, b, c, d
	if ($response != "A" && $response != "a" && $response != "B" && $response != "b" && 
	    $response != "C" && $response != "c" && $response != "D" && $response != "d") {
	  $this->load->view('twiml.php', array('message' => 'Your response must be one of: a, b, c, or d.'));
	  return;
	}
    }

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


 }

  function addPoll($classID) {

      // first obtain all the values for the poll
      $name = isset($_POST['name']) ? trim($_POST['name']) : '';
      $teacherID = $this->tank_auth->get_user_id();
      $closingTime = strtotime($_POST['closingtime']);
      $type = ($_POST['polltype']);

      if ($name == '') {
	  echo "You must enter a poll name.";
	  return;
      }

      if ($type == null) {
	  echo "You forgot to select a poll type.";
	  return;
      }

      if ($closingTime == null) {
	  echo "You forgot to select a closing time.";
	  return;
      }
      
      // check if there's already a poll with that name
      $r = $this->db->query('SELECT COUNT(*) AS count FROM polls WHERE name=? AND classID=?', array($name, $classID));
      $results = $r->result_array();
      $count = $results[0]['count'];

      if ($count > 0) {
	  echo "You already have a poll with that name for this class.";
	  return;
      }
	
      // check closing time
      $now = time();
      if ($now > $closingTime) {
	  echo "You must choose a closing time in the future.";
	  return;
      }

      // once we know all the values, we want to add a poll entry to the database table polls

      $this->db->query('INSERT INTO polls (name, teacherID, classID, closing_time, type)
		      VALUES (?, ?, ?, FROM_UNIXTIME(?), ?)', array($name, $teacherID, $classID, ($closingTime), $type));

      echo "Your poll has been successfully created!"; 

  
  }
  
  function deletePoll($classID) {


      // first obtain all the values for the poll to be deleted
      $poll_id = $_POST['pollselect'];
      $teacherID = $this->tank_auth->get_user_id();

      if ($poll_id == null) {
	  echo "You forgot to select a poll.";
	  return;
      }

      // first delete all the responses pertaining to that poll
      $r = $this->db->query('DELETE FROM poll_responses WHERE pollID =? AND teacherID =?', array($poll_id, $teacherID));

      // then delete the poll entry itself
      $r = $this->db->query('DELETE FROM polls WHERE pollID =? AND teacherID =? AND classID=?', array($poll_id, $teacherID, $classID));
  
      echo "Your poll and all its responses were successfully deleted!";
  }

  function analyzePoll($class_id) {

      $poll_id = $_POST['pollselect'];
      $teacher_id = $this->tank_auth->get_user_id();

      if ($poll_id == null) {
	  echo "You forgot to select a poll.";
	  return;
      }

      // if there are no responses, display that
      $r = $this->db->query('SELECT COUNT(*) AS count FROM poll_responses WHERE teacherID =? AND pollID =?', 
			      array($teacher_id, $poll_id));
      $results = $r->result_array();
      $count = $results[0]['count'];
      
      if ($count == 0) {
	  echo "There are no responses yet for this poll.";
	  return;
      }      

      // poll name
      $r = $this->db->query('SELECT name FROM polls WHERE pollID =?', array($poll_id));
      $results = $r->result_array();
      $name = $results[0]['name'];

      // see which type of poll it is
      $r = $this->db->query('SELECT type FROM polls WHERE pollID =?', array($poll_id));
      $results = $r->result_array();
      $type = $results[0]['type'];

      if ($type == 'mc') {
	
// 	// first make sure the poll is closed
// 	$r = $this->db->query('SELECT closing_time FROM polls WHERE pollID =?', array($poll_id));
// 	$results = $r->result_array();
// 	$closing_time = $results[0]['closing_time'];
// 	$current_time = time();
// 	if ($current_time < $closing_time) {
// 	  echo "Sorry, this poll is still open.  You must wait until it has closed to view the data.";
// 	  return;
// 	}
	  
	  // figure out the values for each type of response (A-D)

	  //SELECT SUM(IF(response='a', 1, 0)) as a, SUM(IF(response='b', 1, 0)) as b, SUM(IF(response='c', 1, 0)) as c, SUM(IF(response='d', 1, 0)) as d FROM poll_responses WHERE teacherID =5 AND pollID =39

	  // number of responses with A
	  $r = $this->db->query('SELECT COUNT(*) AS count FROM poll_responses WHERE teacherID =? AND pollID =? 
				  AND response =?', array($teacher_id, $poll_id, 'a'));
	  $results = $r->result_array();
	  $a = $results[0]['count'];

	  // number of responses with B
	  $r = $this->db->query('SELECT COUNT(*) AS count FROM poll_responses WHERE teacherID =? AND pollID =? 
				  AND response =?', array($teacher_id, $poll_id, 'b'));
	  $results = $r->result_array();
	  $b = $results[0]['count'];

	  // number of responses with C
	  $r = $this->db->query('SELECT COUNT(*) AS count FROM poll_responses WHERE teacherID =? AND pollID =? 
			AND response =?', array($teacher_id, $poll_id, 'c'));
	  $results = $r->result_array();
	  $c = $results[0]['count'];       

	  // number of responses with D
	  $r = $this->db->query('SELECT COUNT(*) AS count FROM poll_responses WHERE teacherID =? AND pollID =? 
			AND response =?', array($teacher_id, $poll_id, 'd'));
	  $results = $r->result_array();
	  $d = $results[0]['count'];      
	  /*header('Content-type: application/json');
	  echo json_encode(array(
	    'name' => $name,
	    'data' => array(
	      array('Response', 'Count'),
	      array('A', $a),
	      array('B', $b),
	      array('C', $c),
	      array('D', $d),
	    )
	  ));*/
	  ?> 
	    <html>
	      <head>
		<script type="text/javascript" src="https://www.google.com/jsapi"></script>
		<script type="text/javascript">
		  /*$.getScript('https://www.google.com/jsapi',
		    function(){*/
		      google.load("visualization", "1", {packages:["corechart"]});
		      drawChart = function () {
			var data = google.visualization.arrayToDataTable([
			  ['Response', 'Count'],
			  ['A',  <?php echo $a ?>],
			  ['B',  <?php echo $b ?>],
			  ['C',  <?php echo $c ?>],
			  ['D',  <?php echo $d ?>]
			]);

			var options = {
			  title: 'Responses for poll:  <?php echo $name ?>'
			};

			var chart = new google.visualization.PieChart(document.getElementById('chart_div'));
			chart.draw(data, options);
		      }
		      google.setOnLoadCallback(drawChart);
// 		    }
// 		  );
		</script>
	      </head>
	      <body>
		<div id="chart_div" style="width: 900px; height: 500px;"></div>
	      </body>
	    </html>
	  <?php 
      }
      elseif ($type == 'fr') {

	  // first obtain all the student responses
	  $teacher_id = $this->tank_auth->get_user_id();

	  $r = $this->db->query('SELECT students.id, students.name, poll_responses.response FROM poll_responses 
				  INNER JOIN students ON poll_responses.studentID = students.id 
				  WHERE poll_responses.teacherID =? AND poll_responses.pollID =?', 
				array($teacher_id, $poll_id));
	  $results = $r->result_array();
	  
	  ?> <link rel="Stylesheet" type="text/css" href="/assets/stylesheets/bootstrap.css">
	  <link rel="Stylesheet" type="text/css" href="/assets/stylesheets/modules/poll.css"> 
  
	  <table class="table table-bordered">
	    <thead>
	      <tr>
		<th>#</th>
		<th>Student Name</th>
		<th>Student Response</th>
	      </tr>
	    </thead>

	    <tbody>
	      <?php


	      foreach ($results as $j => $currresponse) {
		$id = $results[$j]['id'];
		$name = $results[$j]['name'];
		$response = $results[$j]['response'];

	      ?>

		<tr>
		  <td><?= htmlspecialchars($id) ?></td>
		  <td><?= htmlspecialchars($name) ?></td>
		  <td><?= htmlspecialchars($response) ?></td>
		</tr>
	      
	      <?php 
	      } 
	      ?>
	  </tbody>
	</table>
	<?php

      }

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