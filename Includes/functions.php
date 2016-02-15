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
    print'<link rel="stylesheet" type="text/css" href="css/font-awesome/css/font-awesome.min.css">';
    print'<script type="text/javascript" src="js/myscript.js"></script>';
    print'</head>';
    print'</body>';
    }     

function secureAccess(){                                                                                         
    session_start();                                                                                             
    if (!checkaccess()){                                                                                         
        header('location: ./auth.php'); // on redirige vers index.php                                                 
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
    return ($t1 > $t2) ? 1 : -1; 
}    

?>
