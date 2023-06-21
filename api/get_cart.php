<?php
/*
          usage: to get product in cart 
          how to call : http://localhost/api1/api/get_cart.php
          output :
          [{"error":"input is missing"}] 
          [{"error":"no"},{"success":"yes"},{"name":"product 1","photo":"https:\/\/picsum.photos\/150\/150","price":"200","productid":"1","quantity":"10"},{"name":"product 1","photo":"https:\/\/picsum.photos\/150\/150","price":"200","productid":"1","quantity":"2"}]
          input : userid
    */
require_once("connection.php");
$response=array();
$input = $_REQUEST;
if(isset($input['userid'])==false)
{
     array_unshift($response,array("error"=>"Input is missing "));
}
else
{
     $sql = "SELECT product.name, product.photo,product.price,productid,quantity from cart,product where userid = ? and cart.productid = product.id; ";
     $stat=$db->prepare($sql);
     $stat->setFetchMode(PDO::FETCH_ASSOC);
     $stat->bindparam(1,$input['userid']);
     $stat->execute();
     $table = $stat->fetchAll();
     // var_dump($table);
     array_push($response,array("error"=>"no"));
     array_push($response,array("success"=>"yes"));
     foreach($table as $value)
     {
          array_push($response,$value);
     }
}
echo json_encode($response);
?>