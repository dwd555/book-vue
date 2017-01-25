<?php
header("Content-Type:application/json;charset=UTF-8");
@$kid=$_REQUEST['kid'] or die('{"msg":"kid required"}');
@$count=$_REQUEST['count'] or die('{"msg":"count required"}');
require("init.php");
$sql="UPDATE cartlist SET count='$count' WHERE kid='$kid'";
$result=mysqli_query($conn,$sql);
if($result==false){
    echo '{"msg":"err"}';
}else{
    echo '{"msg":"succ"}';
}