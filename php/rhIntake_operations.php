<?php

/// 
function attemptLogin($usernameInput,$passwordInput)
{
    include 'db_connect.php';
   // return "$usernameInput $passwordInput";
  //  $insertName='TalbyWhistler';
    $stmt=$conn->prepare("SELECT COUNT(*) as 'total' FROM userlogin WHERE USERNAME=? and PASSWORD=?");
    $stmt->bind_param("ss",$usernameInput,$passwordInput);
    $stmt->execute();
    $result=$stmt->get_result();
    $resultsArray=[];
    while($row=$result->fetch_assoc())
        {
            $count=$row["total"];
            array_push($resultsArray,$count);
        }
    if ($resultsArray[0]==1)
        {
            $COOKIE_NAME='linuxLab';
            $testToken='123456';
            $cookieValues=['username'=>$usernameInput,'token'=>$testToken];
            $jsonValues=json_encode($cookieValues);
            setcookie($COOKIE_NAME,$jsonValues);
            $stmt=$conn->prepare("update userlogin set logindate=current_date(),logintoken=? where username=? and password=?");
            $stmt->bind_param("sss",$testToken,$usernameInput,$passwordInput);
            
            if($stmt->execute())
                {
                    return 'Login successful';
                }
        }
    else 
        {
            return 'Invalid login.';
        }
}


function checkIfLoggedIn()
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
            return ' logged in.';
        }
    else 
        {
            return ' not logged in.';
        }
}

function logout()
{
    include 'db_connect.php';
    $cookieUsername=$_COOKIE["linuxLab"]["username"]??'';
    $cookieToken=$_COOKIE["linuxLab"]["token"]??'';
    $cookieValues=['username'=>'','token'=>''];
    $jsonValues=json_encode($cookieValues);
    setcookie('linuxLab',$jsonValues);
    return 'Successfully logged out.';
}
?> 