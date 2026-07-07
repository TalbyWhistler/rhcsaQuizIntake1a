<?php 
        include_once 'rhIntake_operations.php';
        $rawInput=file_get_contents('php://input');
        $jsonInput=json_decode($rawInput,true);
        $function=$jsonInput["function"];
        $outputMessage='No function activated in intake control';
        
        switch($function)
        {
            case("testo"):
                {
                    $outputMessage='Intake control is working';
                    break;
                }
            case("attemptLogin"):
                {
                    $params=$jsonInput["params"];
                    $usernameInput=$params["username"];
                    $passwordInput=$params["password"];
                    //$outputMessage='Attempt login control is working'.$username.' '.$password;
                    $outputMessage=attemptLogin($usernameInput,$passwordInput);
                    break;
                }
            case("checkIfLoggedIn"):
                {
                    $outputMessage=checkIfLoggedIn();
                    break;
                }
            case("logout"):
                {
                    $outputMessage=logout();
                    break;
                }
        }


        echo json_encode($outputMessage);

?>