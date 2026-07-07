function intakeInit()
{
    console.log("Red Hat data intake page");
    checkForLogin();
}


function writeToLoginStatus(message)
{
    document.getElementById("loginReactionStatus").innerHTML=message;
}

function handleLoginSubmit()
{
    let userName=document.getElementById("userNameInput").value;
    let password=document.getElementById("passwordInput").value;
  //  console.log("handleLoginSubmit",userName,password);
    if(!userName || !password)
    {
        writeToLoginStatus("Invalid Input");
        setTimeout(writeToLoginStatus,3000,"Ready");
    }
    else 
    {
        document.getElementById("userNameInput").value='';
        document.getElementById("passwordInput").value='';
        writeToLoginStatus("Input Accepted");
        let functionName='attemptLogin';
        let params={'username':userName,'password':password};
        console.log(params);
        callBackend(functionName,params,writeToLoginStatus);

        setTimeout(writeToLoginStatus,3000,"Ready");
    }
    setTimeout(checkForLogin,2000);

}


function writeToLoggedIn(message)
{
    document.getElementById("loginStatusIndicator").innerHTML=message;
}

function checkForLogin()
{
   
    callBackend("checkIfLoggedIn","",writeToLoggedIn);
    
}

function handleLogoutSubmit()
{
    console.log("logout");
    callBackend("logout","",writeToLoginStatus);
     setTimeout(checkForLogin,2000);
}


function callBackend(functionName,functionParams,callback)
{
    const fetchTarget='php/rhIntake_control.php';
    let inputPackage={function:functionName,params:functionParams};
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



intakeInit();