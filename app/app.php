<?php
    require_once __DIR__."/../vendor/autoload.php";
    require_once __DIR__."/../src/Task.php";

    // Start session, checks for task key
    // Creates empty array if it doesn't exist

    session_start();

    if (empty($_SESSION['list_of_tasks'])) {
        $_SESSION['list_of_tasks'] = array();

    }

    // Direct app to twig.path

    $app = new Silex\Application();
    $app->register(new Silex\Provider\TwigServiceProvider(), array(
        'twig.path' => __DIR__.'/../views'
    ));

    // Root page, prints array if any

    $app->get("/", function() use ($app) {

        return $app['twig']->render('tasks.html.twig', array('tasks' => Task::getAll()));

    });

    // Created new tasks page that displays our created tasks

    $app->post("/tasks", function() use ($app) {
        $task = new Task($_POST['description']);
        $task->save();
        return $app['twig']->render('create_task.html.twig', array('newtask' => $task));

    });

    // Delete contents of array, directs user to delete_tasks page

    $app->post("/delete_tasks", function()  use ($app) {
        Task::deleteAll();
        return $app['twig']->render('delete_tasks.html.twig');

    });

    return $app;

 ?>
