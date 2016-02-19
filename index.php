<?php
    include_once('Includes/functions.php');
    include_once('Includes/DoneTask.php');
    include_once('Includes/ToDoTask.php');
    secureAccess();

    if(isset($_GET['action']) AND $_GET['action']=='logout'){
        $_SESSION = array();
        header('Location:index.php');
    }
    
    if(isset($_POST['edit'])){
        $taskToEdit = ToDoTask::getToDoTaskFromFile('toDoTasks/'.$_POST['edit'].'.txt');
    }

    if(isset($_POST['delete'])){
        DoneTask::removeTask($_POST['delete']);
    }

    if(isset($_POST['title']) and isset($_POST['content']) and isset($_POST['endDate']) and isset($_POST['importance'])){
        $title = $_POST['title'];
        $content = nl2br($_POST['content']);
        $importance = $_POST['importance'];
        $endDate = $_POST['endDate'];
        if(isset($_POST['id'])){
            $MyTask = ToDoTask::constructToDoTask($title,$content,$endDate,$importance,$_POST['id']);
        }
        else {
            $MyTask = new ToDoTask($title,$content,$endDate,$importance);
        }
        $MyTask->toFile();
        header('Location: index.php');
    }

    if(isset($_POST['done'])){
        ToDoTask::taskIsDone($_POST['done']);
    }

    if(isset($_POST['undone'])){
        DoneTask::taskIsUndone($_POST['undone']);
    }

    printHeader();
?>
<div id=conteneur>
    <div class=sidebar>
        <h1 class="white title">TouDoList</h1>
        <form method=GET>
            <input type="hidden" name="action" value="logout">
            <input type="submit" class="sideBarButton white" value="LOGOUT">
        </form>
        <form method=GET>
            <input type="hidden" name="tasksToDisplay" value="todo">
            <input type="submit" class="sideBarButton white <?php if(!isset($_GET['tasksToDisplay']) || $_GET['tasksToDisplay'] !="done"){ print'selected';} ?>" value="TODO">
        </form>
        <form method=GET>
            <input type="hidden" name="tasksToDisplay" value="done">
            <input type="submit" class="sideBarButton white <?php if(isset($_GET['tasksToDisplay']) and $_GET['tasksToDisplay'] =="done"){ print'selected';} ?>" value="DONE">
        </form>
        <form method=GET>
            <input type="hidden" name="action" value="create">
            <input type="submit" class="sideBarButton white" value="NEW">
        </form>
    </div>
    <div class="articles">
    <?php
        if((isset($_GET['action']) and $_GET['action'] == "create") || isset($taskToEdit)) {
            print'<div class="createTask">';
                print'<form method="post">';
                    print'<input type="text" class"free_sans" name="title" placeholder="title" ';
                        if(isset($taskToEdit)){ 
                            echo 'value="'.$taskToEdit->getTitle().'"'; 
                        }
                        print '><br>'; 
                    print'<input type="date" name="endDate" placeholder="end date"';
                        if(isset($taskToEdit)){ 
                            echo 'value="'.$taskToEdit->getEndDate().'"'; 
                        }
                    print '>';  
                    print'<select id="importance" name="importance">';
                        print'<option value="low" checked >Low<option>';
                        print'<option value="medium" >Medium<option>';
                        print'<option value="high" >High</option>';
                    print'Content :';
                    print'<textarea type="text" id="content" class"free_sans" name="content" rows="5" cols="60">';
                        if(isset($taskToEdit)){ 
                            echo $taskToEdit->getContent(); 
                        }
                    print'</textarea><br>';
                    if(isset($taskToEdit)){
                        print'<input type=hidden name="id" value="'.$taskToEdit->getId().'"/>';
                    }
                    print'<input class="input" type="submit" value="Valider">';
                print'</form>';
            print'</div>';
        }
        if(isset($_GET['tasksToDisplay']) and $_GET['tasksToDisplay'] == "done"){
            Task::printTasks("done");
        }
        else{
            Task::printTasks("todo");
        }
    ?>
    </div>
</div>
<?php
    printFooter();
?>
