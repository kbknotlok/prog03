<?php

session_start();

// include the class that handles database connections
require "../prog01/database.php";

// include the class containing functions/methods for "customer" table
// Note: this application uses "customer" table, not "cusotmers" table
require "customer.class.php";
$cust = new Customer();

/*
if ( !empty($_POST)) { // if $_POST filled then process the form
	// initialize $_POST variables
	$username = $_POST['username']; // username is email address
	$password = $_POST['password'];
	$passwordhash = MD5($password);
	// echo $password . " " . $passwordhash; exit();
	// robot 87b7cb79481f317bde90c116cf36084b
		
	// verify the username/password
	$pdo = Database::connect();
	$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	$sql = "SELECT * FROM fr_persons WHERE email = ? AND password = ? LIMIT 1";
	$q = $pdo->prepare($sql);
	$q->execute(array($username,$passwordhash));
	$data = $q->fetch(PDO::FETCH_ASSOC);
	
	if($data) { // if successful login set session variables
		echo "success!";
		$_SESSION['fr_person_id'] = $data['id'];
		$sessionid = $data['id'];
		$_SESSION['fr_person_title'] = $data['title'];
		Database::disconnect();
		header("Location: fr_assignments.php?id=$sessionid ");
		// javascript below is necessary for system to work on github
		echo "<script type='text/javascript'> document.location = 'fr_assignments.php'; </script>";
		exit();
	}
	else { // otherwise go to login error page
		Database::disconnect();
		header("Location: customers.php?fun=");
	}
} 

*/
 
// set active record field values, if any 
// (field values not set for display_list and display_create_form)
if(isset($_GET["id"]))          $id = $_GET["id"]; 
if(isset($_POST["name"]))       $cust->name = htmlspecialchars($_POST["name"]);
if(isset($_POST["email"]))      $cust->email = htmlspecialchars($_POST["email"]);
if(isset($_POST["mobile"]))     $cust->mobile = htmlspecialchars($_POST["mobile"]);
if(isset($_POST["username"]))   $cust->username = htmlspecialchars($_POST["username"]);
if(isset($_POST["password"]))   $cust->password = htmlspecialchars($_POST["password"]);

// "fun" is short for "function" to be invoked 
if(isset($_GET["fun"])) {
	$fun = $_GET["fun"];
	if (!isset($_SESSION["user_id"])) { // if not logged in
		if (!($fun == "display_create_form" || $fun == "check_login" || $fun == "insert_db_record")) { // if not going to allowed page, then go to login page
			$fun="display_login_view";
		}
	}
}
else $fun = "display_login_view"; 

switch ($fun) {
	case "logout":				$cust->logout();
		break;
	case "check_login":			$cust->check_login();
		break;
	case "display_login_view":  $cust->login_view();
		break;
    case "display_list":        $cust->list_records();
        break;
    case "display_create_form": $cust->create_record();
        break;
    case "display_read_form":   $cust->read_record($id); 
        break;
    case "display_update_form": $cust->update_record($id);
        break;
    case "display_delete_form": $cust->delete_record($id); 
        break;
    case "insert_db_record":    $cust->insert_db_record();
        break;
    case "update_db_record":    $cust->update_db_record($id);
        break;
    case "delete_db_record":    $cust->delete_db_record($id);
        break;
    default: 
        echo "Error: Invalid function call (customer.php)";
        exit();
        break;
}
