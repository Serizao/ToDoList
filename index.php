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
        new ToDoTask($title,$content,$endDate,$importance);
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
    </div>
    <?php
        if(isset($_GET['tasksToDisplay']) and $_GET['tasksToDisplay'] == "done"){
            print'<div class="articles">';
            DoneTask::printDoneTasks();
            print'</div>';
        }
        else{
            print'<div class="articles">';
            ToDoTask::printToDoTasks();
            print'</div>';
        }
    ?>
</div>
<?php
    printFooter();
?>
