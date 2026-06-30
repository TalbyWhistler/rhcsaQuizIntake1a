<?php 
            include 'memory_quiz_operations.php';
            $rawInput=file_get_contents('php://input');
            $jsonInput=json_decode($rawInput,true);
            $function=$jsonInput["function"];
            $outputMessage='No function activated';
            switch($function)
            {
                case("testo"):
                    {
                        $outputMessage='testo backend is working';
                        break;
                    }
                case("transmitMetadata"):
                    {
                        $params=$jsonInput["params"];
                        $figure=$params["figure"];
                        $chapter=$params["chapter"];
                        $description=$params["description"];
                        $value0=$params["value0"];
                        $value1=$params["value1"];
                        $value2=$params["value2"];
                        $value3=$params["value3"];
                        
                        $outputMessage=submitMetadata($figure,$chapter,$description,$value0,$value1,$value2,$value3);
                        break;
                    }
                case("fetchRecordsList"):
                    {
                        $params=$jsonInput["params"];
                      //  $figure=$params["figure"];
                        $outputMessage="Fetch record list has fired";
                        $outputMessage=fetchRecordsList();
                        break;
                    }
                case("fetchDataAndMetadata"):
                    {
                        $params=$jsonInput["params"];
                        $figure=$params["figure"];
                        $outputMessage=fetchDataAndMetadata($figure);
                        break;
                    }
                case("submitFigureValues"):
                    {
                        $params=$jsonInput["params"];
                        $figure=$params["figure"];
                        $value0=$params["value0"];
                        $value1=$params["value1"];
                        $value2=$params["value2"];
                        $value3=$params["value3"];
                       // $outputMessage='Submit figure values control has fired';
                        $outputMessage=submitFigureValues($figure,$value0,$value1,$value2,$value3);
                        break;
                    }
                case("deleteEntry"):
                    {
                        $params=$jsonInput["params"];
                        $figure=$params["figure"];
                        $uuid=$params["uuid"];
                        $outputMessage=deleteEntry($figure,$uuid);
                    }
            }
        echo json_encode($outputMessage);
?>