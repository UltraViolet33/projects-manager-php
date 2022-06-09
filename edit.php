<?php 
$title = "Edit a Project";
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

if ($_SERVER['REQUEST_METHOD'] === "POST" && isset($_POST['editProject'])) {
    $updateProject = $project->updateProject($id);
}

?>
<div class="container my-3">
    <div class="row">
        <div class="col-12">
            <h1 class="text-center">Edit project name</h1>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <form method="POST">
                <div class="mb-3">
                    <label for="name" class="form-label">Name project :</label>
                    <input type="text" class="form-control" name="name" value="<?= $singleProject->name ?>">
                </div>
                <div class="mb-3">
                    <label for="description" class="form-label">Description : </label>
                    <div class="form-floating">
                        <textarea style="height:100px;resize:none" class="form-control" name="description"><?= $singleProject->description ?></textarea>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="created" class="form-label">Date begining :</label>
                    <input type="date" class="form-control" name="created" value="<?= $singleProject->created_at ?>">
                </div>
                <div class="mb-3">
                    <label for="deadline" class="form-label">Deadline :</label>
                    <input type="date" class="form-control" name="deadline" value="<?= $singleProject->deadline ?>">
                </div>
                <div class="form-check mb-3">
                    <?php if ($singleProject->is_done) : ?>
                        <input name="isDone" class="form-check-input" type="checkbox" value="true" id="flexCheckDefault" checked>
                    <?php else : ?>
                        <input name="isDone" class="form-check-input" type="checkbox" value="true" id="flexCheckDefault">
                    <?php endif; ?>
                    <label for="isDone" class="form-check-label" for="flexCheckDefault">
                        Done
                    </label>
                </div>
                <input type="submit" name="editProject" value="Submit" class="btn btn-primary" />
            </form>
            <div class="bg-danger">
                <?php if (isset($updateProject)) : ?>
                    <?= $updateProject ?>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
<?php require_once('./inc/footer.php'); ?>