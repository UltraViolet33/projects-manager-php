<?php require_once('./inc/header.php');

if($_SERVER['REQUEST_METHOD'] === "POST" && isset($_POST['createProject']))
{
    var_dump($_POST);
    $createProject = $project->insertProject();
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
                    <input type="text" class="form-control" name="name">
                </div>
                <div class="mb-3">
                    <label for="description" class="form-label">Description : </label>
                    <div class="form-floating">
                        <textarea style="height:100px;resize:none" class="form-control" name="description"></textarea>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="deadline" class="form-label">Deadline :</label>
                    <input type="date" class="form-control" name="deadline">
                </div>
                <input type="submit" name="createProject" value="Submit" class="btn btn-primary"/>
            </form>
            <div class="bg-danger">
                <?php if(isset($createProject)): ?>
                    <?= $createProject ?>
                    <?php endif; ?>
            </div>
        </div>
    </div>
</div>
<?php require_once('./inc/footer.php'); ?>