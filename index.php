<?php
    session_start();
    include_once('Includes/functions.php'); 
    include_once('Includes/Task.php');
    if(isset($_POST['title'])){
        $title = $_POST['title'];
        $content = $_POST['content'];
        $importance = $_POST['importance'];
        $endDate = $_POST['endDate'];
        new Task($title,$content,$endDate,$importance);
    }
    printHeader();
?>
<div id=conteneur>
    <div class=sidebar>
        <h1 class="white title">ToDoList</h1>
        <button onClick="login()" class="white">LAUGAUNE</button>
        <button id="todo" class="button white">TODO</button>
        <script>
            var tdbtn = document.getElementById('todo'); 
            tdbtn.addEventListener('click', function() { 
                document.location.href = 'index.php?tasksToDisplay=todo';
            }); 
        </script>
        <button id="done" class="button white">DONE</button>
        <script>
            var dbtn = document.getElementById('done'); 
            dbtn.addEventListener('click', function() { 
                document.location.href = 'index.php?tasksToDisplay=done';
            }); 
        </script>
    </div>
    <div class="articles">
            <?php
            if(isset($_GET['tasksToDisplay']) and $_GET['tasksToDisplay'] == "done"){
                printDoneTasks();
            }
            else{
                printToDoTasks();
            }
        ?>
    </div>
</div>
<?php
    printFooter();
?>
