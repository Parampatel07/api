<?php
/*
        usage: to add product to cart 
        how to call : http://localhost/api1/api/insert_cart.php
        output :
        [{"error":"input is missing"}] 
        [{"error":"no"},{"success":"yes"},{"message":"Product Added Successfully  "}]
        input : userid,productid,quantity 
    */
require_once("connection.php");
$response = array();
$input = $_REQUEST;
if(isset($input['userid'],$input['productid'],$input['quantity'])==false)
{
     array_unshift($response,array("error"=>"Input is missing "));
}
else
{
     $sql = "Insert into cart (userid,productid,quantity) values (?,?,?) ";
     $stat = $db->prepare($sql);
     $stat->bindparam(1,$input['userid']);
     $stat->bindparam(2,$input['productid']);
     $stat->bindparam(3,$input['quantity']);
     $stat->execute();
     array_push($response,array("error"=>"no"));
     array_push($response,array("success"=>"yes"));
     array_push($response,array("message"=>"Product Added successfully "));
}

echo json_encode($response);
?>
