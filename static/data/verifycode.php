<?php
 session_start();
 header("Access-Control-Allow-Origin: *");
 header("Content-type:application/json;charset=utf-8");
 @$authcode=$_REQUEST['authcode'];
  if(strcmp($_SESSION['authcode'],$authcode))
  {
   echo '{"msg":"err"}';
  }
  else{
  	echo '{"msg":"succ"}';
  }