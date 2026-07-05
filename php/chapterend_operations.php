<?php 
/*
drop table chapterlabmeta;
create table chapterlabmeta(
    	uuid int AUTO_INCREMENT PRIMARY KEY, 
    	chapter int,
    	chaptertitle varchar(100),
    	labintro varchar(255)    
    );
drop table chapterlabsteps;
create table chapterlabsteps(
    	uuid int AUTO_INCREMENT PRIMARY KEY,
    	chapter int,
    	stepnumber int,
    	steptext varchar(255)
    );

*/

function submitStep($chapter,$stepNumber,$stepText)
{
    $outputMessage='submit step operations succeeded for '.$chapter.' '.$stepNumber.' '.$stepText;
    include 'db_connect.php';

    $stmt=$conn->prepare("delete from chapterlabsteps where chapter=? and stepnumber=?");
    $stmt->bind_param("ii",$chapter,$stepNumber);
    $stmt->execute();



    $stmt=$conn->prepare("insert into chapterlabsteps(chapter,stepnumber,steptext) values(?,?,?)");
    $stmt->bind_param("iis",$chapter,$stepNumber,$stepText);
    if ($stmt->execute())
        {
            $outputMessage='Record updated.';
        }
        else 
            {
                $outputMessage='Error updating record.';
            }
    return $outputMessage;
}

function fetchMetadataAndData($chapter)
{
    $outputMessage='fetch metadataAndData operations succeeded for chapter '.$chapter;
    include 'db_connect.php';
    $metadataArray=[];
    $dataArray=[];

    $stmt=$conn->prepare("select * from chapterlabmeta where chapter=?");
    $stmt->bind_param("i",$chapter);
    if ($stmt->execute())
        {
            $result=$stmt->get_result();
            while($row=$result->fetch_assoc())
                {
                    
                    $chapterTitle=$row["chaptertitle"];
                    $labIntro=$row["labintro"];
                    $unitArray=['chapter'=>$chapter,'chapterTitle'=>$chapterTitle,'labIntro'=>$labIntro];
                    array_push($metadataArray,$unitArray);
                }
        }
        else 
            {
                $outputMessage='Error fetching data';
                return $outputMessage;
            }
    
    $stmt=$conn->prepare("select * from chapterlabsteps where chapter=?");
    $stmt->bind_param("i",$chapter);
    if ($stmt->execute())
        {
            $result=$stmt->get_result();
            while ($row=$result->fetch_assoc())
                {
                    $stepNumber=$row["stepnumber"];
                    $stepText=$row["steptext"];
                    $unitArray=['stepNumber'=>$stepNumber,'stepText'=>$stepText];
                    array_push($dataArray,$unitArray);
                }
        }
         else 
            {
                $outputMessage='Error fetching data';
                return $outputMessage;
            }
    return $outputPackage=['metaData'=>$metadataArray,'data'=>$dataArray];    
}

function fetchSteps($chapter)
{
    include 'db_connect.php';
    $stmt=$conn->prepare("select * from chapterlabsteps where chapter=? order by stepnumber asc");
    $stmt->bind_param("i",$chapter);

    $outputArray=[];
    if ($stmt->execute())
        {
            $result=$stmt->get_result();
            while($row=$result->fetch_assoc())
                {
                    $stepNumber=$row["stepnumber"];
                    $stepText=$row["steptext"];
                    $unitArray=['stepNumber'=>$stepNumber,'stepText'=>$stepText];
                    array_push($outputArray,$unitArray);
                }
            return $outputArray;
        }
        else 
            {
                return "Error fetching data";
            }
}

function submitMetadata($chapter,$title,$labIntro)
{
    include 'db_connect.php';
    $stmt=$conn->prepare("delete from chapterlabmeta where chapter=?");
    $stmt->bind_param("i",$chapter);
    $stmt->execute();
    $stmt=$conn->prepare("insert into chapterlabmeta (chapter,chaptertitle,labintro) values(?,?,?)");
    $stmt->bind_param("iss",$chapter,$title,$labIntro);
    $outputMessage='';
    if ($stmt->execute())
        {
            $outputMessage='Metadata record updated';
        }    
        else 
            {
                $outputMessage='Error updating record';
            }
    return $outputMessage;
}

function deleteListStep($chapter,$stepNumber)
{
    include 'db_connect.php';
    $stmt=$conn->prepare("delete from chapterlabsteps where chapter=? and stepnumber=?");
    $stmt->bind_param("ii",$chapter,$stepNumber);
    if ($stmt->execute())
        {
            $outputMessage='Step deleted.';
        }
        else 
            {
                $outputMessage='Error deleting step';
            }
    return $outputMessage;
}
?>