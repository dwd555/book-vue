<?php
header("Content-type:application/json;charset=utf-8");
@$uid=$_REQUEST['uid'] or die('{"msg":"uid required"}');
@$aid=$_REQUEST['aid'];
require("init.php");
//$sql="INSERT INTO address VALUES(NULL,'$uid','$name','$phone','$address','6')";
$sql="UPDATE address SET choose='6' WHERE choose='5' AND uid='$uid'";
$result=mysqli_query($conn,$sql);
$sql="UPDATE address SET choose='5' WHERE aid='$aid'";
$result=mysqli_query($conn,$sql);
if($result==false){
	echo '{"msg":"err"}';
}else{
	echo '{"msg":"succ"}';
}