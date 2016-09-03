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
define('GW_UPLOADPATH', 'images/');
ini_set('display_errors', '1');

$host="sql105.byethost7.com"; // Host name 
	$username="b7_18192051"; // Mysql username 
	$password="jhjhandy"; // Mysql password 
	$db_name="b7_18192051_guestbook"; // Database name 
	$tbl_name="guestbook"; // Table name
// Connect to server and select database.
// 連接mysqli
$mysqli = new mysqli($host, $username, $password, $db_name); 
if($mysqli->connect_error) {
		die('Connect Error: ' . $mysqli->connect_error);
	}
$mysqli->query("SET NAMES utf8");

//有多少筆資料
$sql="SELECT * FROM `guestbook`ORDER BY id";
$result = $mysqli->query($sql);
//將資料條列
$rows_cnt = $result->num_rows;
//每頁所顯示的資料數量
$per = 1;
//頁數
$pages = ceil($rows_cnt/$per);
//當前所在的頁數 默認為page = 1
if(!empty($_GET['page'])){
	$page = $_GET['page'];
}else{
	$page = 1;
}
//從哪一筆資料開始取得
$start = ($page-1)*$per;
//資料從$start開始,取出$per條
$query = "SELECT * FROM `guestbook` ORDER by datetime DESC LIMIT $start, $per";
//將取出的資料丟到變數$result
$result = $mysqli->query($query);
//將檔案所在的url調用出來
$url = $_SERVER["REQUEST_URI"];
$url = parse_url($url);
$url = $url['path'];
$next = $page + 1;
$pre = $page - 1;

function page(){
	global $page;
	global $pages;
	global $url;
	$list = "";
	$num = 3;
	
	
	//當前頁面之前的顯示頁數
for($i=$num; $i>=1; $i--){
	$cpage = $page-$i;
	if($cpage>1){
		$list.= '<a href="'.$url.'?page='.$cpage.'">'."&nbsp".$cpage."&nbsp".'</a>';
		}
}
	//當前頁面
	if($pages >1){
		$list .= "&nbsp;$page&nbsp;";
	}
	//當前頁面之後的顯示頁數
	for($i= 1; $i<$num; $i++){
		$cpage = $page+$i;
		if($cpage<=$pages){
		$list.= '<a href="'.$url.'?page='.$cpage.'">'."&nbsp".$cpage."&nbsp".'</a>';
		}else{
			break;
		}
	}
	return $list;
}

	if($page >= $pages){
		echo "共 $rows_cnt 筆資料"."&nbsp;&nbsp;".'<a href="'.$url.'?page=1">首頁</a>'.page().'<a href="'.$url.'?page='.$pre.'">上一頁</a>';
	}
	if($page > 1 && $page < $pages){
		echo "共 $rows_cnt 筆資料"."&nbsp;&nbsp;".'<a href="'.$url.'?page=1">首頁</a>'.page().'<a href="'.$url.'?page='.$pre.'">上一頁</a> <a href="'.$url.'?page='.$next.'">下一頁</a>';
	}
	if($page <= 1){
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
<tr>
<td valign="top">picture</td>
<td valign="top">:</td>
<?php
if($rows['picture'] != ""){
	 $pic =$rows['picture'];
	echo "<td><img src ='$pic'></td>";
}
?>
</tr>
<tr>
<td valign="top">ip</td>
<td valign="top">:</td>
<td><?php echo $rows['user_ip']; ?></td>
</tr>
</table></td>
</tr>
</table>

<?php
} echo $target ; 
$result->free_result();
$mysqli->close();
?>
	</body>
</html>