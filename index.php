<?php 

/*
  project: Authentication RESTFul API
  author: NottDev
  created At: 31/01/19
*/

require('SimpleRest.php');

header('Content-Type: text/plain');

//Get Request Http Method
$httpMethod = $_SERVER['REQUEST_METHOD'];

//Get Content-Type
$contentType =  explode(";" ,$_SERVER['CONTENT_TYPE'])[0];

//Get Content-Type Auto
$rest = new SimpleRest($contentType);

//Initail
$body = [];
$message = '';
$status = false;

switch ($httpMethod) {

  //Get Data 
  case 'GET':
    $rest->setContentType('application/json');
    $input['username']  = $_GET['username'];
    $input['password'] = $_GET['password'];

    //get data from database
    if($input['username'] == 'admin' && $input['password'] == 1234) {
      $message = "login successfully!";
      $status = true;
      $rest->setHttpStatus(200);
    } else {
      $rest->setHttpStatus(401);
      $message = "login fail!";
    }
    $body['data'] = $input;

    break;
    
  //Insert Data
  case 'POST':

    //List content type form-data and x-www-form-encoded
    $form = ['multipart/form-data', 'application/x-www-form-urlencoded'];

    if(in_array($contentType, $form)) {
      $input['username']  = $_POST['username'];
      $input['password'] = $_POST['password'];
      $body['data'] = $input;
      
    } else {
      $inputJson = file_get_contents('php://input');
      $input = json_decode($inputJson, TRUE);
      $body['data'] = $input;
    }

    //get data from database
    if($input['username'] == 'admin' && $input['password'] == "1234") {
      $message = "login successfully!";
      $status = true;
      $rest->setHttpStatus(200);
    } else {
      $message = "login fail!";
      $rest->setHttpStatus(401);
    }

    break;
    
  //Updata Data
  case 'PUT':
    //TO DO
    break;

  //Delete Data
  case 'DELET':
    //TO DO
    break;
  
  default:
    # code...
    break;
}

$body['success'] = $status;
$body['message'] = $message;
//Return json
echo $rest->response($body);
exit();
