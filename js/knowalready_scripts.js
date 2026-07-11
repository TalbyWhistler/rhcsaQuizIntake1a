

let activeChapter=0;

function knowAlreadyInit()
{
    console.log("know already init");
    attachStyleSheet();
  //  testApi();
}



function testKnowAlready(input)
{
    console.log("Test knowalready with input " + input);
}



function attachStyleSheet()
{
    const styleSheetLocation='css/knowalready_styles.css';
    const styleLink=document.createElement('link');
    styleLink.rel='stylesheet';
    styleLink.type='text/css';
    styleLink.href=styleSheetLocation;
    document.head.appendChild(styleLink);
}

function byId(identification)
{
    return document.getElementById(identification);
    let chapter=byId("kaAnswerChapterInput").value;
    let answer=byId("kaAnswerTextArea").value;
}

function handleKnowAlreadySubmit()
{
    console.log("Handle knowalready submit");
    let chapter=byId("chapterInput").value; 
   
    let questionNumber=byId("questionNumberInput").value;
    let question=byId("questionArea").value;
    let a=byId("inputA").value;
    let b=byId("inputB").value;
    let c=byId("inputC").value;
    let d=byId("inputD").value;
    console.log("chapter is ",chapter,question,a,b,c,d);
    if (chapter.length==0||question.length==0||a.length==0||b.length==0||c.length==0||d.length==0 || questionNumber.length==0)
    {
        byId("knowAlreadyStatusIndicator").innerHTML="Invalid Input";
        setTimeout(()=>{byId("knowAlreadyStatusIndicator").innerHTML="Ready"},3000);
    }
    else 
    {
        byId("knowAlreadyStatusIndicator").innerHTML="Input Accepted";
        byId("inputA").value='';
        byId("inputB").value='';
        byId("inputC").value='';
        byId("inputD").value='';
        byId("questionArea").value='';
      //  byId("chapterInput").value='';
        byId("questionNumberInput").value='';
        const element=byId("questionNumberInput");
       
        if (element){element.focus()};
        submitQuestionData(chapter,questionNumber,question,a,b,c,d);
        
        // make insert call to database here 
    }  
}

function afterQuestionUpdate(data)
{

    byId("knowAlreadyStatusIndicator").innerHTML=data;
    setTimeout(()=>{byId("knowAlreadyStatusIndicator").innerHTML="Ready"},3000);
}

function submitQuestionData(chapter,questionNumber,question,a,b,c,d)
{
    let params=
    {
        chapter:chapter,
        questionNumber:questionNumber,
        question:question,
        a:a,
        b:b,
        c:c,
        d:d
    }
    let functionName='submitQuestionData'
    callBackendKA(functionName,params,afterQuestionUpdate);
}

function testPrint(data)
{
    console.log(data);
}


function testApi()
{
    console.log("test api ");
    let params={testParam:"Hey yo"};
    callBackendKA("testo",params,testPrint);
}

function kaHandleAnswerSubmit() 
{
    console.log("Handle answer submit");
    let chapter=byId("kaAnswerChapterInput").value;
    let questionNumber=byId("answerQuestionNumberInput").value;
    let answer=byId("kaAnswerTextArea").value;
    let answerLetter=byId("answerLetterInput").value;
    if (chapter.length==0||questionNumber.length==0||answer.length==0||answerLetter.length==0)
    {
        byId("kaAnswerStatusIndicator").innerHTML="Invalid Input";
        setTimeout(()=>{byId("kaAnswerStatusIndicator").innerHTML="Ready"},3000);
    }
    else 
    {
        byId("kaAnswerStatusIndicator").innerHTML="Input Accepted";
        submitAnswerData(chapter,questionNumber,answerLetter,answer);
        //setTimeout(()=>{byId("kaAnswerStatusIndicator").innerHTML="Ready"},3000);
     //   byId("kaAnswerChapterInput").value='';
        byId("answerQuestionNumberInput").value='';
        byId("kaAnswerTextArea").value='';
        byId("answerLetterInput").value='';
        const element=byId("answerQuestionNumberInput");
        if (element){element.focus();};
    }
}

function submitAnswerData(chapter,questionNumber,answerLetter,answer)
{
    let params=
    {
        chapter:chapter,
        questionNumber:questionNumber,
        answerLetter:answerLetter,
        answer:answer
    };
    let functionName='submitAnswerData';
    callBackendKA(functionName,params,afterAnswerUpdate);
}

function afterAnswerUpdate(data)
{
    byId("kaAnswerStatusIndicator").innerHTML=data;
    setTimeout(()=>{byId("kaAnswerStatusIndicator").innerHTML="Ready"},3000);
}


function callBackendKA(inputFunction,parameters,callback)
{
    let fetchTarget='php/knowalready_backend.php';
    let inputPackage={function:inputFunction,params:parameters};
    inputPackage=JSON.stringify(inputPackage);
    fetch(fetchTarget, 
        {
            method:'POST',
            headers:{'Content-Type':'application/json'},
            body:inputPackage
        }
    )
    .then(response=>response.json())
    .then(data=>callback(data));
}

function handleReaderChapterButton(chapter)
{
    console.log('Reader button',chapter);
    writeToReaderChapterIndicator(chapter);
    callBackendKA('fetchQuestionsByChapter',{'chapter':chapter},readerPrint);
}

function readerPrint(data)
{
    
    console.log("Question data",data["questions"]);
   console.log("Question Length",data["questions"].length);
   console.log("Answer data length",data["answers"].length);
   /*
   if (data["questions"].length<10 || data["answers"].length<10)
   {
        fetchMissing();
     //   return;
   }
     */
   

    // console.log("Answer data",data["answers"]);
   let questionOut='';
   for (let i=0;i<10;i++)
   {
        if(!data["questions"][i])
        {
            console.log('missing data detected');
            continue;
        }
        console.log(data["questions"][i]['questionNumber']);
        let questionNumber=data["questions"][i]['questionNumber'];
        let questionText=data["questions"][i]['questionText'];
        let a=data["questions"][i]['a'];
        let b=data["questions"][i]['b'];
        let c=data["questions"][i]['c'];
        let d=data["questions"][i]['d'];
        let hasSecond=data["questions"][i]['hasTwoAnswers']==1?'True':'False';
        if (!data["answers"][i])
        {
            console.log("missing data detected");
            continue;
        }
        let answerLetter=data["answers"][i]['answerLetter'];
        let answerText=data["answers"][i]['answer'];
        let secondAnswer=data["answers"][i]['secondAnswer'];
        questionOut+=
        `
            <strong>${questionNumber}. ${questionText}</strong>
            </br>
            a: ${a}
            </br>
            b: ${b}
            </br>
            c: ${c}
            </br>
            d: ${d}
            </br>
            Has two responses: ${hasSecond}
            </br>
            <strong><label>Response:</label></strong>${answerLetter}
            </br>
             <i>${answerText}</i>
            </br>
           <strong> <label>Second response</strong>(if any):</label>${secondAnswer}
            </br>
            </br>
        `;
        
   }
  // console.log(questionOut);
   document.getElementById("readerQAndAOutput").innerHTML=questionOut;
    
    //document.getElementById("readerQAndAOutput").innerHTML=qAndAOutput;
    // document.getElementById("readerQAndAOutput").innerHTML=qAndAOutput;
}

function fetchMissing()
{
    let chapter=document.getElementById("chapterIndicator").innerHTML;
    callBackendKA("fetchMissing",{'chapter':chapter},console.log);
}


function writeToReaderChapterIndicator(message)
{
    document.getElementById("chapterIndicator").innerHTML=message;
}
knowAlreadyInit();