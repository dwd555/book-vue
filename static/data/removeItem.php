<?php
header("Content-Type:application/json;charset=UTF-8");
@$kid=$_REQUEST['kid'] or die('{"msg":"kid required"}');
require("init.php");
$sql="DELETE FROM cartlist WHERE kid='$kid'";
$result=mysqli_query($conn,$sql);
if($result==false){
    echo '{"msg":"err"}';
}else{
    echo '{"msg":"succ"}';
}