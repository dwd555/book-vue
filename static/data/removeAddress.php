<?php
header("Content-Type:application/json;charset=UTF-8");
@$aid=$_REQUEST['aid'] or die('{"msg":"kid required"}');
require("init.php");
$sql="DELETE FROM address WHERE aid='$aid'";
$result=mysqli_query($conn,$sql);
if($result==false){
    echo '{"msg":"err"}';
}else{
    echo '{"msg":"succ"}';
}