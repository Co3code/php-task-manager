<?php
$tasksFile = "tasks.txt";
// keep the menu running until the users chooses to exit
//this is a while loop, showing repeated interaction
while (true) {
    echo "\nPHP Task Manager\n";
    echo "1. List tasks\n";
    echo "2. Add task\n";
    echo "3. Exit\n";
    echo "Choose an option: ";
    $choice = trim(fgets(STDIN));

    if ($choice == 1) {
        //reads task form the file into an arry, just like the web version
        $tasks = file($tasksFile, FILE_IGNORE_NEW_LINES);
        if (count($tasks) == 0) {
            echo "No tasks found.\n";
        } else {
            echo "Tasks:\n";

            //displaying task with a for loop
            for ($i = 0; $i < count($tasks); $i++) {
                echo($i + 1) . ". " . $tasks[$i] . "\n";
                //loops through the tasks array  and prints them 12345....
            }
        }
    } elseif ($choice == 2) {
        echo "Enter new task: ";
        //adding a task 
        //reads user input from terminal appends the new task to task.txt
        $task = trim(fgets(STDIN));
        if ($task !== "") {
            file_put_contents($tasksFile, $task . PHP_EOL, FILE_APPEND);
            echo "Task added.\n";
        }
    } elseif ($choice == 3) {
        echo "Goodbye!\n";
        break; // exit the while loop
    } else {
        echo "Invalid choice, try again.\n";
    }
}
// run the cli using terminal type this (php cli.php)
