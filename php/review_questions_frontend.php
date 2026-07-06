<?php 
      //  include 'tools.php';
        

        $scriptLink=
        '
            <script src="js/rqScripts.js"></script>
        ';
        $buttons='';
        for($i=1;$i<=24;$i++)
            {
                $buttons=$buttons.
                '<button class="chapterButton" id="chapterButton'.$i.'" onclick="chapterButton('.$i.')">'.$i.'</button>';
            };
        $title=createElement("h3","rqIntakeTitle","subtitle","Review Questions Intake");

        $br='</br>';
        $questionNumber=
        '
            <input type="number" id="questionNumberInput" class="input" />
        ';
        $questionText=
        '
            <textarea id="questionTextArea" rows=3 cols=40></textarea>
        ';
        $answerText=
        '
            <textarea id="answerTextArea" rows=3 cols=40></textarea>
        ';
        $questionNumberAnswer=
        '
            <input type="number" id="questionNumberInputAnswer" class="input" />
        ';
        $selectedChapterIndicator=createElement('label','selectedChapterIndicator','statusIndicator','None');
        $selectedChapterIndicatorLabel=createElement('label','chapterLabel','label','Current Selected Chapter: ');
        $selectedChapterBox=createElement('div','selectedChapterIndicatorBox','statusIndicatorBox',$selectedChapterIndicatorLabel.$selectedChapterIndicator);


        $questionsSubheading=createElement('p','questionSubheading','subHeading','Questions Input');
        $answersSubheading=createElement('p','answersSubheading','subHeading','Answers Input');
        $questionNumberLabel=createElement("label","questionNoLabel","label","Question No.");
        $questionLabel=createElement("label","questionLabel","label","Question Text");
        $answerLabel=createElement("label","answerLabel","label","Answer Text");
        $submitButton=createButton("rqSubmit","submitButton","handleSubmit","Submit");
        $answerSubmitButton=createButton("rqSubmitAnswer","submitButton","handleSubmitAnswer","Submit");
        $questionStatusIndicator=createElement("p","questionStatusIndicator","statusIndicator","Ready");
        $questionStatusIndicatorBox=createElement("div","questionStatusIndicatorBox","statusIndicatorBox",$questionStatusIndicator);

        $answerStatusIndicator=createElement("p","answerStatusIndicator","statusIndicator","Ready");
        $answerStatusIndicatorBox=createElement("div","answerStatusIndicatorBox","statusIndicatorBox",$answerStatusIndicator);


        $inputPanelContents=''
                .$questionsSubheading 
                //.$br
                .$questionNumberLabel.$br.$questionNumber
                .$br
                .$questionLabel.$br.$questionText
                .$br 
                .$submitButton
                .$br
                .$questionStatusIndicator
                .$answersSubheading 
                //.$br
                .$questionNumberLabel.$br.$questionNumberAnswer
                .$br
                .$answerLabel.$br.$answerText
                .$br
                .$answerSubmitButton
                .$br 
                .$answerStatusIndicator;
        $inputPanel=createElement('div','inputPanel','inputPanel',$inputPanelContents);

        $qaOut=createElement('p','qaOut','outputArea','');
        $outputPanel=createElement('div','outputPanel','outputPanel',$qaOut);


        $pageContents=''
            .$title 
            .$buttons
            .$selectedChapterBox
            .$inputPanel
            .$outputPanel
            .$scriptLink;
        $pageContainer=createElement('div','rqIntakePageContainer','pageContainer',$pageContents);

        echo $pageContainer;

?>