<?php
header("Content-Type:application/json;charset=UTF-8");
@$bid=$_REQUEST['bid'] or die('{"msg":"bid required"}');
@$uid=$_REQUEST['uid'] or die('{"msg":"uid required"}');
@$count=$_REQUEST['count'] or die('{"msg":"count required"}');

require("init.php");
$sql="SELECT cid FROM cart WHERE uid='$uid'";
$result=mysqli_query($conn,$sql);
$row=mysqli_fetch_row($result);
$cid=$row[0];

$sql="SELECT newprice FROM books WHERE bid='$bid'";
$result=mysqli_query($conn,$sql);
$row=mysqli_fetch_row($result);
$single_price=$row[0];

$sql="UPDATE cartlist SET selected=6 WHERE selected=5 AND cid='$cid'";//将所有选中的都变成不选中
$result=mysqli_query($conn,$sql);

$sql="SELECT cid FROM cartlist WHERE cid='$cid' AND bid='$bid'";
$result=mysqli_query($conn,$sql);
$row=mysqli_fetch_row($result);
//var_dump($row);
if($row==NULL){
    $sql="INSERT INTO cartlist VALUES('NULL','$cid','$bid','$count','$single_price','5')";//购物车没有这本书则插入，并让他选中
    $result=mysqli_query($conn,$sql);
}else{
    //$sql="UPDATE cartlist SET count=count+1 WHERE bid='$bid' AND cid='$cid'";
     $sql="UPDATE cartlist SET count='$count',selected='5' WHERE bid='$bid' AND cid='$cid'";//购物车有这本书的话,更新数量，且让他选中
    $result=mysqli_query($conn,$sql);
}

if($result==false){
    echo '{"msg":"err"}';
}else{
   echo '{"msg":"succ"}';
}
