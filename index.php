<?php
    include_once('Includes/functions.php');
    secureAccess();

/* secureAccess();*/
    include_once('Includes/DoneTask.php');
    include_once('Includes/ToDoTask.php');

    if (isset($_GET['action']) AND $_GET['action']=='logout'){
        $_SESSION = array();
        header('Location:index.php');
    }

    if(isset($_POST['title'])){
        $title = $_POST['title'];
        $content = $_POST['content'];
        $importance = $_POST['importance'];
        $endDate = $_POST['endDate'];
        $MyTask = new ToDoTask($title,$content,$endDate,$importance);
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
        <h1 class="white title">ToDoList</h1>
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
        if(isset($_GET['action']) and $_GET['action'] == "create"){
            print'<div class="createTask">';
                print'<form method="post">';
                    print'<input class"free_sans" name="title" placeholder="title"> Date:<input type="date" name="endDate"><br>';
                    print'<input class"free_sans" name="content" placeholder="content"><br>';
                    print'<div class="selectImportance">';
                        print'<input type="radio" name="importance" value="low" checked>Low<br>';
                        print'<input type="radio" name="importance" value="medium">Medium<br>';
                        print'<input type="radio" name="importance" value="high">High<br>';
                    print'</div>';
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
