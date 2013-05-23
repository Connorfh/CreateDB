<?php
require_once("funcs.inc.php");

/*
* Account creation script. Must be run from command line.
*/

if(php_sapi_name() != "cli")
die("This script must be run from a command line.");

// load name csv
// for each account, apply formatting rules (to match AD creation script)
// generate passwords
// create user
// write password csv

$file = fopen($argv[1], "r");
if($file === FALSE)
{
die("could not open file");
}

// check the file layout (not really robust)
$data = fgetcsv($file, 1000, ',');

if($data === FALSE)
die("could not read file");

if($data[0] != "last" && $data[1] != "first" && $data[2] != "initial")
die("data is not formatted properly");

// load the users
$users = array();
while(($data = fgetcsv($file, 100, ",")) !== FALSE)
$users[] = $data;

fclose($file);

$sql = "";
$csv = "Last name,First name,Username,Password\n";

foreach($users as $user)
{
$name = makeUserName($user[1], $user[0], 8);
echo $name;
$password = generatePassword();

$sql .= "CREATE USER '{$name}'@'localhost' IDENTIFIED BY '{$password}';\n";
$sql .= "CREATE USER '{$name}'@'%' IDENTIFIED BY '{$password}';\n";

$csv .= "{$user[1]},{$user[0]},{$name},{$password}\n";
}

$sqlf = fopen("accounts.sql", "w");
fwrite($sqlf, $sql, strlen($sql));
fclose($sqlf);

$csvf = fopen("accounts.csv", "w");
fwrite($csvf, $csv, strlen($csv));
fclose($csvf);

echo <<< EOT
Two files have been created: accounts.sql and accounts.csv. Look over
both of them.

accounts.sql is to be run as a user that has create user permission, and
accounts.csv is to be sent to the instructor to distribute to their
students.

EOT;

?>