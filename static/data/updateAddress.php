<?php
header("Content-type:application/json;charset=utf-8");
@$uid=$_REQUEST['uid'] or die('{"msg":"uid required"}');
@$name=$_REQUEST['name'] or die('{"msg":"name required"}');
@$phone=$_REQUEST['phone'] or die('{"msg":"phone required"}');
@$address=$_REQUEST['address'] or die('{"msg":"adress required"}');
require("init.php");
$sql="UPDATE address SET name='$name',phone='$phone',address='$address' WHERE uid='$uid'";
$result=mysqli_query($conn,$sql);
if($result==false){
	echo '{"msg":"err"}';
}else{
	echo '{"msg":"succ"}';
}