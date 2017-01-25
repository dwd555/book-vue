<?php
header("Content-type:application/json;charset=utf-8");
@$kw=$_REQUEST['kw'];
require("init.php");
if(empty($kw))
{
    echo '[]';
    return ;
}
$sql="SELECT * FROM books WHERE name LIKE '%$kw%' OR introduction LIKE '%$kw%' OR author LIKE '%$kw%' or publish LIKE '%$kw%'";
$result=mysqli_query($conn,$sql);
$list=mysqli_fetch_all($result,MYSQLI_ASSOC);
echo json_encode($list);