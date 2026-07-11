<?php 

    function ce($element,$id,$class,$inner)
    {
        $elementString='';
        $elementString=$elementString.'<'.$element.' id="'.$id.'" class="'.$class.'"';
        $elementString=$elementString.'>';
        $elementString=$elementString.$inner;
        $elementString=$elementString.'</'.$element.'>';
        return $elementString;
    }

function ci($id,$class)
    {
        $elementString='';
        $elementString=$elementString.'<input id="'.$id.'" class="'.$class.'"';
        $elementString=$elementString.'/>';
       // $elementString=$elementString.$inner;
    //    $elementString=$elementString.'</'.$element.'>';
        return $elementString;
    }

function cb($id,$class,$function,$inner)
    {
        $elementString='';
        $elementString=$elementString
            .'<button id='.$id.' class='.$class.' onclick="'.$function.'()">'
            .$inner 
            .'</button>';
        return $elementString;
    }

function knowAlreadyPage()
{
    $br='</br>';
    $scriptLink='<script src="js/knowalready_scripts.js"></script>';
    $questionAreaLabel=ce('label','questionAreaLabel','label','Question:');
    $title=ce('h3','knowAlreadyTitle','subtitle','Do I know this already?');
    $titleDiv=ce('div','knowAlreadyTitleDiv','titleDiv',$title);

    $subtitle="Question and answer intake for the know already quizzes.";
    $subtitleDiv=ce('div','knowAlreadySubtitleDiv','subtitleDiv',$subtitle);


    $questionPanelTitle=ce('h3','questionPanelTitle','panelTitle','Question Insert');
    $chapterLabel=ce('label','chapterLabel','label','Chapter');
    $chapterInput='<input type="number" id="chapterInput" class="numberInput"/>';
    $questionNumberLabel=ce('label',"questionNumberLabel","label","Question Number");
    $questionNumberInput='<input type="number" id="questionNumberInput" class="panelInput"/>';
    $questionArea='<textarea rows="5" cols="50" id="questionArea" class="textAreas"></textarea>';
    $inputBoxA=ci("inputA","inputBox");
    $labelA=ce('label',"inputBoxALabel","label",'A');
    $inputBoxB=ci("inputB","inputBox");
    $labelB=ce('label',"inputBoxBLabel","label",'B');
    $inputBoxC=ci("inputC","inputBox");
    $labelC=ce('label',"inputBoxCLabel","label",'C');
    $inputBoxD=ci("inputD","inputBox");
    $labelD=ce('label',"inputBoxDLabel","label",'D');
    $submitButton=cb("knowAlreadySubmitButton","submitButton","handleKnowAlreadySubmit","Submit Data");
    $statusIndicator=ce('p','knowAlreadyStatusIndicator','statusIndicator','Ready');
    $statusIndicatorBox=ce('div','kaStatusIndicatorBox','indicatorBox',$statusIndicator);

    $questionPanelContents=''
        .$questionPanelTitle
        
        .$chapterInput
        .$chapterLabel
        .$br
        
        .$questionNumberInput 
        .$questionNumberLabel 
        .$br
        .$questionAreaLabel 
        .$br
        .$questionArea 
        .$br 
        
       
        .$inputBoxA 
        .$labelA 
        .$br 
       
     
        .$inputBoxB 
         .$labelB 
        .$br 
        
     
        .$inputBoxC 
        .$labelC 
        .$br 
       
       
        .$inputBoxD 
         .$labelD 
        .$br
        .$submitButton
        .$br 
        .$statusIndicatorBox;
    $questionPanel=ce('div','questionPanel','panel',$questionPanelContents);

    $answerChapterLabel=ce("label",'kaAnswerChapterLabel','label','Chapter');
    $answerChapter='<input type="number" id="kaAnswerChapterInput" class="chapterInput"></input>';
    $answerQuestionNumberLabel=ce('label','answerQuestionNumberLabel','label',"Question Number");
    $answerQuestionNumberInput="<input type='number' id='answerQuestionNumberInput' class='panelInput' />";
    $letterLabel=ce('label','answerLetterLabel','label','Correct answer letter');
    $answerLetterInput='<input type="text" id="answerLetterInput" maxlength="1" class="panelInput" />';
    $answer='<textarea cols=50 rows=5 id="kaAnswerTextArea" class="textArea"></textarea>';
    $answerSubmitButton=cb('kaAnswerSubmitButton','submitButton',"kaHandleAnswerSubmit","Submit Data");

    $answerStatusIndicator=ce('p','kaAnswerStatusIndicator','statusIndicator','Ready');
    $answerStatusIndicatorBox=ce('div','kaAnswerStatusIndicatorBox','statusIndicatorBox',$answerStatusIndicator);
    $answerPanelTitle=ce('h3','answerPanelTitle','panelTitle','Response Insert');

    $answerPanelContents=''
        .$answerPanelTitle
       
        .$answerChapter 
        .$answerChapterLabel 
        .$br 
        .$answerQuestionNumberInput 
        .$answerQuestionNumberLabel 
        .$br
        .$answerLetterInput 
        .$letterLabel 
        .$br
        .$answer 
        .$br
        .$answerSubmitButton
        .$answerStatusIndicatorBox; 

    $answerPanel=ce('div','kaAnswerPanel','panel',$answerPanelContents);

    $pageContents=''
        .$scriptLink
        .$titleDiv
        .$subtitleDiv
        .$questionPanel
        .$answerPanel;
    $pageDiv=ce('div','knowAlreadyPageDiv','pageDiv',$pageContents);
    $subHeader=ce('h3','readerSubheader','subtitle','Question Reader');
    $readerStatus=ce('p','readerStatusIndicator','statusIndicator','Ready');
    $chapterIndicatorLabel=ce('label','chapterIndicatorLabel','label','Chapter: ');
    $chapterIndicator=ce('label','chapterIndicator','chapterIndicator','None');
    $readerQAndAOutput=ce("p","readerQAndAOutput","outputArea",'');
    $buttons='';
    for($i=1;$i<=25;$i++)
        {
            $buttons=$buttons.
            "
                <button id='chapterButton$i' class='chapterButton' onclick='handleReaderChapterButton($i)'>$i</button>
            ";
        }
    
    $page2Contents=
    "
        $subHeader
        $buttons
        $readerStatus
        $chapterIndicatorLabel$chapterIndicator
        $readerQAndAOutput
    ";
    $page2Div=ce('div','page2Div','pageDiv',$page2Contents);
    return "<div class='row'>$pageDiv.$page2Div</div>";
}

echo knowAlreadyPage();
?>