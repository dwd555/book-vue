<?php
header("Content-Type:application/json;charset=UTF-8");
@$kid=$_REQUEST['kid'] or die('{"msg":"kid required"}');
@$selected=$_REQUEST['selected'] or die('{"msg":"selected required"}');
require("init.php");
$sql="UPDATE cartlist SET selected='$selected' WHERE kid='$kid'";
$result=mysqli_query($conn,$sql);
if($result==false){
    echo '{"msg":"err"}';
}else{
    echo '{"msg":"succ"}';
}