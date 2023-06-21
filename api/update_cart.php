<?php
/*
        usage: to update product in cart 
        how to call : http://localhost/api1/api/update_cart.php
        output :
        [{"error":"input is missing"}] 
        [{"error":"no"},{"success":"yes"},{"message":"Product Updated Successfully  "}]
        input : quantity,id
    */
require_once("connection.php");
$response = array();
$input = $_REQUEST;
if(isset($input['quantity'],$input['id'])==false)
{
     array_unshift($response,array("error"=>"Input is missing "));
}
else
{
     $sql = "UPDATE cart set  quantity = ? where id = ? ";
     $stat=$db->prepare($sql);
     $stat->bindparam(1,$input['quantity']);
     $stat->bindparam(2,$input['id']);
     $stat->execute();
     array_push($response,array("error"=>"no"));
     array_push($response,array("success"=>"yes"));
     array_push($response,array("message"=>"Product Updated successfully "));
}
echo json_encode($response);
?>