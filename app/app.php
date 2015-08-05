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

        return $app['twig']->render('tasks.html.twig', array('tasks' => Task::getAll()));

    });

    /* Created new /tasks page that displays our created tasks */

    $app->post("/tasks", function() {
        $task = new Task($_POST['description']);
        $task->save();
        return $app['twig']->render('create_task.html.twig');

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
