<?php
include_once('Includes/Task.php');
include_once('Includes/functions.php');

    class DoneTask extends Task
    {   
        public static function taskIsUndone($filename){
            rename ('doneTasks/'.$filename.'.txt' , 'toDoTasks/'.$filename.'.txt');
        }

        public static function printDoneTasks(){
            $tasks = DoneTask::listDoneTasks();
            foreach($tasks as $task){
                $task->printTask();
            }
        }

        public static function getDoneTaskFromFile($filename){
            $fileContent = file_get_contents($filename);
            $explodedContent = explode("\n", $fileContent , 2);
            $informations = json_decode($explodedContent[0],true);
            $content = $explodedContent[1];
            $title = $informations["title"];
            $endDate = $informations["endDate"];
            $importance = $informations["importance"];
            return new DoneTask($title , $content, $endDate, $importance);
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
            print'<div class="article '.$this->_importance.'">';
                print'<div class ="checkBox" >';
            print'<form action="index.php?tasksToDisplay=done" method="post">';
                    print'<button type="submit" name="undone" value="'.$this->getName().'" class="doneButton"><i class="fa fa-ckeck-square-o fa-2x"></i></button>';
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

        public function removeTask(){
            unlink('doneTasks/'.$this->getFileName());
            header('Location: index.php?tasksToDisplay=done');
        }
    }
?>
