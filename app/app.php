<?php
    require_once __DIR__."/../vendor/autoload.php";
    require_once __DIR__."/../src/Task.php";

    /* Start session, checks for task key, creates empty array if it doesn't exist */
    session_start();

    if (empty($_SESSION['list_of_tasks'])) {
        $_SESSION['list_of_tasks'] = array();

    }

    $app = new Silex\Application();
    $app->register(new Silex\Provider\TwigServiceProvider(), array(
        'twig.path' => __DIR__.'/../views'
    ));

    $app->get("/", function() use ($app) {

        $output = "";

        $output .= "<!DOCTYPE html>
            <html>
            <head>
            <title>To Do List</title>
            <link rel='stylesheet' href='https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css'>
            </head>
            <body>
            <div class='container'>
        ";

        if (!empty(Task::getAll())) {
            $output .= "
                <h1> To do list </h1>
                <p>Here are all your tasks:</p>
            ";

            /* Loops through and displays array of all $task */
            foreach (Task::getAll() as $task) {
                $output .= "<p>" . $task->getDescription() . "</p>";
            }

        }

        /* form for inserting description */
        $output .= "
            <form action='/tasks' method='post'>
                <label for='description'>Task Description</label>
                <input id='description' name='description' type='text'>

                <button type='submit'>Add task</button>
            </form>

        ";


        // will clear delete tasks
        $output .= "
            <form action='/delete_tasks' method='post'>
                <button type ='submit'> delete </button>
            </form>

        ";

        $output .= "
            </div>
            </body>
            </html>
        ";

        return $app['twig']->render('tasks.html.twig');

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
            <div class ='container'>
            <h1>You created a task!</h1>
            <p>" . $task->getDescription() . "</p>
            <p><a href='/'>View your list of things to do.</a></p>
            </div>
            </body>
            </html>
        ";
    });

    $app->post("/delete_tasks", function() {

        Task::deleteAll();

        return "<!DOCTYPE html>
            <html>
            <head>
            <title>To Do List</title>
            <link rel='stylesheet' href='https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css'>
            </head>
            <body>
            <div class ='container'>
            <h1>List Cleared!</h1>
            <p><a href='/'>Home</a></p>
            </div>
            </body>
            </html>
        ";

    });

    return $app;

 ?>
