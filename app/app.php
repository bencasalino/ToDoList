<?php
    require_once __DIR__."/../vendor/autoload.php";
    require_once __DIR__."/../src/Task.php";

    /* Start session, checks for task key, creates empty array if it doesn't exist */
    session_start();
    if (empty($_SESSION['list_of_tasks'])) {

        $_SESSION['list_of_tasks'] = array();

    }

    $app = new Silex\Application();

    $app->get("/", function() {

        $output = "";

        $output = $output . "<!DOCTYPE html>
            <html>
            <head>
            <title>To Do List</title>
            <link rel='stylesheet' href='https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css'>
            </head>
            <body>
            <div class='container'>
        ";

        $all_tasks = Task::getAll();

        if (!empty($all_tasks)) {
            $output = $output . "
                <h1> To do list </h1>
                <p>
                    Here are all your tasks:
                </p>
                ";

            /* Loops through and displays array of all $task */
            foreach ($all_tasks as $task) {
                $output = $output . "<p>" . $task->getDescription() . "</p>";
            }

        }

        /* form for inserting description */
        $output = $output . "
            <form action='/tasks' method='post'>
                <label for='description'>Task Description</label>
                <input id='description' name='description' type='text'>

                <button type='submit'>Add task</button>
            </form>

        ";

        $output = $output . "
            </body>
            </html>
        ";




        return $output;
    });

    /* Created new /tasks page that displays our created tasks */

    $app->post("/tasks", function() {
        $task = new Task($_POST['description']);
        $task->save();
        return "<!DOCTYPE html>
            <html>
            <head>
            <title>To Do List</title>
            <link rel='stylesheet' href='https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css'>
            </head>
            <body>
            <h1>You created a task!</h1>
            <p>" . $task->getDescription() . "</p>
            <p><a href='/'>View your list of things to do.</a></p>
            </div>
            </body>
            </html>
        ";
    });

    return $app;




 ?>
