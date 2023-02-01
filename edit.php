<?php

$title = "Edit a Project";
require_once "./inc/header.php";

$singleProject = $projectController->displayDetailsProject();

if ($_SERVER['REQUEST_METHOD'] === "POST" && isset($_POST['editProject'])) {
    //  $updateProject = $project->updateProject($id);
    $projectController->editProject($singleProject["id_project"]);
    // var_dump($_POST);
}

?>
<div class="container my-3">
    <div class="row">
        <div class="col-12">
            <h1 class="text-center">Edit project <?= $singleProject["name"] ?></h1>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <form method="POST">
                <div class="mb-3">
                    <label for="name" class="form-label">Name project :</label>
                    <input type="text" class="form-control" name="name" value="<?= $singleProject["name"] ?>">
                </div>
                <div class="mb-3">
                    <label for="description" class="form-label">Description : </label>
                    <div class="form-floating">
                        <textarea style="height:100px;resize:none" class="form-control" name="description"><?= $singleProject["description"] ?></textarea>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="created_at" class="form-label">Date begining :</label>
                    <input type="date" class="form-control" name="created_at" value="<?= $singleProject["created_at"] ?>">
                </div>
                <div class="mb-3">
                    <label for="deadline" class="form-label">Deadline :</label>
                    <input type="date" class="form-control" name="deadline" value="<?= $singleProject["deadline"] ?>">
                </div>
                <div class="form-check mb-3">
                    <?php if ($singleProject["is_done"]) : ?>
                        <input name="is_done" class="form-check-input" type="checkbox" value="true" id="flexCheckDefault" checked>
                    <?php else : ?>
                        <input name="is_done" class="form-check-input" type="checkbox" value="true" id="flexCheckDefault">
                    <?php endif; ?>
                    <label for="is_done" class="form-check-label" for="flexCheckDefault">
                        Done
                    </label>
                </div>
                <input type="submit" name="editProject" value="Submit" class="btn btn-primary" />
            </form>
            <div class="bg-danger">
                <?php
                echo Session::get("error");
                Session::unsetKey("error");
                ?>
            </div>
        </div>
    </div>
</div>
<?php require_once "./inc/footer.php"; ?>