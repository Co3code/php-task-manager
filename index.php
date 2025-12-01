<?php
    $tasksFile = "tasks.txt";
    if (! file_exists($tasksFile)) {
        file_put_contents($tasksFile, ""); // create empty file
    }
    // Add a task 
    //check if the user submmited a task throgh a form
    //if the task is not empty, it append it to task.txt
    if (isset($_POST['task'])) {
        $task = trim($_POST['task']);
        if ($task !== "") {
            file_put_contents($tasksFile, $task . PHP_EOL, FILE_APPEND);
        }
    }

    // Read tasks
    //Reads all task into an array $task
    $tasks = file($tasksFile, FILE_IGNORE_NEW_LINES);
?>

<h1>Simple PHP Task Manager</h1>

<form method="post">
    <input type="text" name="task" placeholder="New task">
    <button type="submit">Add Task</button>
</form>

<h2>Tasks:</h2>
<ul>
<?php
    // displaying tasj witg a for lopp 
    for ($i = 0; $i < count($tasks); $i++) {
        echo "<li>" . htmlspecialchars($tasks[$i]) . "</li>";
    } // each task it displayed as a list item 
?>
</ul>
