<?php
include_once('Includes/Task.php');

    class ToDoTask extends Task {
        public static function printToDoTasks(){                                                                                                              
            $tasks = ToDoTask::listToDoTasks();                                                                                                                         
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
                $task = ToDoTask::getToDoTaskFromFile($file);                                                                                                           
                array_push($tasks , $task);                                                                                                                   
            }                                                                                                                                                 
            usort($tasks, 'date_compare');                                                                                                                    
            return $tasks;                                                                                                                                    
        } 


        public function printTask(){
            print'<div class="article '.$this->_importance.'">';
                print'<div class ="checkBox" >';
                    print'<form action="index.php" method="post">';
                    print'<button type="submit" name="done" value="'.$this->getName().'" class="doneButton"><i class="fa fa-square-o fa-2x></i></button>';
                    print'</form>';
                print'</div>';
                print'<div class="taskContent">';
                    print'<div class="taskTitle">';
                        print $this->_title;
                        print ' à faire pour le : ';
                        print $this->_endDate;
                    print'</div>';
                    print'<div class="taskDescription">';
                        print $this->_content;
                    print'</div>';
                print'</div>';
            print'</div>';
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
