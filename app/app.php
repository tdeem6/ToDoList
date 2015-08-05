<?php
    require_once __DIR__."/../vendor/autoload.php";
    require_once __DIR__."/../src/Task.php";

    session_start();
    if (empty($_SESSION['list_of_tasks'])) {
        $_SESSION['list_of_tasks'] = array();
    }

    $app = new Silex\Application();

    $app->get("/", function() {

      $output ="";

      foreach (TASK::getALL() as $task) {
        $output = $output . "<p>" . $task->getDescription() . "</p>";
      }

        $output = $output . "</ul>
        <form action='/tasks' method='post'>
            <label for='description'>Task Description</label>
            <input id='description' name='description' type='text'>

            <button type='submit'>Add task</button>
        </form>
      ";

      $app->post("/tasks", function() {
              $task = new Task($_POST['description']);
              $task->save();
              return "
                  <h1>You created a task!</h1>
                  <p>" . $task->getDescription() . "</p>
                  <p><a href='/'>View your list of things to do.</a></p>
              ";
        return $output;


    });

    return $app;
?>
