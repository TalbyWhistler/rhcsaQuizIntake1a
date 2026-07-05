<?php 
        include_once 'tools.php';
        $title=createElement('h1','ceInTitle','title',"Chapter Lab Data Input");
        $scriptLink=
        "
            <script src='js/chapterEndScripts.js'></script>
        ";

        $br='</br>';

        $chapterInput="<input id='chapterInput' class='input' type='number' />";
        $chapterTitleInput=createInput("chapterTitleInput","input");
        $labIntroInput="<textarea id='introInput' class='input' rows='4' cols='80'></textarea>";
        $chapterInputLabel=createElement('label','chapterInputLabel','label','Chapter');
        $chapterTitleInputLabel=createElement('label','chapterTitleInputLabel','label','Chapter Title');
        $labIntroInputLabel=createElement('label','labIntroInputLabel','label','Lab Introduction Text');
        $metaSubmitButton=createButton("metaSubmitButton","submitButton","handleMetaSubmit","Submit");
        
        $metaStatusIndicator=createElement('p','metaStatusIndicator','statusIndicator','Ready');
        $metaStatusBox=createElement('div','metaStatusIndicatorBox','indicatorBox',$metaStatusIndicator);

        $activeChapterIndicatorLabel=createElement('label','activeChapterIndicatorLabel','label','Chapter:');
        $activeChapterIndicator=createElement('label','activeChapterIndicator','label','None');
        $activeChapterIndicatorContents=
        "
            $activeChapterIndicatorLabel$activeChapterIndicator
        ";
        $activeChapterIndicatorBox=createElement('div','activeChapterIndicatorBox','statusIndicatorBox',$activeChapterIndicatorContents);
        $metaSubheading=createElement('h2','metaSubheading','subHeading',"Metadata Input");
        $dataSubheading=createElement('h2','dataSubheading','subHeading',"Steps Input");
        
        $metaInputPanelContents=
        "
            $chapterInput$chapterInputLabel
            $br 
            $chapterTitleInput$chapterTitleInputLabel
            $br 
            $labIntroInputLabel
            $br
            $labIntroInput
            $br
            $metaSubmitButton
            $metaStatusBox
           
        ";

        $metaInputPanel=createElement('div','metaInputPanel','inputPanel',$metaInputPanelContents);

        $buttonAreaContents='';
        for ($i=1;$i<=24;$i++)
            {
                $buttonAreaContents=$buttonAreaContents.
                "<button id='chapterButton$i' class='chapterButton' onclick='handleChapterButton($i)'>$i</button>";
            }

        $stepInput="<input id='stepInput' class='input' type='number'/>";
        $stepInputLabel=createElement("label","stepInputLabel","label","Step number");
        $stepTextInput="<textarea id='stepTextInput' class='input' rows='4' cols='80' ></textarea>";
        $stepTextInputLabel=createElement("label","stepTextInputLabel","label","Step instruction");
        $stepSubmit=createButton("stepSubmitButton","submitButton","handleStepSubmitButton","Submit");
        $stepStatusIndicator=createElement('p','stepStatusIndicator','statusIndicator','Ready');
        $stepStatusIndicatorBox=createElement('div','stepStatusIndicatorBox','statusIndicatorBox',$stepStatusIndicator);
        $stepInputPanelContents=
        "
            $stepInput$stepInputLabel
            $br
            $stepTextInputLabel
            $br
            $stepTextInput
            $br
            $stepSubmit
            $br
            $stepStatusIndicatorBox
        ";
        $stepInputPanel=createElement('div','stepInputPanel','inputPanel',$stepInputPanelContents);
        
        $buttonArea=createElement('div','buttonArea','outputArea',$buttonAreaContents);

        $headerOutputArea=createElement('p',"labHeaderOutputArea","outputArea","");
        $labOutputArea=createElement("p","labOutputArea","outputArea","");

        $pageContents=
        "
            $title
            $scriptLink
            $metaSubheading
            $metaInputPanel
            $dataSubheading
            $buttonArea
            $activeChapterIndicatorBox
            $stepInputPanel
            $headerOutputArea
            $labOutputArea
        ";
        $pageContainer=createElement('d','ceInContainer','pageContainer',$pageContents);



        echo $pageContainer;


?>