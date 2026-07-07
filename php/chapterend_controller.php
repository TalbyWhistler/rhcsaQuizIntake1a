<?php 
        include 'chapterend_operations.php';
        include_once 'check_login.php';
      
        $rawInput=file_get_contents('php://input');
        $jsonInput=json_decode($rawInput,true);
        $function=$jsonInput["function"];
        $outputMessage="No function in chapterend activated.";
        $isLoggedIn=checkIfLoggedInBoolean();
        if(!$isLoggedIn)
            {
                $function='';
                $outputMessage='Requires admin user.';
            }
        switch($function)
        {
            case("submitMetadata"):
            {
                $params=$jsonInput["params"];
                $chapter=$params["chapter"];
                $title=$params["chapterTitle"];
                $intro=$params["labIntro"];
                $outputMessage=$chapter.$title.$intro;
                $outputMessage=submitMetadata($chapter,$title,$intro);
                break;
            }
            case("fetchMetadataAndData"):
            {
                $params=$jsonInput["params"];
                $chapter=$params["chapter"];
                $outputMessage=fetchMetadataAndData($chapter);
                break;
            }
            case("submitStep"):
            {
                $params=$jsonInput["params"];
                $chapter=$params["chapter"];
                $stepNumber=$params["stepNumber"];
                $stepText=$params["stepText"];
                $outputMessage=submitStep($chapter,$stepNumber,$stepText);
                break;               
            }
            case("fetchSteps"):
                {
                    $params=$jsonInput["params"];
                    $chapter=$params["chapter"];
                    $outputMessage=fetchSteps($chapter);
                    break;
                }
            case("deleteListStep"):
                {
                    $params=$jsonInput["params"];
                    $chapter=$params["chapter"];
                    $stepNumber=$params["stepNumber"];
                    $outputMessage=deleteListStep($chapter,$stepNumber);
                    break;
                }
            case("guest"):
                {
                    $outputMessage="Requires admin user.";
                    break;
                }
        }

        echo json_encode($outputMessage);

?>