<?php 
function submitMetadata($figure,$chapter,$description,$value0Label,$value1Label,$value2Label,$value3Label)
{
    include 'db_connect.php';
    $stmt=$conn->prepare("delete from memoryMeta where figure=?");
    $stmt->bind_param("s",$figure);
    $stmt->execute();


    $stmt=$conn->prepare("insert into memorymeta(figure,chapter,description,value0Label,value1Label,value2Label,value3Label) values (?,?,?,?,?,?,?)");
    $stmt->bind_param("sisssss",$figure,$chapter,$description,$value0Label,$value1Label,$value2Label,$value3Label);
    $outputMessage='';
    if ($stmt->execute())
        {
            $outputMessage='Record updated';
        }
        else 
            {
                $outputMessage='Error updating record.';
            }
    return $outputMessage;
}

function submitFigureValues($figure,$value0,$value1,$value2,$value3)
{
    include 'db_connect.php';
    $outputMessage='';
    $stmt=$conn->prepare("insert into memoryEntries(figure,value0,value1,value2,value3) values (?,?,?,?,?)");
    $stmt->bind_param("sssss",$figure,$value0,$value1,$value2,$value3);
    if ($stmt->execute())
        {
            $outputMessage=$figure;
        }
        else 
            {
                $outputMessage=false;
            }
    return $outputMessage;
}



function deleteEntry($figure,$uuid)
{
    include 'db_connect.php';
    $stmt=$conn->prepare("delete from memoryEntries where figure = ? and uuid=?");
    $stmt->bind_param("si",$figure,$uuid);
    if ($stmt->execute())
        {
            return $figure;
        }
        else 
            {
                return false;
            }
}


function fetchDataAndMetadata($figure)
{
    include 'db_connect.php';
    $metadataArray=[];
    $dataArray=[];
    
    //get metadata 
    $stmt=$conn->prepare("select * from memoryMeta where figure = ?");
    $stmt->bind_param("s",$figure);
    if ($stmt->execute())
        {
            $result=$stmt->get_result();
            while($row=$result->fetch_assoc())
                {
                    $chapter=$row["chapter"];
                    $description=$row["description"];
                    $value0Label=$row["value0Label"];
                    $value1Label=$row["value1Label"];
                    $value2Label=$row["value2Label"];
                    $value3Label=$row["value3Label"];
                    $unitArray= 
                        [
                            'figure'=>$figure,
                            'chapter'=>$chapter,
                            'description'=>$description, 
                            'value0Label'=>$value0Label,
                            'value1Label'=>$value1Label,
                            'value2Label'=>$value2Label,
                            'value3Label'=>$value3Label
                        ];
                    array_push($metadataArray,$unitArray);
                }
        }

    // get data 
    $stmt=$conn->prepare("select * from memoryEntries where figure = ?");
    $stmt->bind_param("s",$figure);
    if ($stmt->execute())
        {
            $result=$stmt->get_result();
            while($row=$result->fetch_assoc())
                {
                    $value0=$row["value0"];
                    $value1=$row["value1"];
                    $value2=$row["value2"];
                    $value3=$row["value3"];
                    $uuid=$row["uuid"];
                    $unitArray=
                    [
                        'figure'=>$figure,
                        'value0'=>$value0,
                        'value1'=>$value1,
                        'value2'=>$value2,
                        'value3'=>$value3,
                        'uuid'=>$uuid
                    ];
                    array_push($dataArray,$unitArray);       
                }
          //  return ['metaData'=>$metadataArray,'data'=>$dataArray];
        }
    if ( sizeof($metadataArray)>0 )
        {
            $outputMessage=['metaData'=>$metadataArray,'data'=>$dataArray];
        }
        else 
            {
                $outputMessage=false;
            }
    return $outputMessage;
}

function fetchRecordsList()
{
    include 'db_connect.php';
    $stmt=$conn->prepare("select figure from memorymeta");
    $outputArray=[];
    if ($stmt->execute())
        {
            $result=$stmt->get_result();
            while($row=$result->fetch_assoc())
                {
                    $figure=$row["figure"];
                    $unitArray=['figure'=>$figure];
                    
                    array_push($outputArray,$unitArray);
                }
            return $outputArray;
        }
        else 
            {
                $outputMessage="Statement didn't execute";
            }
    return $outputMessage;
}
?>