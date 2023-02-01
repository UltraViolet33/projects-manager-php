<?php
$title = "Create a Project";
require_once './inc/header.php';
if ($_SERVER['REQUEST_METHOD'] === "POST" && isset($_POST['createProject'])) {
    $projectController->createProject();
}
?>
<div class="container my-3">
    <div class="row">
        <div class="col-12">
            <h1 class="text-center">Create a project</h1>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <form method="POST">
                <div class="mb-3">
                    <label for="name" class="form-label">Name project :</label>
                    <input type="text" class="form-control" name="name" value="<?= isset($_POST['name']) ? htmlspecialChars($_POST['name']) : null ?>">
                </div>
                <div class="mb-3">
                    <label for="description" class="form-label">Description : </label>
                    <div class="form-floating">
                        <textarea style="height:100px;resize:none" class="form-control" name="description"><?= isset($_POST['description']) ? htmlspecialChars($_POST['description']) : null ?></textarea>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="created" class="form-label">Date begining :</label>
                    <input type="date" class="form-control" name="created_at" value="<?= isset($_POST['created_at']) ? htmlspecialChars($_POST['created_at']) : null ?>">
                </div>
                <div class="mb-3">
                    <label for="deadline" class="form-label">Deadline :</label>
                    <input type="date" class="form-control" name="deadline" value="<?= isset($_POST['deadline']) ? htmlspecialChars($_POST['deadline']) : null ?>">
                </div>
                <input type="submit" name="createProject" value="Submit" class="btn btn-primary" />
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
<?php require_once './inc/footer.php'; ?>