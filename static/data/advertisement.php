<?php
header("Content-type:application;charset=utf-8");
@$id=$_REQUEST['id'] or die("{'msg':'id required'}");
require('init.php');

$sql="select bid,img_sm,name,newprice,introduction from books where bid!='$id' order by rand() limit 0,4 ";
$result=mysqli_query($conn,$sql);
$list=mysqli_fetch_all($result,MYSQLI_ASSOC);

echo json_encode($list);