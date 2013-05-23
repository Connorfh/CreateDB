<?php

define("DBCREATE_VERSION", "0.3");
/*
 * Configuration. Supports putting local config in a separate file to keep passwords out of git.
 */

$config = array(
	"host" => "athena",
	"user" => "dbcreate",
	"password" => "dbcreatepassword",
	"testDB" => ""//"authtest"
);

if(file_exists("config.local.inc.php"))
	require_once("config.local.inc.php");

?>