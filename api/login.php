<?php
/*
          usage: to login for admin 
          how to call : http://localhost/api1/api/login.php
          output :
          [{"error":"input is missing"}] 
          [{"error":"no"},{"success":"no"},{message:"Invalid login attempt"}]
          [{"error":"no"},{"success":"yes"},{message:"login successfull"}]
          input : userid
    */
require_once("connection.php");
$response = array();
$input = $_REQUEST;
if(isset($input['email'],$input['password'])==false)
{
     array_unshift($response,array("error"=>"Input is missing "));
}
else
{
     $sql = "SELECT password,id from admin where email = ? ";
     $stat=$db->prepare($sql);
     $stat->setFetchMode(PDO::FETCH_ASSOC);
     $stat->bindparam(1,$input['email']);
     $stat->execute();
     $row = $stat->fetch();
     $count = $stat->rowCount();
     if($count==0)
     {
          array_push($response,array("error"=>"no"));
          array_push($response,array("success"=>"no"));
          array_push($response,array("message"=>"Invalid Login Attempt "));
     } 
     else
     {
          $check = password_verify($input['password'],$row['password']);
          if($check==true)
          {
               //password matched
               array_push($response,array("error"=>"no"));
               array_push($response,array("success"=>"yes"));
               array_push($response,array("id"=>$row['id']));
               array_push($response,array("message"=>"Login Successfull "));
          }
          else
          {
               array_push($response,array("error"=>"no"));
               array_push($response,array("success"=>"no"));
               array_push($response,array("message"=>"Invalid Login Attempt "));
          }
     }
}
echo json_encode($response);
?>