<?php
    include_once('Includes/functions.php');
    secureAccess();

/* secureAccess();*/
    include_once('Includes/DoneTask.php');
    include_once('Includes/ToDoTask.php');

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

    if(isset($_POST['title'])){
        $title = $_POST['title'];
        $content = $_POST['content'];
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
        <button id="logout" class="sideBarButton white">LOGOUT</button>
        <script>
            var lbtn = document.getElementById('logout');
            lbtn.addEventListener('click', function() {
                document.location.href = 'index.php?action=logout';
            });
        </script>
        <button id="todo" class="sideBarButton white <?php if(!isset($_GET['tasksToDisplay']) || $_GET['tasksToDisplay'] !="done"){ print'selected'; } ?>">TODO</button>
        <script>
            var tdbtn = document.getElementById('todo');
            tdbtn.addEventListener('click', function() {
                document.location.href = 'index.php?tasksToDisplay=todo';
            });
        </script>
        <button id="done" class="sideBarButton white <?php if(isset($_GET['tasksToDisplay']) and $_GET['tasksToDisplay'] =="done"){ print'selected'; } ?>">DONE</button>
        <script>
            var dbtn = document.getElementById('done');
            dbtn.addEventListener('click', function() {
                document.location.href = 'index.php?tasksToDisplay=done';
            });
        </script>
        <button id="create" class="sideBarButton white ">NEW</button>
        <script>
            var nbtn = document.getElementById('create');
            nbtn.addEventListener('click', function() {
                document.location.href = 'index.php?action=create';
            });
        </script>
    </div>
    <div class="articles">
    <?php
        if((isset($_GET['action']) and $_GET['action'] == "create") || isset($taskToEdit)) {
            print'<div class="createTask">';
                print'<form method="post">';
                    print'<input class"free_sans" name="title" placeholder="title" ';
                        if(isset($taskToEdit)) { echo 'value="'.$taskToEdit->getTitle().'"'; }
                    print'> Date:<input type="date" name="endDate" ';
                        if(isset($taskToEdit)) { echo 'value="'.$taskToEdit->getEndDate().'"'; }
                    print'><br>';
                    print'<input class"free_sans" name="content" placeholder="content" ';
                        if(isset($taskToEdit)) { echo 'value="'.$taskToEdit->getContent().'"'; }
                    print'><br>';
                    print'<div class="selectImportance">';
                        print'<input type="radio" name="importance" value="low" checked>Low<br>';
                        print'<input type="radio" name="importance" value="medium">Medium<br>';
                        print'<input type="radio" name="importance" value="high">High<br>';
                    print'</div>';
                    if(isset($taskToEdit)){
                        print'<input type=hidden name="id" value="'.$taskToEdit->getId().'"/>';
                    }
                    print'<input class="input" type="submit" value="Valider">';
                print'</form>';
            print'</div>';
        }
        if(isset($_GET['tasksToDisplay']) and $_GET['tasksToDisplay'] == "done"){
            DoneTask::printDoneTasks();
        }
        else{
            ToDoTask::printToDoTasks();
        }
    ?>
    </div>
</div>
<?php
    printFooter();
?>
