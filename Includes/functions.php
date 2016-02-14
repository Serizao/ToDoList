<?php

function printFooter(){                                                                                          
    print '</body>';
    print '</html>';                                                                                      
}                                                                                                            

function printHeader(){                               
    print'<!DOCTYPE html>';                                                                                                              
    print'<html>';
    print'<head>';
    print'<title>ToDoList</title>';
    print'<meta name="viewport" content="width=device-width, initial-scale=1.0">';
    print'<link rel="stylesheet" type="text/css" href="css/main.css">';
    print'<script type="text/javascript" src="js/myscript.js"></script>';
    print'</head>';
    print'</body>';
    }     

function secureAccess(){                                                                                         
    session_start();                                                                                             
    if (!checkaccess()){                                                                                         
        header('location: ./index.php'); // on redirige vers index.php                                                 
    exit;                                                                                                        
    }                                                                                                            
}                                                                                                            

function checkAccess(){                                                                                          
    return ($_SESSION['username']=='admin');                                                                     
}      

function date_compare($a, $b){
    $t1 = strtotime($a->getEndDate());
    $t2 = strtotime($b->getEndDate());
    if($t1=$t2) return 0;
    return ($t1 > t2) ? 1 : -1; 
}    

function printDoneTasks(){
    $tasks = listDoneTasks();
    foreach($tasks as $task){
        $task->printTask();
    }
}

function printToDoTasks(){
    $tasks = listToDoTasks();
    foreach($tasks as $task){
        $task->printTask();
    }
}

function getTaskFromFile($filename){
    $fileContent = file_get_contents($filename);
    $explodedContent = explode("\n", $fileContent , 2);
    $informations = json_decode($explodedContent[0],true);
    $content = $explodedContent[1];
    $title = $informations["title"];
    $endDate = $informations["endDate"];
    $importance = $informations["importance"];
    return new Task($title , $content, $endDate, $importance);
}    

function listDoneTasks(){
    $tasks = array();
    foreach(glob('./doneTasks/*.txt') as $file){
        $task = getTaskFromFile($file);
        array_push($tasks , $task);
    }
    usort($tasks, 'date_compare');  
    return $tasks;
}

function listToDoTasks(){
    $tasks = array();
    foreach(glob('./toDoTasks/*.txt') as $file){
        $task = getTaskFromFile($file);
        array_push($tasks , $task);
    }
    usort($tasks, 'date_compare');  
    return $tasks;
}

?>
