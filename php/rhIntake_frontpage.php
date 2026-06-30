<?php 
        include 'tools.php';
        $title=createElement('h1','intakeTitle','title','Red Hat RHCSA 8 Quiz Data Input Page');
        $titleDiv=createElement('div','titleDiv','titleDiv',$title);
        $scriptLink="<script src='js\intakeScripts.js'></script>";
        echo $titleDiv
            .$scriptLink;
?>