<?php
/*
        usage: to delete product from cart 
        how to call : http://localhost/api1/api/delete_cart.php
        output :
        [{"error":"input is missing"}] 
        [{"error":"no"},{"success":"yes"},{"message":"Product deleted Successfully  "}]
        input : id 
    */
require_once("connection.php");
$response=array();
$input=$_REQUEST;
if(isset($input['id'])==false)
{
     array_unshift($response,array("error"=>"Input is missing "));
}
else
{
     $sql = "DELETE from cart where id = ?";
     $stat=$db->prepare($sql);
     $stat->bindparam(1,$input['id']);
     $stat->execute(); 
     array_push($response,array("error"=>"no"));
     array_push($response,array("success"=>"yes"));
     array_push($response,array("message"=>"Product deleted Successfully "));

}
echo json_encode($response);
?>