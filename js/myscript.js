var tdbtn = document.getElementById('todo');
tdbtn.addEventListener('click', function() {
	document.location.href = 'index.php?tasksToDisplay=todo';
});

var dbtn = document.getElementById('done');
dbtn.addEventListener('click', function() {
	document.location.href = 'index.php?tasksToDisplay=done';
});
