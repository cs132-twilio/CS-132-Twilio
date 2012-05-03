<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class FlashCards extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
    $this->load->library('twilio');
    $this->load->library('tank_auth');
	}

	function index($c)
	{/*
	  $this->checkauth->check();
	  $this->session->sess_update();
	  $uid = $this->tank_auth->get_user_id();*/
	  $data['decks'] = $this->db->query('SELECT deck_name FROM fl_decks')->result_array();
	  //$data = array();
	  //$data['decks'] = array('a','b','c','d');
	  $this->load->view('/modules/flashcards.php', $data);
	}
	
	

  function post(){
    if ($_SERVER['REQUEST_METHOD'] != 'GET' || !$_GET['Body'] || !$_GET['From'] || !$_GET['To']){
      $this->load->view('twiml.php', array('message' => 'Invalid request!'));
      return;
    }
    $message = preg_split('/[\s]+/', trim($_GET['Body']), 3); 
    // $this->load->view('twiml.php', array('message' => count($message)));
    if (count($message) < 1){
      $this->load->view('twiml.php', array('message' => 'Invalid request!'));
      return;
    }
    $output = '';
    switch(count($message)) {
      // Message format: "FL"
      // Should list available decks
      case 1: 
	$query = $this->db->query('SELECT deck_name FROM fl_decks');
	$output = 'Decks: ';
	if ($query->num_rows() > 0)
	{
	  foreach ($query->result_array() as $row)
	  {
	      $output .= "\n" . $row['deck_name'];
	  }
	}
	break;
      // Message format: "FL nameOfDeck"
      //Should start you off from the beginning, or point you left off
      case 2:     
      $phone_number = $_GET['From'];
      $deck_code = $message[1];
      // Get the student's ID number from the phone number
      $query = $this->db->query('SELECT id FROM students WHERE number = ? LIMIT 1', array($phone_number));
      $student_id = 0;
      if ($query->num_rows() > 0)
      {
	$row = $query->row_array();
	$student_id = $row['id'];
      }
      if ($student_id==0) {
	$this->load->view('twiml.php', array('message' => "Sorry, you are not registered for any of this number's classes."));
	return;      
      }  
      
      // get the ID number of the deck
      $query = $this->db->query('SELECT deck_id FROM fl_decks WHERE deck_name = ? LIMIT 1', array($deck_code));
      $deck_id = 0;
      if ($query->num_rows() > 0)
      {
	$row = $query->row_array();
	$deck_id = $row['deck_id'];
      }
      if ($deck_id==0) {
	$this->load->view('twiml.php', array('message' => "Sorry, that deck does not exist. Reply with 'FL' to see a list of decks. "));
	return;     
      }
      
      // get the deck position number for this student
      $query = $this->db->query('SELECT position, answer FROM fl_students WHERE student_id = ? AND deck_id = ? LIMIT 1', array($student_id, $deck_id));
      $position = 1;
      $answer = 0;
      if ($query->num_rows() > 0)
      {
	$row = $query->row_array();
	$position = $row['position'];
	$answer = $row['answer'];
      }
      else {
	$this->db->query('INSERT INTO fl_students (student_id, deck_id, position, answer) 
				    VALUES(?,?,1,0)', array($student_id, $deck_id));      
      }
      
      // get the card
      $query = $this->db->query('SELECT question, answer FROM fl_cards WHERE position = ? AND deck_id = ? LIMIT 1', array($position, $deck_id));
      if ($query->num_rows() > 0)
      {
	$row = $query->row_array();
	$question_txt = $row['question'];
	$answer_txt = $row['answer'];
	$content = ($answer==0) ? $question_txt : $answer_txt;
	$total_query = $this->db->query('SELECT COUNT(*) as "numcards" FROM fl_cards WHERE deck_id = ?', array($deck_id));
	if ($total_query->num_rows() > 0)
	{

	    $total_row = $total_query->row_array();
	    $total_cards = $total_row['numcards'];   
	    
	    $prefix = "(" . $position . "/" . $total_cards . ") ";
	    $prefix .= ($answer==0) ? "Q: " : "A: ";
	    $output = $prefix . $content;
	}
	else {
	  $output = 'Error determining total cards in deck.';
	}
	
      }
      else {
	$output = 'Sorry, there is no card with that number in this deck. ' . $position . ' | ' . $deck_id;
      }
      break;
      
      
      
      // Message format: "FL nameOfDeck [command]"
      // 	Where command is one of the following: flip, next, reset, [number]
      // flip: give the answer to the current card
      // next: go to the next question
      // reset: go to the first question
      // [number]: go to the question with that number
      case 3:
      $phone_number = $_GET['From'];
      $deck_code = $message[1];
      $command = trim($message[2]);
      // Get the student's ID number from the phone number
      $query = $this->db->query('SELECT id FROM students WHERE number = ? LIMIT 1', array($phone_number));
      $student_id = 0;
      if ($query->num_rows() > 0)
      {
	$row = $query->row_array();
	$student_id = $row['id'];
      }
      if ($student_id==0) {
	$this->load->view('twiml.php', array('message' => "Sorry, you are not registered for any of this number's classes."));
	return;      
      }  
      
      // get the ID number of the deck
      $query = $this->db->query('SELECT deck_id FROM fl_decks WHERE deck_name = ? LIMIT 1', array($deck_code));
      $deck_id = 0;
      if ($query->num_rows() > 0)
      {
	$row = $query->row_array();
	$deck_id = $row['deck_id'];
      }
      if ($deck_id==0) {
	$this->load->view('twiml.php', array('message' => "Sorry, that deck does not exist. Reply with 'FL' to see a list of decks. "));
	return;     
      }
      $position = 1;
      $answer = 0;
      switch(strtolower($command)) {
	
	case 'flip':
	  // get the deck position number for this student
	  $query = $this->db->query('SELECT position, answer FROM fl_students WHERE student_id = ? AND deck_id = ? LIMIT 1', array($student_id, $deck_id));
	  $position = 1;
	  $answer = 0;
	  if ($query->num_rows() > 0)
	  {
	    $row = $query->row_array();
	    $position = $row['position'];
	    $answer = $row['answer'];
	    $answer = ($answer==1) ? 0 : 1;
	    $this->db->query('UPDATE fl_students 
			      SET answer = ?
			      WHERE student_id = ? AND deck_id = ?', array($answer, $student_id, $deck_id)); 
	  }
	  else {
	    $this->db->query('INSERT INTO fl_students (student_id, deck_id, position, answer) 
					VALUES(?,?,1,0)', array($student_id, $deck_id));      
	  }	
	  break;
	case 'next':
	  // get the deck position number for this student
	  $query = $this->db->query('SELECT position, answer FROM fl_students WHERE student_id = ? AND deck_id = ? LIMIT 1', array($student_id, $deck_id));
	  $total_query = $this->db->query('SELECT COUNT(*) as "numcards" FROM fl_cards WHERE deck_id = ?', array($deck_id));
	  $total_cards = 0;
	  if ($total_query->num_rows() > 0)
	  {
	      $total_row = $total_query->row_array();
	      $total_cards = $total_row['numcards'];   	      
	  }
	  $position = 1;
	  $answer = 0;
	  if ($query->num_rows() > 0)
	  {
	    $row = $query->row_array();
	    $position = $row['position'];
	    if ($position < $total_cards) {
	      $position = $position + 1;
	    }
	    else {
	      $position = 1;
	    }
	    $this->db->query('UPDATE fl_students 
			      SET position = ?, answer = 0 			      
			      WHERE student_id = ? AND deck_id = ?', array($position, $student_id, $deck_id)); 
	  }
	  else {
	    $this->db->query('INSERT INTO fl_students (student_id, deck_id, position, answer) 
					VALUES(?,?,1,0)', array($student_id, $deck_id));      
	  }	
	  break;
	case 'reset':	  
	   // get the deck position number for this student
	  $query = $this->db->query('SELECT position, answer FROM fl_students WHERE student_id = ? AND deck_id = ? LIMIT 1', array($student_id, $deck_id));
	  $position = 1;
	  $answer = 0;
	  if ($query->num_rows() > 0)
	  {
	    $this->db->query('UPDATE fl_students 
			      SET position=1, answer = 0
			      WHERE student_id = ? AND deck_id = ?', array($student_id, $deck_id)); 
	  }
	  else {
	    $this->db->query('INSERT INTO fl_students (student_id, deck_id, position, answer) 
					VALUES(?,?,1,0)', array($student_id, $deck_id));      
	  }	
	  break;
	default:
	  $command_num = intval($command);	
	  // get the deck position number for this student
	  $query = $this->db->query('SELECT position, answer FROM fl_students WHERE student_id = ? AND deck_id = ? LIMIT 1', array($student_id, $deck_id));
	  $position = $command_num;
	  $answer = 0;
	  if ($query->num_rows() > 0 && $position > 0)
	  {
	    $this->db->query('UPDATE fl_students 
			      SET position=?, answer = 0
			      WHERE student_id = ? AND deck_id = ?', array($position, $student_id, $deck_id)); 
	  }
	  else if ($position > 0) {
	    $this->db->query('INSERT INTO fl_students (student_id, deck_id, position, answer) 
					VALUES(?,?,?,0)', array($student_id, $deck_id, $position));      
	  }
	  else {
	    $this->load->view('twiml.php', array('message' => "Error, bad number value."));
	    return;
	  }	    
	  break;          
      }
      
      
      // get the card
      $query = $this->db->query('SELECT question, answer FROM fl_cards WHERE position = ? AND deck_id = ? LIMIT 1', array($position, $deck_id));
      if ($query->num_rows() > 0)
      {
	$row = $query->row_array();
	$question_txt = $row['question'];
	$answer_txt = $row['answer'];
	$content = ($answer==0) ? $question_txt : $answer_txt;
	$total_query = $this->db->query('SELECT COUNT(*) as "numcards" FROM fl_cards WHERE deck_id = ?', array($deck_id));
	if ($total_query->num_rows() > 0)
	{

	    $total_row = $total_query->row_array();
	    $total_cards = $total_row['numcards'];   
	    
	    $prefix = "(" . $position . "/" . $total_cards . ") ";
	    $prefix .= ($answer==0) ? "Q: " : "A: ";
	    $output = $prefix . $content;
	}
	else {
	  $output = 'Error determining total cards in deck.';
	}
	
      }
      else {
	$output = 'Sorry, there is no card with that number in this deck. ';
      }
      break;  
	break;
      default:
	$output = "Format: 'FL [nameOfDeck] [flip/next/reset/number]'";
    }

    $this->load->view('twiml.php', array('message' => $output));
    
  }
  
  
  
   function poll($deck){
    header('Content-type: application/json');    
    if (!$this->tank_auth->is_logged_in()) exit(json_encode(array('success' => 0, 'username' => '<span class="stream_error_title">Twexter System Message</span>', 'message' => 'You must be <a href="/auth/login">logged in</a> to read messages!', 'execute' => 'clearInterval(Twexter.FlashCards.loop);')));
    
     /*
    exit(json_encode(array('position' => 1, 'question' => 'hey sup', 'answer' => 'nm, u?')));
    return;*/
    
    //$r = $this->db->query('SELECT position, question, answer FROM fl_cards WHERE deck_name = ?', array($deck))->result_array();
    
    $r = $this->db->query('SELECT position, question, answer 
			   FROM fl_cards 
			   WHERE deck_id IN 
			    (SELECT deck_id 
			     FROM fl_decks 
			     WHERE deck_name = ?)', array($deck))->result_array();
    //echo var_dump($r);
    foreach($r as &$s){
      $s['position'] = htmlentities($s['position']);
      $s['question'] = htmlentities($s['question']);
      $s['answer'] = htmlentities($s['answer']);
    }
    //echo json_encode($r);
    
    //exit(json_encode(array('position' => 1, 'question' => $r[0]['question'], 'answer' => 'nm, u?')));
    
    exit(json_encode($r));
    return;
    
  }
  
  function adddeck() {
    header('Content-type: application/json');    
    if (!$this->tank_auth->is_logged_in()) exit(json_encode(array('success' => 0, 'message' => 'You must be logged in to add decks!')));
    
    $deck_name_split = preg_split('/[\s]+/', trim($_POST['deckname']), 3); 
    if(count($deck_name_split)>1) {
      exit(json_encode(array('success' => 0, 'message' => 'Sorry, deck names must only be one word.')));
    }
    else {
      $deck_name = $deck_name_split[0];
      $r = $this->db->query('SELECT * 
			   FROM fl_decks			   
			   WHERE deck_name = ?', array($deck_name))->result_array();
      if(count($r)>0) {
	exit(json_encode(array('success' => 0, 'message' => 'Sorry, a deck with that name already exists.')));
      }
      else {
	$this->db->query('INSERT INTO fl_decks (deck_name)
				VALUES(?)', array($deck_name)); 
	exit(json_encode(array('success' => 1, 'message' => 'Deck "' . $deck_name. '" added successfully!')));
      }    
      
    }
  
  }
  
  
  function addcard() {
    header('Content-type: application/json');    
    if (!$this->tank_auth->is_logged_in()) exit(json_encode(array('success' => 0, 'message' => 'You must be logged in to add cards!')));
    
    $question = trim($_POST['question']);
    $answer = trim($_POST['answer']); 
    $deck_name = trim($_POST['deckname']);  
    if(strlen($question)>150||strlen($answer)>150) {
      exit(json_encode(array('success' => 0, 'message' => 'Sorry, questions and answers are limited to 150 characters each.')));
    }
    else {
	$r = $this->db->query('SELECT deck_id 
			   FROM fl_decks			   
			   WHERE deck_name = ?', array($deck_name))->result_array();
      if(count($r)<1) {
	exit(json_encode(array('success' => 0, 'message' => 'Sorry, no deck with that name exists. ')));
      }
      else {
	$deck_id = $r[0]['deck_id'];
	$last_position = $this->db->query('SELECT MAX(position) AS maxpos 
			   FROM fl_cards			   
			   WHERE deck_id = ?', array($deck_id))->result_array();
	$next_position = intval($last_position[0]["maxpos"]) + 1;	
	
	$this->db->query('INSERT INTO fl_cards (deck_id,position,question,answer)
				VALUES(?,?,?,?)', array($deck_id,$next_position,$question,$answer)); 
	exit(json_encode(array('success' => 1, 'message' => 'Card Q:"' . $question . '" A:"' . $answer .  '" added successfully!')));
      }          
      
    }
  
  }
  
 function deletecard() {
    header('Content-type: application/json');    
    if (!$this->tank_auth->is_logged_in()) exit(json_encode(array('success' => 0, 'message' => 'You must be logged in to delete cards!')));
    
    $delete_positions = $_POST['deletecard'];
    exit(json_encode(array('success' => 0, 'message' => var_dump($delete_positions))));
    return;
    
    
    $answer = trim($_POST['answer']); 
    $deck_name = trim($_POST['deckname']);  
    if(strlen($question)>150||strlen($answer)>150) {
      exit(json_encode(array('success' => 0, 'message' => 'Sorry, questions and answers are limited to 150 characters each.')));
    }
    else {
	$r = $this->db->query('SELECT deck_id 
			   FROM fl_decks			   
			   WHERE deck_name = ?', array($deck_name))->result_array();
      if(count($r)<1) {
	exit(json_encode(array('success' => 0, 'message' => 'Sorry, no deck with that name exists. ')));
      }
      else {
	$deck_id = $r[0]['deck_id'];
	$last_position = $this->db->query('SELECT MAX(position) AS maxpos 
			   FROM fl_cards			   
			   WHERE deck_id = ?', array($deck_id))->result_array();
	$next_position = intval($last_position[0]["maxpos"]) + 1;	
	
	$this->db->query('INSERT INTO fl_cards (deck_id,position,question,answer)
				VALUES(?,?,?,?)', array($deck_id,$next_position,$question,$answer)); 
	exit(json_encode(array('success' => 1, 'message' => 'Card Q:"' . $question . '" A:"' . $answer .  '" added successfully!')));
      }          
      
    }
  
  }
  
   
  
  
}
  
  

  
  
  
  

 