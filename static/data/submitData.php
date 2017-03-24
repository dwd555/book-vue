<?php
header("Content-Type:application/json;charset=UTF-8");
@$uid=$_REQUEST['uid'] or die('{"msg":"uid required"}');

require("init.php");
$sql="SELECT cid FROM cart WHERE uid='$uid'";
$result=mysqli_query($conn,$sql);
$row=mysqli_fetch_row($result);
$cid=$row[0];

$sql="INSERT INTO myorder(cid,bid,count,price) SELECT cid,bid,count,single_price FROM cartlist WHERE cartlist.selected=5 && cartlist.cid='$cid'";

$result=mysqli_query($conn,$sql);
if($result==false){
	echo '{"msg":"error"}';
}else{
	echo '{"msg":"succ"}';
}

