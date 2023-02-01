<?php
$title = "Projects in progress";
require_once "./inc/header.php";
$projectsInProgress = $projectController->getProjectsInProgress();
?>
<div class="container my-3">
    <div class="row">
        <div class="col-12">
            <h1 class="text-center">Projects in progress</h1>
            <p><?php echo Session::get("message");
                Session::unsetKey("message");?></p>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <?php if ($projectsInProgress) : ?>
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">ID</th>
                            <th scope="col">Name</th>
                            <th scope="col">Remains Days</th>
                            <th scope="col">Start</th>
                            <th scope="col">Deadline</th>
                            <th scope="col">Status</th>
                            <th scope="col">Détails</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($projectsInProgress as $project) : ?>
                            <?php if ($project["remains_days"] <= 0) : ?>
                                <tr class="bg-danger">
                                <?php elseif ($project["remains_days"] <= 7) : ?>
                                <tr class="bg-warning">
                                <?php else : ?>
                                <tr>
                                <?php endif; ?>
                                <th scope="row"><?= $project["id_project"] ?></th>
                                <td><?= $project["name"] ?></td>
                                <td><?= $project["remains_days"] ?></td>
                                <td><?= $project["created_at"] ?></td>
                                <td><?= $project["deadline"] ?></td>
                                <td><?= $project["is_done"] ? "Done" : "Not done yet"; ?></td>
                                <td><a href="./details.php?id=<?= $project["id_project"] ?>" class="btn btn-primary">Détails</a></td>
                                </tr>
                            <?php endforeach; ?>
                    </tbody>
                </table>
            <?php else : ?>
                <p class="text-center">No project in progress</p>
            <?php endif; ?>
        </div>
    </div>
</div>
<?php require_once "./inc/footer.php"; ?>