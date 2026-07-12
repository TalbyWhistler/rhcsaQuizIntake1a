<?php 
$servername="localhost";
//$servername="%waters";
$username = "sa000748591";
$password = "Sa_19780531";
$dbName = "sa000748591";

//$servername="localhost";
//$servername="%waters";
//$username = "webUser1";
//$password = "watersWeb";
//$dbName = "redhat0";


$conn = new mysqli($servername,$username,$password,$dbName);
$returnValue=false;
if ($conn->connect_error)
    {
       // echo "</br>connect false";
       $returnValue=false;
    }
    else 
        {
           // echo "</br>connect true";
           $returnValue=true;
        }

return $returnValue;

?>

?>