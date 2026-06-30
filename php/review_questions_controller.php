<?php 
        include 'review_questions_operations.php';
        $rawInput=file_get_contents('php://input');
        $jsonInput=json_decode($rawInput,true);
        $function=$jsonInput["function"];
        $outputMessage='No function activated in the controller';
        switch($function)
        {
            case("testo"):
                {
                    $outputMessage="Review questions controller is working";
                    break;
                }
            case("fetchQa"):
                {
                    $outputMessage="Fetchqa is working";
                    $params=$jsonInput["params"];
                    $chapter=$params["chapter"];
                    $outputMessage=fetchQa($chapter);
                    break;
                }
            case("submitQuestion"):
                {
                    $params=$jsonInput["params"];
                    $chapter=$params["chapter"];
                    $question=$params["question"];
                    $questionText=$params["questionText"];
                    $outputMessage=submitQuestion($chapter,$question,$questionText);
                    break;
                }
            case("submitAnswer"):
                {
                    $params=$jsonInput["params"];
                    $chapter=$params["chapter"];
                    $question=$params["question"];
                    $answerText=$params["answer"];
                    $outputMessage=submitAnswer($chapter,$question,$answerText);
                    break;
                }
        }


        echo json_encode($outputMessage);
?>