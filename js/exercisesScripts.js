

function exercisesInit()
{
    console.log("exercises");
    attachStylesheet();
    fetchRecordsForButtons();
}


function attachStylesheet()
{
    let loc='css/exercisesStyles.css';
    let el=document.createElement('link');
    el.type='text/css';
    el.rel='stylesheet';
    el.href=loc;
    document.body.appendChild(el);
}

function handleMetadataSubmit()
{
    console.log("Handle metadata submit");
    let outputMessage='';
    let ids=["figureInputMeta","title","description","picLocation"];
    let userInputs=[];
    for(let i=0;i<ids.length;i++)
    {
        let thisId=ids[i];
        let thisInput=document.getElementById(thisId).value;
        let unitArray={id:thisId,input:thisInput};
        userInputs.push(unitArray);
    }
    console.log(userInputs);
    for (const item in userInputs)
    {
       // console.log(userInputs[item]["input"]);
        if(userInputs[item]["id"]==="figureInputMeta" && userInputs[item]["input"]==='')
        {
            writeToStatusEx("Invalid input");
            return false;
        }
        if(userInputs[item]["id"]==="title" && userInputs[item]["input"]==='')
        {
            writeToStatusEx("Invalid input");
            return false;
        }      
    }
    //console.log(userInputs);
    writeToStatusEx("Input Accepted");
    transmitMetadataInputs(userInputs);
    for(let i=0;i<ids.length;i++)
    {
        let thisId=ids[i];
        document.getElementById(thisId).value='';      
    }
}

function fetchRecordsForButtons()
{
    callBackendEx("fetchRecordsList",'',printButtons);
}

function printButtons(data)
{
    console.log(data)
    let buttonContent='';
    for(let i=0;i<data.length;i++)
    {
        let figure=data[i]["figure"];
        let title=data[i]["title"];
        let button=
        `
            <button onClick="handleMetaButtons('${figure}')">${figure}${title?'|'+title:''}</button>
        `;
        buttonContent+=button;
    }
    document.getElementById("buttonOutputArea").innerHTML=buttonContent;
}


function conjureInputPanel(data)
{
    let dat=data["data"];
    let met=data["metaData"];
    let tableOpener=
    `
        <table><tbody>
    `;
    let tableCloser=
    `
        </tbody></table>
    `;
    let stepInput=
    `   
        <input id="stepInput" type="number" />
    `;
    let stepTextInput=
    `
        <textArea id="stepTextInput" ></textArea>
    `;
    let tableHeaders=
    `
        <tr>
            <th>
                Step No.
            </th>
            <th>
                Step Text
            </th>
            <th>
            </th>
        </tr>
    `;
    let tableInput=
    `
        <tr>
            <td>
                ${stepInput}
            </td>
            <td>
                ${stepTextInput}
            </td>
            <td>
                <button onClick="handleAddData('${met[0]["figure"]}')">+</button>
            </td>
        </tr>
    `;
    
    
    let fullTable=
    `
        ${tableOpener}
        ${tableHeaders}
        ${tableInput}
        ${tableCloser}
    `;
    let title=
    `
        <h3>${met[0]["figure"]}</h3>
        <p>${met[0]["title"]}</p>
    `;
    let subTitle=
    `
        <p>${met[0]["description"]}</p>
    `;
    let submitButton=
    `
        <button onClick="dataSubmit('${met["figure"]}')"
    `;

      let statusIndicator=
    `
        <p id="dataInputStatusIndicator" class="statusIndicator">Ready</p>
    `;

    let panelContents=
    `
        ${title}
       
        ${fullTable}
        ${statusIndicator}
    `;

  


    let panel=
    `
        <div id="dataInputPanel" class="inputPanel">${panelContents}</div>
    `;
    document.getElementById("inputPanelArea").innerHTML=panel;
    conjureDataPanel(data);
    
}


function conjureDataPanel(data)
{
    console.log("Conjure data panel",data);
    let dat=data["data"];
    let met=data["metaData"];
    console.log("dat",dat);
    console.log("met",met);
    let tableOpener=
    `
        <table><tbody>
    `;
    let tableCloser=
    `
        </tbody></table>
    `;
    let tableHeaders=
    `
        <tr>
            <th>#</th>
            <th>Step</th>
        </tr>
    `;
    let tableRows='';
    for(let i=0;i<dat.length;i++)
    {
        tableRows+=
        `
            <tr>
                <td>${dat[i]["stepNumber"]}</td><td>${dat[i]["stepText"]}</td>
            </tr>
        `;
    }
    let dataTable=
    `
        ${tableOpener}
        ${tableHeaders}
        ${tableRows}
        ${tableCloser}
    `;
    document.getElementById("dataSoFarOutputArea").innerHTML=dataTable;
}


function handleAddData(figure)
{
    let stepNumber=document.getElementById("stepInput").value; 
    let stepText=document.getElementById("stepTextInput").value;
    console.log("Step number",stepNumber);
    console.log("Step text",stepText);
    console.log("Figure",figure);
    if (stepNumber.length==0 || stepText.length==0)
    {
        writeToDataStatusIndicator("Invalid Input");
        return false;
    }
    else 
    {
        writeToDataStatusIndicator("Input Accepted");
        let params={figure:figure,stepNumber:stepNumber,stepText:stepText};
        let functionName="submitData";
        document.getElementById("stepTextInput").value='';
        document.getElementById("stepInput").value=Number(stepNumber)+1;
        let el=document.getElementById("stepTextInput");
        if (el)
        {
            el.focus();
        }
        // special chained caller to ensure refresh after updating a step?
        callBackendEx(functionName,params,writeToDataStatusIndicator);
        afterHandleAddData(figure);
    }
}

function writeToDataStatusIndicator(message)
{
    document.getElementById("dataInputStatusIndicator").innerHTML=message;  
}


function afterHandleAddData(figure)
{
    callBackendEx("loadFigureDataAndMetadata",{figure:figure},conjureDataPanel);
}


function handleMetaButtons(figure)
{
    console.log("Handle meta buttons figure",figure);
    callBackendEx("loadFigureDataAndMetadata",{figure:figure},conjureInputPanel);
}

function writeToStatusEx(message)
{
    document.getElementById("metadataStatusIndicator").innerHTML=message;
    if(message!="Invalid Input")
    {
         fetchRecordsForButtons();

    }
}

function transmitMetadataInputs(userInputs)
{
   // console.log(userInputs);
    callBackendEx('submitMetadata',userInputs,writeToStatusEx);
    
}


function callBackendEx(functionName,params,callback)
{
    let fetchTarget='php/exercises_controller.php';
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
exercisesInit();