<?php

    class Task
    {
        private $_creationDate;
        private $_title;
        private $_content;
        private $_endDate;
        private $_importance;

        public function __construct($title , $content, $endDate ,$importance){
            $this->_creationDate = date("d/m/Y");
            $this->_title = $title;
            $this->_content = $content;
            $this->_endDate = $endDate;
            $this->_importance = $importance;
        }
            
        public function getCreationDate(){
            return $this->_creationDate;
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

        public function printTask(){
            print'<div class="article">';
            print'<div class="̈́'.$this->_importance.'">';
                print $this->_title;
                print ' à faire pour le : ';
                print $this->_endDate;
                print'</div>';
                print'<div class="taskContent">';
                print $this->_content;
                print'</div>';
            print'</div>';
        }

        public function getFileName(){
            $filename = $this->_title;
            $filename = strtolower(trim($filename));
            $originCharacters = array('à','â','ç','è','é','ê','ë','ï','ô','ù');                                          
            $destinCharacters = array('a','a','c','e','e','e','e','i','o','u');
            $filename = str_replace($originCharacters,$destinCharacters,$filename);
            $filename = preg_replace('/[^a-z0-9-]/','-',$filename); 
            $filename = $filename.'.txt';
            return $filename;
        }

        public function taskIsDone(){
            $filename = $this->getFileName();
            rename ('toDoTasks/'.$filename , 'doneTasks/'.$filename);
        } 

        public function toFile(){
            $fileName = 'toDoTasks/'.$this->getFileName(); 
            $taskInfos = array();
            $taskInfos["creationDate"] = $this->_creationDate;
            $taskInfos["endDate"] = $this->_endDate;
            $taskInfos["title"] = $this->_title;
            $taskInfos["importance"] = $this->_importance;
            $fileContent = json_encode($taskInfos)."\n";
            $fileContent .= strip_tags($this->_content)."\n";
            file_put_contents($fileName , $fileContent);
        }
    }
?>
