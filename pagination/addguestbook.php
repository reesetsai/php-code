<?php
ini_set('display_errors', '1');
require_once('config.php');
// Connect to server and select database.
$mysqli = new mysqli($host, $username, $password, $db_name);

if($mysqli->connect_error) {
		die('Connect Error: ' . $mysqli->connect_error);
	}
$mysqli->query("SET NAMES utf8");

$name =$_POST["name"];
$email =$_POST["email"];
$comment =$_POST["comment"];
$datetime=date("y-m-d h:i:s"); //date time
$sql="INSERT INTO guestbook(name, email, comment, datetime)VALUES(?,?,?,?)";
$stmt = $mysqli->prepare($sql);
$stmt->bind_param("ssss",$name,$email,$comment,$datetime);
$stmt->execute();
//check if query successful 
if($stmt){
	 print_r($stmt);
echo "Successful";
echo "<BR>";
// link to view guestbook page
echo "<a href='viewguestbook.php'>View guestbook</a>";
}
else {
echo "ssERROR";
}
$stmt->close();
$mysqli->close();
?>