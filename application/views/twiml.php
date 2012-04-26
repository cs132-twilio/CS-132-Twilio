<?
if ($redirect){
  header('Content-type: text/xml');
  echo '<?xml version="1.0" encoding="UTF-8"?><Response><Redirect method="' . ($method ? $method : 'GET') . '">' . $redirect . '</Redirect></Response>';
} else{
  header('Content-type: text/plain');
  echo $message;
}
?>