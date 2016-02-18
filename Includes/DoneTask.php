<?php
include_once('Includes/Task.php');
include_once('Includes/functions.php');

    class DoneTask extends Task
    {   
        public static function taskIsUndone($filename){
            rename ('doneTasks/'.$filename.'.txt' , 'toDoTasks/'.$filename.'.txt');
        }

        public static function removeTask($filename){
            unlink('doneTasks/'.$filename.'.txt');
            header('Location: index.php?tasksToDisplay=done');
        }
        public static function printDoneTasks(){
            $tasks = DoneTask::listDoneTasks();
            foreach($tasks as $task){
                $task->printTask();
            }
        }

        public static function constructDoneTask($title, $content, $endDate, $importance, $id){
            $MyTask = new DoneTask($title, $content, $endDate, $importance);
            $MyTask->setId($id);
            return $MyTask;
        }   

        public static function getDoneTaskFromFile($filename){
            $fileContent = file_get_contents($filename);
            $explodedContent = explode("\n", $fileContent , 2);
            $informations = json_decode($explodedContent[0],true);
            $content = $explodedContent[1];
            $title = $informations["title"];
            $endDate = $informations["endDate"];
            $importance = $informations["importance"];
            $id = $informations["id"];
            return DoneTask::constructDoneTask($title , $content, $endDate, $importance, $id);
        }

        public static function listDoneTasks(){
            $tasks = array();
            foreach(glob('./doneTasks/*.txt') as $file){
                $task = DoneTask::getDoneTaskFromFile($file);
                array_push($tasks , $task);
            }
            usort($tasks, 'date_compare');
            return $tasks;
        }

        public function printTask(){                                                                                                                                                                                               
            print'<div class="article done '.$this->getImportance().'">';                                                                                                                                                               
                print'<div class="taskDescription">';                                                                                                                                                                              
                    print'<div class ="checkBox" >';                                                                                                                                                                               
                        print'<form action="index.php?tasksToDisplay=done" method="post">';                                                                                                                                                            
                            print'<button type="submit" name="undone" value="'.$this->getName().'" class="checkBoxButton"><img src="img/checked_checkbox.png" class="img" height="15" width="15"></button>';                                                                                             
                        print'</form>';                                                                                                                                                                                            
                    print'</div>';                                                                                                                                                                                                 
                    print'<div class="taskTitle">';                                                                                                                                                                                
                        print $this->getTitle();                                                                                                                                                                                   
                    print'</div>';                                                                                                                                                                                                
                    print'<div class="delete">';
                        print'<form action="index.php?tasksToDisplay=done" method="post">';
                            print'<button type="submit" name="delete" value="'.$this->getName().'" class="deleteButton"><img src="img/delete.png" class="img" height="15" width="15"></button>';
                        print'</form>';
                    print'</div>';
                print'</div>';                                                                                                                                                                                                     
                print'<div class="taskContent">';                                                                                                                                                                                  
                    print $this->getContent();                                                                                                                                                                                     
                print'</div>';                                                                                                                                                                                                     
            print'</div>';                                                                                                                                                                                                         
        }           
    }
?>
