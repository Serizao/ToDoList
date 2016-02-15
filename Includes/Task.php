<?php

    class Task
    {
        private $_title;
        private $_content;
        private $_endDate;
        private $_importance;

        public function __construct($title , $content, $endDate ,$importance){
            $this->_title = $title;
            $this->_content = $content;
            $this->_endDate = $endDate;
            $this->_importance = $importance;
        }

        public static function printToDoTasks(){                                                                                                                                    
            $tasks = listToDoTasks();                                                                                                                                 
            foreach($tasks as $task){                                                                                                                                 
                $task->printTask();                                                                                                                                   
            }                                                                                                                                                         
        }

        public static function taskIsDone($filename){                                                                                                                               
            rename ('toDoTasks/'.$filename.'.txt' , 'doneTasks/'.$filename.'.txt');                                                                                   
        }

        public static function getToDoTaskFromFile($filename){                                                                                                                      
            $fileContent = file_get_contents($filename);                                                                                                              
            $explodedContent = explode("\n", $fileContent , 2);                                                                                                       
            $informations = json_decode($explodedContent[0],true);                                                                                                    
            $content = $explodedContent[1];                                                                                                                           
            $title = $informations["title"];                                                                                                                          
            $endDate = $informations["endDate"];                                                                                                                      
            $importance = $informations["importance"];                                                                                                                
            return new ToDoTask($title , $content, $endDate, $importance);                                                                                            
        }

        public static function listToDoTasks(){                                                                                                                                     
            $tasks = array();                                                                                                                                         
            foreach(glob('./toDoTasks/*.txt') as $file){                                                                                                              
                $task = getToDoTaskFromFile($file);                                                                                                                   
                array_push($tasks , $task);                                                                                                                           
            }                                                                                                                                                         
            usort($tasks, 'date_compare');                                                                                                                            
            return $tasks;                                                                                                                                            
        }

        public function getTitle(){
            return $this->_title;
        }
        public function setTitle($title){
            $this->_title = $title;
        }
        public function getContent(){
            return $this->_content;
        }
        public function setContent($content){
            $this->_content = $content;
        }
        public function getEndDate(){
            return $this->_endDate;
        }
        public function setEndDate($endDate){
            $this->_endDate = $endDate;
        }

        public function getFileName(){
            $filename = $this->getName();
            $filename = $filename.'.txt';
            return $filename;
        }
        public function getName(){
            $filename = $this->_title;                                                                                                                                                                                             
            $filename = strtolower(trim($filename));                                                                                                                                                                               
            $originCharacters = array('à','â','ç','è','é','ê','ë','ï','ô','ù');                                                                                                                                                    
            $destinCharacters = array('a','a','c','e','e','e','e','i','o','u');                                                                                                                                                     
            $filename = str_replace($originCharacters,$destinCharacters,$filename);                                                                                                                                                
            $filename = preg_replace('/[^a-z0-9-]/','-',$filename);
            return $filename;
        } 

    }
?>
