<?php
header("Content-Type:application/json;charset=UTF-8");
@$uid=$_REQUEST['uid'] or die('{"msg":"uid required"}');
@$selected=$_REQUEST['selected'] or die('{"msg":"selected required"}');
require("init.php");
$sql="UPDATE cartlist SET selected='$selected' WHERE cid=(SELECT cid FROM cart WHERE uid='$uid')";
$result=mysqli_query($conn,$sql);
if($result==false){
    echo '{"msg":"err"}';
}else{
    echo '{"msg":"succ"}';
}