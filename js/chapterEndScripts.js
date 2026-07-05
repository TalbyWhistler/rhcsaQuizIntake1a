const metaChapterInputId="chapterInput";
const metaChapterTitleInputId="chapterTitleInput";
const labIntroInputId="introInput";

const activeChapterIndicator="activeChapterIndicator";

const stepNumberInputId="stepInput";
const stepInstructionInputId="stepTextInput";

const metaStatusIndicator="metaStatusIndicator";
const stepStatusIndicator="stepStatusIndicator";


const stepsOutputAreaId="labOutputArea";

let activeChapter=0;
let globalData;
let globalMeta;




function writeToMetaStatus(message)
{
    if (message!='Ready' && activeChapter!=0)
    {
         fetchSteps(activeChapter);
    }
    document.getElementById(metaStatusIndicator).innerHTML=message;
    setTimeout(writeToMetaStatus,3000,"Ready");
}

function writeToStepStatus(message)
{
    if (message!='Ready')
    {
         fetchSteps(activeChapter);
    }
    document.getElementById(stepStatusIndicator).innerHTML=message;
    setTimeout(writeToStepStatus,3000,"Ready");
   
}



function writeToChapterIndicator(message)
{
    document.getElementById(activeChapterIndicator).innerHTML=message;
}

function chapterEndInInit()
{
    console.log("Chapter end");
    attachStylesheet();
}

function attachStylesheet()
{
    let loc='css/chapterEndStyles.css';
    let el=document.createElement('link');
    el.type='text/css';
    el.rel='stylesheet';
    el.href=loc;
    document.body.appendChild(el);
}

function handleMetaSubmit()
{
    console.log('Handle meta submit');
    let chapterInput=document.getElementById(metaChapterInputId).value; 
    let chapterTitleInput=document.getElementById(metaChapterTitleInputId).value;
    let labIntro=document.getElementById(labIntroInputId).value; 
    console.log("chapter",chapterInput,"chapterTitle",chapterTitleInput,"labIntro",labIntro);
    if (chapterInput.length<1 || chapterTitleInput.length<1 || Number(chapterInput) < 1 || Number(chapterInput) > 24)
    {
        writeToMetaStatus("Invalid input");
        setTimeout(writeToMetaStatus,3000,"Ready");
        return false;
    }
    else 
    {
        writeToMetaStatus("Input accepted");
        let params={'chapter':chapterInput,'chapterTitle':chapterTitleInput,'labIntro':labIntro};
        let outputMessage=callToLabBackend("submitMetadata",params,writeToMetaStatus);
        clearMetaInputs();
        
        return true;
    }
}

function clearMetaInputs()
{
    let inputs=['chapterInput','chapterTitleInput','introInput'];
    for (const i of inputs)
    {
        //console.log(document.getElementById(i).value);
        document.getElementById(i).value='';
    }
}


function callToLabBackend(functionName,params,callback)
{
    let fetchTarget='php/chapterend_controller.php';
    let inputPackage={'function':functionName,'params':params};
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

function handleChapterButton(chapter)
{
    console.log("Chapter",chapter);
    activeChapter=chapter;
    writeToChapterIndicator(activeChapter);
    let functionName='fetchMetadataAndData';
    let params={'chapter':chapter};
    callToLabBackend(functionName,params,handleChapterFetch);
}

function handleChapterFetch(data)
{
     console.log(data);
     let inputMeta=data["metaData"][0];
     globalMeta=inputMeta;
     if (!inputMeta)
     {
        document.getElementById(stepsOutputAreaId).innerHTML=`No data at this time for chapter ${activeChapter}`;
        return false;
     }
     let chapter=inputMeta["chapter"];
     activeChapter=chapter;
     let chapterTitle=inputMeta["chapterTitle"];
     let chapterIntro=inputMeta["labIntro"];
     let stepsHeader=
     `
        <h3>Lab for Chapter ${activeChapter}</h3>
        <label>${chapterTitle}</label>
        <p>${chapterIntro}</p>
     `;
     /*
    for(const i of data["data"])
    {
        console.log(i);
    } 
        */
    let stepsPanelContent=
    `
        ${stepsHeader}
    `;
    let stepsPanel=
    `
        <div id="stepsPanel">${stepsPanelContent}</div>
    `;
    document.getElementById("labHeaderOutputArea").innerHTML=stepsPanel;
    fetchSteps(chapter);

   //  console.log(inputMeta);
   //  console.log(inputData);
}

function fetchSteps(chapter)
{
    let functionName="fetchSteps";
    let params={'chapter':chapter};
    callToLabBackend(functionName,params,printSteps);
}

function printSteps(data)
{
    console.log(data);
    let localSteps=[];
    for(const i of data)
    {
        //console.log(i["stepNumber"]);
        localSteps[i["stepNumber"]]=i["stepText"];
    }
    let tableOpener="<table><tbody>";
    let tableCloser="</tbody></table>";
    let tableRows='';
    for (let i=1;i<localSteps.length;i++)
    {
        if (localSteps[i])
        {
            tableRows+=
            `
                <tr>
                    <td><button onclick="handleListDelete(${i})">Del.</button></td><td><strong>${i}</strong></td><td>${localSteps[i]}</td>
                </tr>
            `;
        }
        else
        {
            tableRows+=
            `
                <tr>
                    <td><button onclick="handleListDelete(${i})">Del.</button></td><td><strong>${i}</strong></td><td></td>
                </tr>
            `;
        }
        
    }
    let table=
    `
        ${tableOpener}
        ${tableRows}
        ${tableCloser}
    `;
    let outputArea=document.getElementById(stepsOutputAreaId);
    outputArea.innerHTML=table;

}

function handleStepSubmitButton()
{
    console.log('Handle step submit');
    let stepNumber=document.getElementById(stepNumberInputId).value;
    let stepText=document.getElementById(stepInstructionInputId).value;
    console.log("stepNumber",stepNumber,"stepText",stepText);
    if (activeChapter===0)
    {
        writeToStepStatus('No Chapter Chosen')
        
        return false;
    }
    if (stepNumber.length==0 || stepNumber < 1 || stepNumber > 24 || stepText.length==0)
    {
        writeToStepStatus("Invalid input");
       
        return false;
    }

    let params={'chapter':activeChapter,'stepNumber':stepNumber,'stepText':stepText};
    let functionName="submitStep";
    callToLabBackend(functionName,params,writeToStepStatus);
    document.getElementById(stepNumberInputId).value=Number(stepNumber)+1;
    document.getElementById(stepInstructionInputId).value='';
    el=document.getElementById(stepInstructionInputId);
    el.focus();
  //  fetchSteps(activeChapter);
    //return true;   
}

function handleListDelete(step)
{
    let functionName="deleteListStep";
    let params={'chapter':activeChapter,'stepNumber':step};
    callToLabBackend(functionName,params,writeToStepStatus);
 //   fetchSteps(activeChapter);
}

chapterEndInInit();