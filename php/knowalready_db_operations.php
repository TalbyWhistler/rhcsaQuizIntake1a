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

function fetchQuestionsByChapter($chapter)
{
    include 'db_connect.php';
    $outputMessage='fetch questions by chapter operations is working';
    $outputArray=[];
    $questionsArray=[];
    $answersArray=[];
    $stmt=$conn->prepare("select * from questions where chapter=? order by questionNumber asc");
    $stmt->bind_param("i",$chapter);
    if ($stmt->execute())
        {
            $result=$stmt->get_result();
            while ($row=$result->fetch_assoc())
                {
                    $questionNumber=$row["questionNumber"];
                    $questionText=$row["questionText"];
                    $a=$row["a"];
                    $b=$row["b"];
                    $c=$row["c"];
                    $d=$row["d"];
                    $hasTwoAnswers=$row["hasTwoAnswers"]??'';
                    $unitArray=['questionNumber'=>$questionNumber,'questionText'=>$questionText,'a'=>$a,'b'=>$b,'c'=>$c,'d'=>$d,'hasTwoAnswers'=>$hasTwoAnswers];
                    array_push($questionsArray,$unitArray);
                }
            $stmt=$conn->prepare("select * from answers where chapter=?  order by questionNumber asc;");
            $stmt->bind_param("i",$chapter);
            if ($stmt->execute())
                {
                    $result=$stmt->get_result();
                    while ($row=$result->fetch_assoc())
                        {
                            $questionNumber=$row["questionNumber"];
                            $answerLetter=$row["answerLetter"];
                            $answer=$row["answer"];
                            $secondAnswer=$row["secondAnswer"]??'';
                            $unitArray=['questionNumber'=>$questionNumber,'answerLetter'=>$answerLetter,'answer'=>$answer,'secondAnswer'=>$secondAnswer];
                            array_push($answersArray,$unitArray);
                        }
                }
                else 
                    {
                        // no execute
                    }
        }
        else 
            {
                // no execute
            }
    $outputArray=['questions'=>$questionsArray,'answers'=>$answersArray];
    return $outputArray;
    
}

function fetchMissing($chapter)
{
    $outputMessage='Fetch missing operations is working';
    // may not be required
    return $outputMessage;
    /// must get an array of missing questions and answers 
}

?>