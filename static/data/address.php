<?php
header("Content-type:application/json;charset=utf-8");
@$uid=$_REQUEST['uid'] or die('{"msg":"uid required"}');
require("init.php");
$sql="SELECT * FROM address WHERE uid='$uid'";
$result=mysqli_query($conn,$sql);
$list=mysqli_fetch_all($result,MYSQLI_ASSOC);
echo json_encode($list);