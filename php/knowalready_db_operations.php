<?php 
function inputQuestionData($chapter,$questionNumber,$question,$a,$b,$c,$d)
{
    include 'db_connect.php';
    $returnMessage='';

    $stmt=$conn->prepare("delete from questions where chapter=? and questionNumber=?");
    $stmt->bind_param("ii",$chapter,$questionNumber);
    $stmt->execute();
    //$stmt=$conn->prepare("insert into questions values(?,?,?,?,?,?,?)");
    $stmt=$conn->prepare("insert into questions(chapter,questionNumber,questionText,a,b,c,d)values(?,?,?,?,?,?,?)");
    $stmt->bind_param("iisssss",$chapter,$questionNumber,$question,$a,$b,$c,$d);
    if ($stmt->execute())
        {
            $returnMessage="Chapter ".$chapter." Question ".$questionNumber." record updated";
        }
        else 
            {
                $returnMessage="Error updating record";
            }

    //$returnMessage="testo testo ".$chapter." ".$questionNumber." ".$question." ".$a." ".$b." ".$c." ".$d." ";
    //$returnMessage="testReturn";
    return $returnMessage;

}


function inputAnswerData($chapter,$questionNumber,$answerLetter,$answer)
{
    include 'db_connect.php';
    $returnMessage='';

   // $returnMessage='inputAnswerData';
   
    $stmt=$conn->prepare("delete from answers where chapter=? and questionNumber=?");
    $stmt->bind_param("ii",$chapter,$questionNumber);
    $stmt->execute();
    $stmt=$conn->prepare("insert into answers(chapter,questionNumber,answerLetter,answer)values(?,?,?,?)");
    $stmt->bind_param("iiss",$chapter,$questionNumber,$answerLetter,$answer);
    if ($stmt->execute())
        {
            $returnMessage='Answer for chapter '.$chapter.' question '.$questionNumber.' record updated';
        }
        else 
            {
                $returnMessage='Answer record update failed';
            }
    return $returnMessage;
}




?>