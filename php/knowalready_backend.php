<?php 
    include 'knowalready_db_operations.php';

    $rawInput=file_get_contents('php://input');
    $jsonInput=json_decode($rawInput,true);
    $inputFunction=$jsonInput["function"];
    $outputMessage='';
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
    }

    echo json_encode($outputMessage);


?>