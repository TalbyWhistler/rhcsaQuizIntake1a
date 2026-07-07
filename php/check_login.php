<?php 
    function checkIfLoggedInBoolean()
{
    include 'db_connect.php';
    $cookieValues=$_COOKIE["linuxLab"]??'';
    $cookieUsername=$_COOKIE["linuxLab"]??'';
    $jsonValues=json_decode($cookieValues,true);
  //  return json_encode($jsonValues);
    $loggedInUser=$jsonValues["username"];
    $loggedInToken=$jsonValues["token"];
  //  return json_encode($jsonValues["username"]);
   // $cookieUsername=$_COOKIE["linuxLab"];
   // $cookieToken=$_COOKIE["linuxLab"]["token"]??'';
   // return $cookieUsername;
    $stmt=$conn->prepare("select count(*) as 'total' from userlogin where logintoken=? and username=? and logindate=current_date()");
    $stmt->bind_param("ss",$loggedInToken,$loggedInUser);
    $stmt->execute();
    $outputArray=[];
    $result=$stmt->get_result();
    while($row=$result->fetch_assoc())
        {
            $value=$row["total"];
            array_push($outputArray,$value);
        }
    if($outputArray[0]>0)
        {
            return true;
        }
    else 
        {
            return false;
        }
}
?>