<?php
/*
 * AJAX calls.
 * 
 * Response format:
 * {
 * 	error:			"none" | "badUsername" | "dbNameTaken" | "internalError",
 * 	dbName:			string
 * }
 */

require_once("config.inc.php");

$username = $_POST["username"];
$password = $_POST["password"];
$purpose = $_POST["purpose"];   
$dbName = $_POST["dbName"]; 

$fullDBName = $username . '_' . $purpose . '_' . $dbName;

// The client does basic form validation, so the only errors we report are server-generated ones
$json = array(
	"error" => "none",
	"dbName" => $fullDBName,
	"message" => ""
);

/*
 * FUNCTIONS
 */

/*
 * checkConnectionError
 * 
 * Determines if the mysqli $db link has any errors.
 * 
 * $db: The database link.
 * $connect: If true, will check the connection errors instead of other errors.
 */
function checkConnectionError($db, $connect = false)
{
	global $json;
	if($db->connect_errno != 0)
	{
		// figure out the error
		$json["error"] = "internalError";
		switch($db->connect_errno)
		{
			case 1045:	// bad username or password
			{
				$json["error"] = "badUsername";
				if($connect)
					$json["message"] = $db->connect_error . " (error " . $db->connect_errno . ")";
				else
					$json["message"] = $db->error . " (error " . $db->errno . ")";
				break;
			}
			case 2003:	// cannot connect
			{
				if($connect)
					$json["message"] = $db->connect_error . " (error " . $db->connect_errno . ")";
				else
					$json["message"] = $db->error . " (error " . $db->errno . ")";
				break;
			}
			default:
			{
				if($connect)
					$json["message"] = $db->connect_error . " (error " . $db->connect_errno . ")";
				else
					$json["message"] = $db->error . " (error " . $db->errno . ")";
				break;	
			}
		}
	
		$db->close();
		exit(json_encode($json));
	}
}
 
/*
 * AUTHENTICATION
 * 
 * We don't actually execute any commands as the user, but try to log in anyway to make sure they're legit.
 */


$db = @new mysqli($config["host"], $username, $password, $config["testDB"]);
checkConnectionError($db, true);

//We're authenticated now! Logout and come back as root to actually get things done.

$db->close();
 
// then actually do it
// connect()
// create database
// grant * on fulldbname to user@localhost
// grant * on fulldbname to user@%
// flush privileges
// disconnect

// WARNING injection exploit below! TODO remedy immediately!

$db = @new mysqli($config["host"], $config["user"], $config["password"], $config["testDB"]);
checkConnectionError($db, true);

if($db->query("CREATE DATABASE " . $fullDBName) === FALSE)
	checkConnectionError($db);

if($db->query("GRANT ALL ON ".$fullDBName.".* TO ".$username."@'localhost'") === FALSE)
	checkConnectionError($db);

if($db->query("GRANT ALL ON ".$fullDBName.".* TO ".$username."@'%'") === FALSE)
	checkConnectionError($db);

if($db->query("FLUSH PRIVILEGES") === FALSE)
	checkConnectionError($db);

$db->close();

echo json_encode($json);
?>