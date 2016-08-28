<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>阿達第一個留言板</title>
</head>

<body>
<table width="400" border="0" align="center" cellpadding="3" cellspacing="0">
<tr>
<td><strong>View Guestbook | <a href="index.php">Sign Guestbook</a> </strong></td>
</tr>
</table>
<br>

<?php
ini_set('display_errors', '1');

require_once('config.php');
// Connect to server and select database.
// 連接mysqli
$mysqli = new mysqli($host, $username, $password, $db_name); 
if($mysqli->connect_error) {
		die('Connect Error: ' . $mysqli->connect_error);
	}
$mysqli->query("SET NAMES utf8");

//有多少筆資料
$sql="SELECT * FROM `guestbook`ORDER BY email";
$result = $mysqli->query($sql);
//將資料條列
$rows_cnt = $result->num_rows;
//每頁所顯示的資料數量
$per = 4;
//頁數
$pages = ceil($rows_cnt/$per);
//當前所在的頁數 默認為page = 1
if(!isset($_GET["page"])){
	$page = 1;
}else{
	$page = intval($_GET["page"]);
}
//從哪一筆資料開始取得
$start = ($page-1)*$per;
$query = "SELECT * FROM `guestbook` LIMIT $start, $per";
$result = $mysqli->query($query);

$url = $_SERVER["REQUEST_URI"];
$url = parse_url($url);
$url = $url['path'];
$next = $page + 1;
$pre = $page - 1;
	if($page >= $pages){
		$page = $pages;
	}
	if($page >= $pages){
		echo "共 $rows_cnt 筆資料"."&nbsp;&nbsp;".'<a href="'.$url.'?page=1">首頁</a> <a href="'.$url.'?page='.$pre.'">上一頁</a>';
	}
	if($page > 1 && $page < $pages){
		echo "共 $rows_cnt 筆資料"."&nbsp;&nbsp;".'<a href="'.$url.'?page=1">首頁</a> <a href="'.$url.'?page='.$pre.'">上一頁</a> <a href="'.$url.'?page='.$next.'">下一頁</a>';
	}
	if($page < 1){
		$page = 1;
	}
	if($page == 1 ){
		echo "共 $rows_cnt 筆資料"."&nbsp;&nbsp;".'<a href="'.$url.'?page='.$next.'">下一頁</a>';
	}
while($rows = $result->fetch_array(MYSQLI_ASSOC))
	{   
 ?>
<table width="400" border="0" align="center" cellpadding="0" cellspacing="1" bgcolor="#CCCCCC">
<tr>
<td><table width="400" border="0" cellpadding="3" cellspacing="1" bgcolor="#FFFFFF">
<tr>
<td>ID</td>
<td>:</td>
<td><?php echo $rows['id']; ?></td>
</tr>
<tr>
<td width="117">Name</td>
<td width="14">:</td>
<td width="357"><?php echo $rows['name']; ?></td>
</tr>
<tr>
<td>Email</td>
<td>:</td>
<td><?php echo $rows['email']; ?></td>
</tr>
<tr>
<td valign="top">Comment</td>
<td valign="top">:</td>
<td><?php echo $rows['comment']; ?></td>
</tr>
<tr>
<td valign="top">Date/Time </td>
<td valign="top">:</td>
<td><?php echo $rows['datetime']; ?></td>
</tr>
</table></td>
</tr>
</table>

<?php
}
$result->free_result();
$mysqli->close();
?>
	</body>
</html>