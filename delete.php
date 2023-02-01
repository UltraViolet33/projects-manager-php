<?php

require_once "./inc/header.php";

$projectController->deleteProject();


// if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
//     header("Location: allProjects.php");
//     die;
// }

// $id = (int) $_GET['id'];

// $project = new Project();
// $project->deleteProject($id);

// Session::init();
// Session::set("message", "The project has been deleted");
// header("Location: index.php");
// die;
