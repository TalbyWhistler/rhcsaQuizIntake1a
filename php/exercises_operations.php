<?php
/*

    drop table exercisesMeta;
create table exercisesMeta(
    	uuid integer AUTO_INCREMENT PRIMARY KEY,
    	figure varchar(10),
    	title varchar(20),
    	description varchar(100),
    	optionalPicLocation varchar(50)
    );
drop table exercises;
create table exercises(
    	uuid integer AUTO_INCREMENT PRIMARY KEY,
    	figure varchar(10),
    	stepnumber integer,
    	steptext varchar(255)
    );
*/

function insertMetaValues($figure,$title,$description,$picLocation)
{
    include 'db_connect.php';
    $stmt=$conn->prepare("delete from exercisesMeta where figure=?");
    $stmt->bind_param("s",$figure);
    $stmt->execute();
    $outputMessage='';

    $stmt=$conn->prepare("insert into exercisesMeta (figure,title,description,optionalPicLocation) values(?,?,?,?)");
    $stmt->bind_param("ssss",$figure,$title,$description,$picLocation);
    if ($stmt->execute())
        {
            $outputMessage='Record Updated';
        }
        else 
            {
                $outputMessage='Execution Error';
            }
    return $outputMessage;
}

function fetchRecordsList()
{
    include 'db_connect.php';
    $stmt=$conn->prepare("select figure,title from exercisesmeta");
    $stmt->execute();
    $result=$stmt->get_result();
    $outputArray=[];
    if ($result)
        {
            while($row=$result->fetch_assoc())
                {
                    $figure=$row["figure"];
                    $title=$row["title"];
                    $unitArray=['figure'=>$figure,'title'=>$title];
                    array_push($outputArray,$unitArray);
                }
            return $outputArray;
        }
    return $false;
}


function getData($figure)
{
    include 'db_connect.php';
    $stmt=$conn->prepare("select * from exercisesMeta where figure=?");
    $stmt->bind_param("s",$figure);
    $metadataArray=[];
    $dataArray=[];
    if ($stmt->execute())
        {
            $result=$stmt->get_result();
            if ($result)
                {
                    while($row=$result->fetch_assoc())
                        {
                            $figure=$row["figure"];
                            $title=$row["title"];
                            $description=$row["description"];
                            $pic=$row["optionalPicLocation"];
                            $unitArray=['figure'=>$figure,'title'=>$title,'description'=>$description,'optionalPicLocation'=>$pic];
                            array_push($metadataArray,$unitArray);
                        }
                }
        }   


    $stmt=$conn->prepare("select * from exercises where figure=? order by stepnumber asc");
    $stmt->bind_param("s",$figure);
    if ($stmt->execute())
        {
            $result=$stmt->get_result();
            if ($result)
                {
                    while($row=$result->fetch_assoc())
                        {
                            $figure=$row["figure"];
                            $stepNumber=$row["stepnumber"];
                            $stepText=$row["steptext"];
                            $unitArray=['figure'=>$figure,'stepNumber'=>$stepNumber,'stepText'=>$stepText];
                            array_push($dataArray,$unitArray);
                        }
                }
            $outputPackage=['metaData'=>$metadataArray,'data'=>$dataArray];
            return $outputPackage;
        }
    return false;
}


function putData($figure,$stepNumber,$stepText)
{
    include 'db_connect.php';
    $stmt=$conn->prepare("delete from exercises where figure=? and stepNumber=?");
    $stmt->bind_param("si",$figure,$stepNumber);
    $stmt->execute();
    $outputMessage='';

    $stmt=$conn->prepare("insert into exercises (figure,stepnumber,steptext) values(?,?,?)");
    $stmt->bind_param("sis",$figure,$stepNumber,$stepText);
    if ($stmt->execute())
        {
            $outputMessage='Record updated';
        }
    else 
        {
            $outputMessage='Error updating message';
        }
    return $outputMessage;
}
?>