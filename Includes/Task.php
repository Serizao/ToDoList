<?php

    class Task
    {
        private $_title;
        private $_content;
        private $_endDate;
        private $_importance;
        private $_id;

        public static function printTasks($action){
            $tasks = Task::listTasks($action);                                                                                                                                                                                  
            foreach($tasks as $task){                                                                                                                                                                                              
                $task->printTask();                                                                                                                                                                                                
            }                                                                                                                                                                                                                      
        }

        public static function listTasks($action){
            $tasks = array();
            if($action == "todo"){
                foreach(glob('./toDoTasks/*.txt') as $file){                                                                                                                                                                           
                    $task = ToDoTask::getToDoTaskFromFile($file);                                                                                                                                                                      
                    array_push($tasks , $task);                                                                                                                                                                                        
                }
            }               
            else{
                foreach(glob('./doneTasks/*.txt') as $file){                                                                                                                                                                           
                    $task = DoneTask::getDoneTaskFromFile($file);                                                                                                                                                                      
                    array_push($tasks , $task);                                                                                                                                                                                        
                }
            }
            usort($tasks, 'date_compare');                                                                                                                                                                                         
            return $tasks;                                                                                                                                                                                                         
        }

        public function __construct($title , $content, $endDate ,$importance){
            $this->_id = uniqid();
            $this->_title = $title;
            $this->_content = $content;
            $this->_endDate = $endDate;
            $this->_importance = $importance;
        }
        public function getClass(){
            return __CLASS__;
        }    
        public function getId(){
            return $this->_id;
        }
        public function setId($id){
            $this->_id = $id;
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

        public function getImportance(){
            return $this->_importance;
        }   

        public function getFileName(){
            $filename = $this->getName();
            $filename = $filename.'.txt';
            return $filename;
        }
        public function getName(){
            $filename = $this->getId();                                                                                                                                                                                             
            return $filename;
        } 

    }
?>
