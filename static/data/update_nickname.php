<?php
header("Content-Type:application/json;charset=UTF-8");
$phone=$_REQUEST['phone'] or die('{"msg":"phone required"}');
$nickname=$_REQUEST['nickname'] or die('{"msg":"nickname required"}');
require("init.php");
$sql="UPDATE person_detail SET nickname='$nickname' WHERE phone='$phone'";
$result=mysqli_query($conn,$sql);
if($result===false){
    echo '{"msg":"err"}';
}else{
    echo '{"msg":"succ"}';
}