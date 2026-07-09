<?php 
    
    /*
    create table reviewQuestions(
    uuid INT AUTO_INCREMENT PRIMARY KEY,
    chapter INT,
    questionNo INT,
    questionText varchar(255),
    answerText varchar(255));
    */


    function fetchQa($chapter)
    {
        include 'db_connect.php';
        $questionsArray=[];
        $answersArray=[];
        $stmt=$conn->prepare("select * from reviewquestions where chapter=? order by questionNo asc");
        $stmt->bind_param("i",$chapter);
        if ($stmt->execute())
            {
                $result=$stmt->get_result();
                while($row=$result->fetch_assoc())
                    {
                        
                        $questionNo=$row["questionNo"];
                        $questionText=$row["questionText"];
                        $unitArray=['chapter'=>$chapter,'questionNo'=>$questionNo,'questionText'=>$questionText];
                        array_push($questionsArray,$unitArray);
                    }
            }
        
        $stmt=$conn->prepare("select * from reviewanswers where chapter=? order by questionNo asc");
        $stmt->bind_param("i",$chapter);
        if ($stmt->execute())
            {
                $result=$stmt->get_result();
                while($row=$result->fetch_assoc())
                    {
                        $questionNo=$row["questionNo"];
                        $answerText=$row["answerText"];
                        $unitArray=['chapter'=>$chapter,'questionNo'=>$questionNo,'answerText'=>$answerText];
                        array_push($answersArray,$unitArray);
                    }
                
                $outputPackage=["questions"=>$questionsArray,"answers"=>$answersArray];
                return $outputPackage;
            }
        return false;
    }


    function submitQuestion($chapter,$question,$questionText)
    {
        include 'db_connect.php';
        $stmt=$conn->prepare("delete from reviewquestions where chapter=? and questionNo=?");
        $stmt->bind_param("ii",$chapter,$question);
	/////
	$stmt->execute()
        
        $stmt=$conn->prepare("insert into reviewquestions (chapter,questionNo,questionText) values(?,?,?)");
        $stmt->bind_param("iis",$chapter,$question,$questionText);
        if ($stmt->execute())
            {
                return 'Record updated';
            }
            else 
                {
                    return 'Error updating record.';
                }
        
    }

    function submitAnswer($chapter,$question,$answerText)
    {
        include 'db_connect.php';
        $stmt=$conn->prepare("delete from reviewanswers where chapter=? and questionNo=?");
        $stmt->bind_param("ii",$chapter,$question);
	//////
	$stmt->execute()

        $stmt=$conn->prepare("insert into reviewanswers (chapter,questionNo,answerText) values(?,?,?)");
        $stmt->bind_param("iis",$chapter,$question,$answerText);
        if ($stmt->execute())
            {
                return 'Record updated';
            }
            else 
                {
                    return 'Error updating record';
                }
    }

?>