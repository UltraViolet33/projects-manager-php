<?php
$title = "Details Projects";

require_once "./inc/header.php";

$singleProject = $projectController->getSingleProject();
var_dump($singleProject);
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
            <p>Status : <?= $singleProject->is_done ? "Done" : "Not done yet" ?></p>
            <p>Date begining : <?= $singleProject->created_at ?> </p>
            <p>Deadline : <?= $singleProject->deadline ?> </p>
            <a href="./edit.php?id=<?= $singleProject->id_project ?>" class="btn btn-primary">Edit</a>
            <a href="./delete.php?id=<?= $singleProject->id_project ?>" class="btn btn-danger">Delete</a>
        </div>
    </div>
</div>
<?php require_once('./inc/footer.php'); ?>