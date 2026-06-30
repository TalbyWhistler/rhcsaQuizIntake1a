<?php 
   // include 'tools.php';
    $br='</br>';
    $inputLabelLabels=['Figure','Chapter','Description','Value0Label','Value1Label','Value2Label','Value3Label'];
    $metadataInputPanelContents='';
    for($i=0;$i<sizeof($inputLabelLabels);$i++)
        {
            $metadataInputPanelContents=$metadataInputPanelContents 
                .createInput($inputLabelLabels[$i],'metadataInput')
                .createElement('label',$inputLabelLabels[$i].'Label','metadataInputLabel',$inputLabelLabels[$i])
                .$br;
        };

    $metadataSubmitbutton=createButton('metadataSubmitbutton','submitButton','handleMetadataSubmit','Submit');
    $statusBoxContents=createElement('p','memoryQuizStatus','statusIndicator','Ready');
    $statusBox=createElement('div','statusIndicatorBox','indicatorBox',$statusBoxContents);

    $metadataInputPanelContents=
        $metadataInputPanelContents
        .$metadataSubmitbutton
        .$statusBox;
   
    $metadataInputPanel=createElement('div','metadataInputPanel','inputPanel',$metadataInputPanelContents);
    $scriptLink='<script src="js/memoryQuizScripts.js"></script>';
    
    $quizPageHeadline=createElement('h1','quizPageTitle','title','Memory Tables Input');

    $availableFiguresOutputArea=createElement('p','figuresOutputArea','outputArea','');

    $editTableOutput=createElement('p','editTableOutput','output','');
    
    $outputContents=''
        .$quizPageHeadline 
        .$metadataInputPanel
        .$availableFiguresOutputArea
        .$editTableOutput
        .$scriptLink; 
    
        $outputContainer=createElement('div','quizPageContainer','pageContainer',$outputContents);

    echo $outputContainer;

?>