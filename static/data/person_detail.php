<?php
header("Content-type:application/json;charset=utf-8");
@$phone=$_REQUEST['phone'] or die('{"msg":"phone required"}');
require("init.php");
$sql="SELECT * FROM person_detail WHERE phone='$phone'";
$result=mysqli_query($conn,$sql);
$list=mysqli_fetch_assoc($result);
echo json_encode($list);