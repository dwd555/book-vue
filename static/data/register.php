<?php
header("Content-Type:application/json;charset=UTF-8");
@$phone=$_REQUEST['phone'] or die('{"msg":"phone required"}');
@$pwd=$_REQUEST['pwd'] or die('{"msg":"pwd required"}');
require("init.php");
$sql="SELECT uid FROM book_user WHERE phone='$phone'";
$result=mysqli_query($conn,$sql);
$row=mysqli_fetch_assoc($result);
if($row==null){
    $sql="INSERT INTO book_user VALUES('NULL','$phone','$pwd')";
    $result=mysqli_query($conn,$sql);
    $id=mysqli_insert_id($conn);
    $sql="INSERT INTO cart VALUES('NULL','$id','$phone')";
    $result=mysqli_query($conn,$sql);
    $sql="INSERT INTO person_detail VALUES('NULL','$id','$phone','NULL','NULL')";
    $result=mysqli_query($conn,$sql);
    $output=[];
    $output['uid']=$id;
    $output['phone']=$phone;
    echo json_encode($output);
}else{
    echo '{"msg":"err"}';
}