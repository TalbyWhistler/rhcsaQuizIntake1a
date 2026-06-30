<?php 
    include 'exercises_operations.php';
    $rawInput=file_get_contents('php://input');
    $jsonInput=json_decode($rawInput,true);
    $inputFunction=$jsonInput["function"];
    $outputMessage='';

    switch($inputFunction)
    {
        case("testo"):
            {
                $outputMessage="exercises controller is working";
                break;
            }
        case("submitMetadata"):
            {
               
                $params=$jsonInput["params"];
                $figure=$params[0]["input"];
                $title=$params[1]["input"];
                $description=$params[2]["input"];
                $picLocation=$params[3]["input"];
                $outputMessage="submit metadata control is working".$figure.$title.$description.$picLocation;
                $outputMessage=insertMetaValues($figure,$title,$description,$picLocation);
                break;
            }
        case("fetchRecordsList"):
            {
                $params=$jsonInput["params"];
              //  $figure=$params["figure"];
                $outputMessage=fetchRecordsList();
                break;
            }
        case("loadFigureDataAndMetadata"):
            {
                $params=$jsonInput["params"];
                $figure=$params["figure"];
                $outputMessage=getData($figure);
                break;
            }
        case("submitData"):
            {
                $params=$jsonInput["params"];
                $figure=$params["figure"];
                $stepNumber=$params["stepNumber"];
                $stepText=$params["stepText"];
                $outputMessage="submitData has fired ".$figure.$stepNumber.$stepText;
                $outputMessage=putData($figure,$stepNumber,$stepText);
                break;
            }
    }
    echo json_encode($outputMessage);
?>