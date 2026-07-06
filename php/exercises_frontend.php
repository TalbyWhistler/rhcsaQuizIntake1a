<?php
     //   include 'tools.php';

/*
            metadata input panel
                figure,
                title,
                description,
                picLocation,
                submit button
                statusIndicator

                -----
                buttons of available metadata entries
                ------
            data input panel
                figure
                stepnumber 
                steptext
                submit button
                statusIndicator

            step output area
                table of numbers and steps per chosen figure



*/

    $labelLabels=["Figure","Title","Description","Optional Picture Location"];
    $labels=["figureInputMeta","title","description","picLocation"];
    $metadataInputs='';
    $br='</br>';
    for($i=0;$i<sizeof($labels);$i++)
        {
            $outputLine='<input id="'.$labels[$i].'"/><label>'.$labelLabels[$i].'</label>';
            $metadataInputs=$metadataInputs
                .$outputLine
                .$br;
        };
    $metadataSubmitbutton=createButton("metadataSubmit","submitButton",'handleMetadataSubmit','Submit');
    $metadataStatusIndicator=createElement('p','metadataStatusIndicator','statusIndicator','Ready');
    $statusIndicatorBox=createElement('div',"metadataStatusIndicatorBox","indicatorBox",$metadataStatusIndicator);
    $metadataInputPanelContents=''
        .$metadataInputs 
        .$metadataSubmitbutton 
        .$statusIndicatorBox;
    
    $metadataInputPanel=createElement('div','metadataInputPanel','inputPanel',$metadataInputPanelContents);


    $buttonOutputArea=createElement('p','buttonOutputArea','outputArea','');
    $buttonAreaContainer=createElement('div','buttonOutputContainer','outputContainer',$buttonOutputArea);

    
    $inputPanelArea=createElement('p','inputPanelArea','inputArea','');
    $inputPanelAreaContainer=createElement('div','inputPanelContainer','panelContainer',$inputPanelArea);

    $scriptLink='<script src="js/exercisesScripts.js"></script>';
    //echo '<h1>excercises front-end';
    $headLine=createElement('h3','exercisesTitle','subtitle','Exercises Data Input');

    $dataSoFar=createElement('p','dataSoFarOutputArea','outputArea','');
    $dataSoFarContainer=createElement('div','dataSoFarContainer','outputContainer',$dataSoFar);

    $pageContents=''
            .$headLine
            .$metadataInputPanel
            .$buttonAreaContainer
            .$inputPanelAreaContainer
            .$dataSoFar
            .$scriptLink;

    echo $pageContents;
?>