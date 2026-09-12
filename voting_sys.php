<?php

$name = readline("enter name ");
$age = readline("enter age");
$names = ["teer " , "patang " , "lota "];
$length = count($names) -1;
$choice=null; 
if ($age <= 18) {
    echo "you are not eligble for voting";
}
else{
    echo "CHOOSE 1 ", PHP_EOL;;
    // foreach($names as $namq){
    // echo   $namq , PHP_EOL;
    // }
    for ($i=0; $i <= $length ; $i++) { 
       echo  $i, " " ,$names[$i] , PHP_EOL;
    }
    $num = readline("enter any number 0-2");
    $choice +=$num;
    echo "you choose " , $names[$choice] , "thankyou for voting" ;
}












?>