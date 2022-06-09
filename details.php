<?php
$title = "Details Projects";
require_once('./inc/header.php');

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header("Location: allProjects.php");
    die;
}

$id = (int) $_GET['id'];
$singleProject = $project->getSingleProject($id);
if (!$singleProject) {
    header("Location: allProjects.php");
    die;
}

$date = date('d/m/y', strtotime($singleProject->created_at));
$deadline = date('d/m/y', strtotime($singleProject->deadline));
?>
<div class="container my-3">
    <div class="row">
        <div class="col-12">
            <h1 class="text-center">Details Project <?= $singleProject->name ?></h1>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <p>Name : <?= $singleProject->name ?> </p>
            <p>Description : <?= $singleProject->description ?> </p>
            <p>Remaining days : <?= $singleProject->remains_days ?> </p>
            <p>Status : <?= $singleProject->is_done ? "Done" : "Not done yet" ?></p>
            <p>Date begining : <?= $singleProject->created_at ?> </p>
            <p>Deadline : <?= $singleProject->deadline ?> </p>
            <a href="./edit.php?id=<?= $singleProject->id_project ?>" class="btn btn-primary">Edit</a>
            <a href="./delete.php?id=<?= $singleProject->id_project ?>" class="btn btn-danger">Delete</a>
        </div>
    </div>
</div>
<?php require_once('./inc/footer.php'); ?>