<?php
$tasksFile = "tasks.txt";

// keep the menu running until the users chooses to exit
// this is a while loop, showing repeated interaction

// Ensure tasks file exists
if (! file_exists($tasksFile)) {
    file_put_contents($tasksFile, ""); // create empty file
}

// Helper function to read tasks from the file
function readTasks($file)
{
    $lines = file($file, FILE_IGNORE_NEW_LINES);
    $tasks = [];
    foreach ($lines as $line) {

        // skip empty lines
        if (trim($line) === "") {
            continue;
        }

        // ensure line contains the separator
        if (! str_contains($line, "||")) {
            continue;
        }

        list($taskText, $timestamp) = explode("||", $line);

        // skip malformed entries
        if (trim($taskText) === "" || trim($timestamp) === "") {
            continue;
        }

        $tasks[] = ['task' => $taskText, 'time' => $timestamp];
    }
    return $tasks;
}

// Helper function to save tasks array back to the file
function saveTasks($file, $tasks)
{
    $lines = [];
    foreach ($tasks as $t) {
        $lines[] = $t['task'] . "||" . $t['time'];
    }
    file_put_contents($file, implode(PHP_EOL, $lines) . PHP_EOL);
}

while (true) {
    echo "\nPHP Task Manager\n";
    echo "1. List tasks\n";
    echo "2. Add task\n";
    echo "3. Delete task\n";
    echo "4. Exit\n";
    echo "Choose an option: ";
    $choice = trim(fgets(STDIN));

    if ($choice == 1) {
        // reads task from the file into an array, just like the web version
        $tasks = readTasks($tasksFile);
        if (count($tasks) == 0) {
            echo "No tasks found.\n";
        } else {
            echo "Tasks:\n";
            // displaying task with a for loop
            for ($i = 0; $i < count($tasks); $i++) {
                echo($i + 1) . ". " . $tasks[$i]['task'] . " (Added: " . $tasks[$i]['time'] . ")\n";
                // loops through the tasks array and prints them 12345....
            }
        }
    } elseif ($choice == 2) {
        echo "Enter new task: ";
        // adding a task
        // reads user input from terminal, appends the new task to tasks.txt with timestamp
        $taskText = trim(fgets(STDIN));
        if ($taskText !== "") {
            $timestamp = date("Y-m-d H:i:s"); // add current date and time
            file_put_contents($tasksFile, $taskText . "||" . $timestamp . PHP_EOL, FILE_APPEND);
            echo "Task added.\n";
        }
    } elseif ($choice == 3) {
        $tasks = readTasks($tasksFile);
        if (count($tasks) == 0) {
            echo "No tasks to delete.\n";
        } else {
            echo "Tasks:\n";
            for ($i = 0; $i < count($tasks); $i++) {
                echo($i + 1) . ". " . $tasks[$i]['task'] . " (Added: " . $tasks[$i]['time'] . ")\n";
            }
            echo "Enter the task number to delete: ";
            $num = (int) trim(fgets(STDIN));
            if ($num >= 1 && $num <= count($tasks)) {
                $deleted = $tasks[$num - 1]['task'];
                                                   //array_splice() is a PHP function that removes a portion of an array (or even replaces it with something else).
                array_splice($tasks, $num - 1, 1); // remove task
                saveTasks($tasksFile, $tasks);
                echo "Deleted task: $deleted\n";
            } else {
                echo "Invalid task number.\n";
            }
        }
    } elseif ($choice == 4) {
        echo "Goodbye!\n";
        break; // exit the while loop
    } else {
        echo "Invalid choice, try again.\n";
    }
}
// run the cli using terminal type this (php cli.php)
