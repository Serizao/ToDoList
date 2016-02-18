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
            $id = $informations["id"] ;
            $MyTask = ToDoTask::constructToDoTask($title , $content, $endDate, $importance, $id);
            return $MyTask;
        }
        public static function constructToDoTask($title, $content, $endDate, $importance,$id){
            $MyTask = new ToDoTask($title, $content,$endDate,$importance);
            $MyTask->setId($id);
            return $MyTask;
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
            print'<div class="article '.$this->getImportance().'">';
                print'<div class="taskDescription">';
                    print'<div class ="checkBox" >';
                        print'<form action="index.php" method="post">';
                            print'<button type="submit" name="done" value="'.$this->getName().'" class="checkBoxButton"><img src="img/unchecked_checkbox.png" class="img" height="15" width="15"></button>';    
                        print'</form>';
                    print'</div>';
                    print'<div class="taskTitle">';
                        print $this->getTitle();
                    print'</div>';
                    print'<div class ="edit">';
                        print'<form action="index.php" method="post">';
                            print'<button type="submit" name="edit" value="'.$this->getName().'" class="editButton"><img src="img/edit.png" class="img" height="15" width="15"></button>';
                        print'</form>';
                    print'</div>';
                print'</div>';
                print'<div class="taskContent">';
                    print $this->getContent();
                print'</div>';
            print'</div>';
        }
 
        public function toFile(){
            $fileName = 'toDoTasks/'.$this->getFileName(); 
            $taskInfos = array();
            $taskInfos["endDate"] = $this->getEndDate();
            $taskInfos["title"] = $this->getTitle();
            $taskInfos["importance"] = $this->getImportance();
            $taskInfos["id"] = $this->getId();
            $fileContent = json_encode($taskInfos)."\n";
            $fileContent .= strip_tags($this->getContent())."\n";
            file_put_contents($fileName , $fileContent);
        }
    }
?>
