const figureInput=document.getElementById("Figure");
const chapterInput=document.getElementById("Chapter");
const descriptionInput=document.getElementById("Description");
const value0Input=document.getElementById("Value0Label");
const value1Input=document.getElementById("Value1Label");
const value2Input=document.getElementById("Value2Label");
const value3Input=document.getElementById("Value3Label");
const statusOutput=document.getElementById("memoryQuizStatus");

const figureButtonOutput=document.getElementById("figuresOutputArea");
const editTableOutput=document.getElementById("editTableOutput");

const editTableInput0=document.getElementById("input0");
const editTableInput1=document.getElementById("input1");
const editTableInput2=document.getElementById("input2");
const editTableInput3=document.getElementById("input3");

function validateMetadataSubmit()
{
    console.log("Validate metadata submit");
    let figure=figureInput.value;
    let chapter=chapterInput.value;
    let description=descriptionInput.value;
    let value0=value0Input.value;
    let value1=value1Input.value;
    let value2=value2Input.value;
    let value3=value3Input.value;
    if (figure.length==0 || chapter.length==0 || value0.length==0 || value1.length==0)
    {
        
        writeToStatus('Invalid Input');
        return false;
    }
    else 
    {
        if(description.length==0)
        {
            writeToStatus("Provide a description");
            return false;
        }
        writeToStatus('Input Accepted')
        $outputArray={figure:figure,chapter:chapter,description:description,value0:value0,value1:value1,value2:value2,value3:value3};
        return $outputArray;
    }
}

function fetchAvailableFiguresForEdit()
{
    console.log("Fetch available figures for edit");
    callBackendMq("fetchRecordsList",'',printAvailableFiguresForEdit);
}

function printAvailableFiguresForEdit(data)
{
    let outputButtons='';
    for(let i=0;i<data.length;i++)
    {
        console.log(data[i]["figure"]);
        outputButtons+=
        `<button onClick="handleFigureButtons('${data[i]["figure"]}')">${data[i]["figure"]}</button>`;
    }
    figureButtonOutput.innerHTML=outputButtons;
}

function writeToStatus(message)
{
    statusOutput.innerHTML=message;
}

function initializeMemoryQuizPage()
{
    console.log("Memory quiz page");
    attachStyleSheet();
    fetchAvailableFiguresForEdit();
}


function attachStyleSheet()
{
    let sheetLocation='css/memoryQuizStyles.css';
    let element=document.createElement('link');
    element.href=sheetLocation;
    element.rel='stylesheet';
    element.type='text/css';
    document.body.appendChild(element);
}

function handleMetadataSubmit()
{
    console.log('handle metadata submit');
    let params=validateMetadataSubmit();
    if (params)
    {
        let functionName="transmitMetadata";
        callBackendMq(functionName,params,writeToStatus);
        fetchAvailableFiguresForEdit();
    }
    
    
}

function callBackendMq(functionName,params,callback)
{
    const fetchTarget='php/memory_quiz_controller.php';
    let inputFunction=functionName;
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

function handleFigureButtons(figure)
{
    console.log("Handle figure buttons " + figure);
    let functionName="fetchDataAndMetadata";
    let params={figure:figure};
    callBackendMq(functionName,params,printEditTable);
}

function printEditTable(data)
{
    console.log(data["data"]);
   
    let figure=data["metaData"][0]["figure"];
    let description=data["metaData"][0]["description"];
     let header=`<h3>${figure}</h3><p>${description}</p>`;
    let value0=data["metaData"][0]["value0Label"]
    let tableOpener=
    `
        <table><tbody>
    `;
    let tableCloser=
    `
        </tbody></table>
    `;
    let tableHeader=
    `  
        <tr>
            
            <th>${data["metaData"][0]["value0Label"]}</th>
            <th>${data["metaData"][0]["value1Label"]}</th>
            <th>${data["metaData"][0]["value2Label"]}</th>
            <th>${data["metaData"][0]["value3Label"]}</th>
        </tr>
    `;
    let tableRows='';
    

    for(let i=0;i<data["data"].length;i++)
    {
        console.log("data uuid",data["data"][i]["uuid"]);
        let uuid=data["data"][i]["uuid"];
        let deleteButton=
    `
        <button class="deleteButton" onClick="handleDelete('${figure}','${uuid}')">-</button>
    `;
        tableRows=tableRows+
        `
            <tr>
               
                <td>${deleteButton}${data["data"][i]["value0"]}</td>
                <td>${data["data"][i]["value1"]}</td>
                <td>${data["data"][i]["value2"]}</td>
                <td>${data["data"][i]["value3"]}</td>
            </tr>
        `;
    }
     let addButton=
    `
        <button id="addButton" onClick="handleAdd('${figure}')">+</button>
    `;
    let inputLine=
    `
        <tr>
            <td>
                <input id="input0"/>
            </td>
            <td>
                <input id="input1"/>
            </td>
            <td>
                <input id="input2"/>
            </td>
            <td>
                <input id="input3"/>
            </td>
            <td>
                ${addButton}
            </td>
        </tr>
    `;
   
    let table=header+tableOpener+tableHeader+tableRows+inputLine+tableCloser;
    editTableOutput.innerHTML=table;
    let el=document.getElementById("input0");
    if (el)
    {
        el.focus();
    }
}

function handleAdd(figure)
{
    console.log("handle add ",figure);
    let params=validateHandleAdd(figure);
    let functionName='submitFigureValues';
    
    
    if (params!=false)
    {
        console.log('////',functionName);
        console.log('/////',params);
        callBackendMq('submitFigureValues',params,afterHandleAdd);
    }
}

// doubles as after handleDelete
function afterHandleAdd(data)
{
    console.log("After handle add",data);
    let params={figure:data};
    callBackendMq("fetchDataAndMetadata",params,printEditTable);
   // handleFigureButtons(data);
}

function handleDelete(figure,uuid)
{
    console.log("Handle delete",figure,uuid);
    let functionName="deleteEntry";
    let params={figure:figure,uuid:uuid};
    callBackendMq(functionName,params,afterHandleAdd);
}

function validateHandleAdd(figure)
{
    let value0=document.getElementById("input0").value;
    let value1=document.getElementById("input1").value;
    let value2=document.getElementById("input2").value;
    let value3=document.getElementById("input3").value;
    if (value0.length==0 || value1.length==0)
    {
        return false;
    }
    else 
    {
        return{figure:figure,value0:value0,value1:value1,value2:value2,value3:value3};
    }
}

initializeMemoryQuizPage();