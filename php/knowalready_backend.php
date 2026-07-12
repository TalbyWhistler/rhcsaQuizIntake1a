<?php 
    include 'knowalready_db_operations.php';
    include_once 'check_login.php';

    $rawInput=file_get_contents('php://input');
    $jsonInput=json_decode($rawInput,true);
    $inputFunction=$jsonInput["function"];
    $outputMessage='';

    
     $isLoggedIn=checkIfLoggedInBoolean();
        if($isLoggedIn==false && $inputFunction!="fetchRecordsList" && $inputFunction !="loadFigureDataAndMetadata")
            {
                $inputFunction='';
                $outputMessage='Requires admin user.';
            }
    
    switch($inputFunction)
    {
        case("testo"):
            {
                $inputParams=$jsonInput["params"];
                $testMessage=$inputParams["testParam"];
                
                $testMessage=$inputParams["testParam"];
                $outputMessage='knowalready control function with value '.$testMessage;
                break;
            }
        case("submitQuestionData"):
            {
                $inputParams=$jsonInput["params"];
                $chapter=$inputParams["chapter"];
                $questionNumber=$inputParams["questionNumber"];
                $question=$inputParams["question"];
                $a=$inputParams["a"];
                $b=$inputParams["b"];
                $c=$inputParams["c"];
                $d=$inputParams["d"];
               // $outputMessage="Submit question control ".$chapter.$questionNumber.$question.$a.$b.$c.$d;
               $outputMessage=inputQuestionData($chapter,$questionNumber,$question,$a,$b,$c,$d);
                break;
            }
        case("submitAnswerData"):
        {
            $inputParams=$jsonInput["params"];
            $chapter=$inputParams["chapter"];
            $questionNumber=$inputParams["questionNumber"];
            $answerLetter=$inputParams["answerLetter"];
            $answer=$inputParams["answer"];
            $outputMessage=inputAnswerData($chapter,$questionNumber,$answerLetter,$answer);
            break;
        }
        case("fetchQuestionsByChapter"):
            {
                $params=$jsonInput["params"];
                $chapter=$params["chapter"];
                $outputMessage="Fetch questons by chapter control is working chapter $chapter";
                $outputMessage=fetchQuestionsByChapter($chapter);
                break;
            }
        case("fetchMissing"):
            {
                // may not be required
                $params=$jsonInput["params"];
                $chapter=$params["chapter"];
                $outputMessage='Fetch missing control is working chapter is '.$chapter;
                $outputMessage=fetchMissing($chapter);
                break;
            }
    }

    echo json_encode($outputMessage);


?>