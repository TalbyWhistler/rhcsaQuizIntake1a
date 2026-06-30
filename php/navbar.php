<?php
    //include 'tools.php';
    $knowBeforeOption=createElement("div","knowBeforeOption","navButton","Do I know this already?");
    $reviewQuestionOption=createElement("div","reviewQuizOption","navButton","Chapter Review Quizzes");
   // $reviewQuestionOption=createElement('div','reviewButton','navButton','Chapter Review Questions');
    $exerciseOption=createElement('div','exerciseButton','navButton',"Run Exercises");
    $memoryOption=createElement('div','tableButton','navButton','Memory Table Quizes');
    $welcome=createElement('div','welcomeButton','navButton','Welcome');
    $navRowContents=
    "
     <a href='index.php'>$welcome</a>
      <a href='alreadyIntake.php'>$knowBeforeOption</a>
      <a href='chapters_review.php'>$reviewQuestionOption</a> 
      <a href='exercises.php'>$exerciseOption</a>
      <a href='quiz_in.php'>$memoryOption</a>
    ";
    $navRow=createElement("div","navRow","row",$navRowContents);
    echo $navRow;
?>