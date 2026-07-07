<?php 
        include_once 'tools.php';
        $title=createElement('h1','intakeTitle','title','Red Hat RHCSA 8 Quiz Data Input Page');
        $titleDiv=createElement('div','titleDiv','titleDiv',$title);
        $subTitle=createElement('h3','intakePageSubtitle','subtitle','The linuxLab RHCSA 10 study helper data intake page');
        $scriptLink="<script src='js\intakeScripts.js'></script>";
        $blurb=
        "
            <p>
                This is an educational project dedicated to helping people learn linux, or more specifically to help study for the Red Hat server admin certification.  To use this portion of the site you need to log in.
            </p>
        ";
        
        $userInput=createInput('userNameInput','userInput');
        $passwordInput="<input id='passwordInput' class='userInput' type='password' />";
        $userInputLabel=createElement('label','userNameInputLabel','inputLabel','Username');
        $passwordLabel=createElement('label','passwordInputLabel','inputLabel','Password');
        $submitButton=createButton("loginSubmit","submitButton","handleLoginSubmit","Log In");
        $reactionLabel=createElement("label","loginReactionStatus","statusIndicator","Ready");

        $loggedInLabel=createElement("label","loginStatusLabel","statusIndicatorLabel","You are ");
        $loggedInStatusIndicator=createElement("label","loginStatusIndicator","statusIndicator","");

        $logoutButton=createButton("logoutSubmit","submitButton","handleLogoutSubmit","Log Out");
        $loginPanelContents=
        "
            <label><strong>Login</strong></label>
            </br>
            $userInput$userInputLabel
            </br>
            $passwordInput$passwordLabel
            </br>
            $submitButton
            </br>
            $reactionLabel
            </br>
            $loggedInLabel$loggedInStatusIndicator
            </br>
            $logoutButton
        ";
        $loginPanel=createElement('div','loginPanel','inputPanel',$loginPanelContents);
        $pageContainerContents=
        "
            $subTitle
            $blurb
            $scriptLink
            <p>But first, who are you and where are you going?</p>
            $loginPanel
        ";

        $pageContainer=createElement('div','intakePageContainer','pageContainer',$pageContainerContents);
        echo $pageContainer;
?>