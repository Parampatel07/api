<?php
/*
        usage: used to login as user 
        how to call : http://localhost/api1/api/register.php
        output :
        [{"error":"input is missing"}] 
        [{"error":"no"},{"success":"yes"},{"message":"Registration successfully "}]
        input : mobile,email,password(required) it is checked via get method 
    */

require_once("connection.php");
$response = array();
$input = $_REQUEST;
if(isset($input['name'],$input['mobile'],$input['password'],$input['email'],$input['dob']) == false )
{
     array_unshift($response,array("error"=>"Input is missing"));
     var_dump($input);
}
else
{
     $sql = "Insert into user (name,mobile,email,password,dob) values (?,?,?,?,?)";
     $stat = $db->prepare($sql);
     $stat->bindparam(1,$input['name']);
     $stat->bindparam(2,$input['mobile']);
     $stat->bindparam(3,$input['email']);
     $stat->bindparam(4,$input['password']);
     $stat->bindparam(5,$input['dob']);
     $stat->execute();
     array_push($response,array("error"=>"no"));
     array_push($response,array("success"=>"yes"));
     array_push($response,array("message"=>"Registration successfully "));
}
// var_dump($response);
echo json_encode($response);
?>