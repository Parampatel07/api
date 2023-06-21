<?php
/*
     usage: to login for admin 
     how to call : http://localhost/api1/api/change_password.php
     output :
     [{"error":"input is missing"}] 
     [{"error":"no"},{"success":"no"},{message:"Invalid change attempt"}]
     [{"error":"no"},{"success":"yes"},{message:"password changed successfully "}]
     input : userid,oldpassword,newpassword,confirmpassword
     */
     require_once("connection.php");
     $response=array();
     $input=$_REQUEST;
     if(isset($input['userid'],$input['oldpassword'],$input['newpassword'],$input['confirmpassword'])==false)
     {
          array_unshift($response,array("error"=>"Input is missing "));    
     }
     else
     {
          if($input['newpassword']==$input['confirmpassword'])
          {
               //continue
               $sql = "SELECT password from admin where id = ? ";
               $stat=$db->prepare($sql);
               $stat->setFetchMode(PDO::FETCH_ASSOC);
               $stat->bindparam(1,$input['userid']);
               $stat->execute();
               $row = $stat->fetch();
               if(password_verify($input['oldpassword'],$row['password'])==true)
               {
                    // continue 
                    $new_hash_password = password_hash($input['newpassword'],PASSWORD_BCRYPT);
                    $sql = "UPDATE admin set password = ? where id  = ? ";
                    $stat=$db->prepare($sql);
                    $stat->bindparam(1,$new_hash_password);
                    $stat->bindparam(2,$input['userid']);
                    $stat->execute();
                    array_push($response,array("error"=>"no"));
                    array_push($response,array("success"=>"yes"));
                    array_push($response,array("message"=>"Password changed successfully "));
               }
               else
               {    
                    array_push($response,array("error"=>"no"));
                    array_push($response,array("success"=>"no"));
                    array_push($response,array("message"=>"Invalid Change Attempt "));
               }
          }
          else
          {
               array_push($response,array("error"=>"no"));
               array_push($response,array("success"=>"no"));
               array_push($response,array("message"=>"Invalid Change Attempt "));
          }
     }
echo json_encode($response);
?>