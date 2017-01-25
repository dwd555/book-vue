<?php
header("Content-Type:application/json;charset=UTF-8");
@$bid=$_REQUEST['bid'] or die('{"msg":"bid required"}');
@$uid=$_REQUEST['uid'] or die('{"msg":"uid required"}');
require("init.php");
$sql="SELECT cid FROM cart WHERE uid='$uid'";
$result=mysqli_query($conn,$sql);
$row=mysqli_fetch_row($result);
$cid=$row[0];

$sql="SELECT newprice FROM books WHERE bid='$bid'";
$result=mysqli_query($conn,$sql);
$row=mysqli_fetch_row($result);
$single_price=$row[0];

$sql="SELECT cid FROM cartlist WHERE bid='$bid'";
$result=mysqli_query($conn,$sql);
$row=mysqli_fetch_row($result);
if($row==NULL){
    $sql="INSERT INTO cartlist VALUES('NULL','$cid','$bid','1','$single_price','5')";
    $result=mysqli_query($conn,$sql);
}else{
    $sql="UPDATE cartlist SET count=count+1 WHERE bid='$bid'";
    $result=mysqli_query($conn,$sql);
}

/*
$sql="INSERT INTO cartlist VALUES('NULL','$cid','$bid','1','$single_price','5')";
$result=mysqli_query($conn,$sql);
*/
if($result==false){
    echo '{"msg":"err"}';
}else{
    $sql="SELECT sum(count) FROM cartlist WHERE cid=(SELECT cid FROM cart WHERE uid='$uid')";
    $result=mysqli_query($conn,$sql);
    $row=mysqli_fetch_row($result);
    $list=[];
    $list['msg']='succ';
    $list['total']=$row[0];
    echo json_encode($list);
}
