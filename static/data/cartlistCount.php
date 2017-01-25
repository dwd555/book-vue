<?php
header("Content-Type:application/json;charset=UTF-8");
@$uid=$_REQUEST['uid'] or die('{"msg":"uid required"}');
require("init.php");
$sql="SELECT sum(count) FROM cartlist WHERE cid=(SELECT cid FROM cart WHERE uid='$uid')";
$result=mysqli_query($conn,$sql);
$row=mysqli_fetch_row($result);
$list=[];
if($result==false){
    echo '{"msg":"err"}';
}else{
	$row[0]=$row[0]==null?0:$row[0];
    $list['count']=$row[0];
    echo json_encode($list);
}