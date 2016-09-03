<?php
ini_set('display_errors', '1');
define('GW_UPLOADPATH', 'images/');
$host="sql105.byethost7.com"; // Host name 
	$username="b7_18192051"; // Mysql username 
	$password="jhjhandy"; // Mysql password 
	$db_name="b7_18192051_guestbook"; // Database name 
	$tbl_name="guestbook"; // Table name
// Connect to server and select database.
$mysqli = new mysqli($host, $username, $password, $db_name);

if($mysqli->connect_error) {
		die('Connect Error: ' . $mysqli->connect_error);
	}
$mysqli->query("SET NAMES utf8");


if (!empty($_SERVER['HTTP_CLIENT_IP']))
{
  $ip=$_SERVER['HTTP_CLIENT_IP'];
}
else if (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))
{
  $ip=$_SERVER['HTTP_X_FORWARDED_FOR'];
}
else if (!empty($_SERVER['HTTP_X_FORWARDED']))
{
  $ip=$_SERVER['HTTP_X_FORWARDED'];
}
else if (!empty($_SERVER['HTTP_X_CLUSTER_CLIENT_IP']))
{
  $ip=$_SERVER['HTTP_X_CLUSTER_CLIENT_IP'];
}
else if (!empty($_SERVER['HTTP_FORWARDED_FOR']))
{
  $ip=$_SERVER['HTTP_FORWARDED_FOR'];
}
else if (!empty($_SERVER['HTTP_FORWARDED_FOR']))
{
  $ip=$_SERVER['HTTP_FORWARDED_FOR'];
}
else
{
  $ip=$_SERVER['REMOTE_ADDR'];
}

	$name =$_POST["name"];
	$email =$_POST["email"];
	$comment =$_POST["comment"];
	$datetime=date("y-m-d h:i:s"); //date time

if($_FILES){
		echo $_FILES.'55';
		$picture = $_FILES['picture']['name'];
		$picture_tmp = $_FILES['picture']['tmp_name'];
		$target = GW_UPLOADPATH.$picture;
		if($picture !== ""){
		move_uploaded_file($picture_tmp, "../guestbook/".$picture);
		$path = "../guestbook/".$picture;
		echo "$path<br>";
		}
		else{
			$path = "";
			echo "$path<br>";
		}
	}
/*if($picture_type){
	case 'image/pjpeg' : 
			$ok = 1;
		break;
	case 'image/jpeg' : 
			$ok = 1;
		break;
	case 'image/gif' : 
			$ok = 1;
		break;
	case 'image/png' : 
			$ok = 1;
		break;
	}*/
	//if($ok ==1){
		$sql="INSERT INTO guestbook(name, email, comment, datetime, picture, user_ip)VALUES(?,?,?,?,?,?)";
		$stmt = $mysqli->prepare($sql);
		$stmt->bind_param("ssssss",$name,$email,$comment,$datetime,$path,$ip);
		$stmt->execute();
	//}

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