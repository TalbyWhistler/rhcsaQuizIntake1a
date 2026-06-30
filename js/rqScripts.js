let activeChapter=0;



function initializeReviewQuestions1a()
{
    console.log("Review questions intake");
    attachStyles();
}


function attachStyles()
{
    let loc='css/reviewQuestionsStyles.css';
    let el=document.createElement('link');
    el.type='text/css';
    el.rel='stylesheet';
    el.href=loc;
    document.body.appendChild(el);
}


function chapterButton(chapter)
{
    console.log("Chapter button",chapter);
    document.getElementById("selectedChapterIndicator").innerHTML=chapter;
    activeChapter=chapter;
    callBackendQa("fetchQa",{chapter:chapter},printQa);
}


function printQa(data)
{
    const NUM_QUESTIONS=20;
    let questionsLength=data["questions"].length;
    let answersLength=data["answers"].length;
    let internalQuestions=[];
    let internalAnswers=[];
    for(let i=0;i<questionsLength;i++)
    {
        internalQuestions[data["questions"][i]["questionNo"]]=data["questions"][i]["questionText"];
    }
    for(let i=0;i<answersLength;i++)
    {
        internalAnswers[data["answers"][i]["questionNo"]]=data["answers"][i]["answerText"];
    }
    
    let tableLabel=`<label><strong>Chapter ${activeChapter} Review Questions and Answers</strong></label>`
    let tableOpener=
    `
        <table><tbody>
    `;
    let tableCloser=
    `
        </tbody></table>
    `;
    let tableRows='';
    console.log(internalQuestions);
    console.log(internalAnswers);
    for(let i=0;i<NUM_QUESTIONS;i++)
    {
      //  console.log(i);
        if (internalQuestions[i] || internalAnswers[i])
        {
            tableRows=tableRows+
             `
                <tr>
                    <td class="questions">${i}</td><td>${internalQuestions[i]}</td>
                </tr>
                <tr>
                    <td>A:</td>
                    <td class="answers"><i>${internalAnswers[i]?internalAnswers[i]:''}</i></td>
                </tr>
            `;
        }
        
    }
    let table=tableOpener+tableRows+tableCloser;
    document.getElementById("qaOut").innerHTML=tableLabel+table;


}


function writeToQuestionStatus(message)
{
    document.getElementById("questionStatusIndicator").innerHTML=message;
    if (message=='Record updated')
    {
        chapterButton(activeChapter);
    }
}

function handleSubmit() 
{
    console.log("handle submit");
    let questionNumber=document.getElementById("questionNumberInput").value;
    let questionText=document.getElementById("questionTextArea").value;
    console.log('question number/text',questionNumber,questionText);

    if (activeChapter===0)
    {
        console.log("No chapter chosen");
        writeToQuestionStatus("No chapter chosen");
        return false;
    }
    if (questionNumber=='')
    {
        console.log("Invalid input");
        writeToQuestionStatus("Invalid input");
        return false;
    }
    if (questionText=='')
    {
        console.log("Invalid input");
        writeToQuestionStatus("Invalid input");
        return false;
    }

    writeToQuestionStatus("Input accepted");
    let focusEl=document.getElementById("questionTextArea");
    focusEl.value='';
    focusEl.focus();
    let qNumber=Number(document.getElementById("questionNumberInput").value);
    document.getElementById("questionNumberInput").value=qNumber+1;

    let functionName='submitQuestion';
    let chapter=activeChapter;
    let params={chapter:chapter,question:questionNumber,questionText:questionText};
    callBackendQa(functionName,params,writeToQuestionStatus);
    
}

function writeToAnswerStatus(message)
{
    document.getElementById("answerStatusIndicator").innerHTML=message;
    if (message=='Record updated')
    {
        chapterButton(activeChapter);
    }
}

function handleSubmitAnswer()
{
    console.log("Handle submit answer");
    let questionNumber=document.getElementById("questionNumberInputAnswer").value;
    let answerText=document.getElementById("answerTextArea").value;


    if (activeChapter===0)
    {
        console.log("No chapter chosen");
        writeToAnswerStatus("No chapter chosen");
        return false;
    }
    if (questionNumber=='')
    {
        console.log("Invalid input");
        writeToAnswerStatus("Invalid input");
        return false;
    }
    if (answerText=='')
    {
        console.log("Invalid input");
        writeToAnswerStatus("Invalid input");
        return false;
    }

    writeToAnswerStatus("Input accepted");

    let focusEl=document.getElementById("answerTextArea");
    focusEl.value='';
    focusEl.focus();

    let aNumber=Number(document.getElementById("questionNumberInputAnswer").value);
    document.getElementById("questionNumberInputAnswer").value=aNumber+1;
    let functionName='submitAnswer';
    let params={chapter:activeChapter,question:questionNumber,answer:answerText};
    callBackendQa(functionName,params,writeToAnswerStatus);





    console.log(questionNumber,answerText);
}

function callBackendQa(functionName,params,callback)
{
    let fetchTarget='php/review_questions_controller.php';
    let inputPackage={function:functionName,params:params};
    inputPackage=JSON.stringify(inputPackage);
    fetch(fetchTarget,
        {
            method:'POST',
            headers:{'Content-Type':'Application/json'},
            body:inputPackage
        }
    )
    .then(response=>response.json())
    .then(data=>callback(data));
}

initializeReviewQuestions1a();