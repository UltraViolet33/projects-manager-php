<?php
$title = "Projects List";
require_once "./inc/header.php";
$allProjects = $projectController->getAllProjects();
?>
<div class="container my-3">
    <div class="row">
        <div class="col-12">
            <h1 class="text-center">All Projects</h1>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <?php if ($allProjects) : ?>
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
                        <?php foreach ($allProjects as $project) : ?>
                            <?php
                        
                            $status = $project->is_done ? "Done" : "Not done yet";
                            ?>
                            <tr>
                          
                                <th scope="row"><?= $project->id_project ?></th>
                                <td><?= $project->name ?></td>
                                <td><?= $project->remains_days ?></td>
                                <td><?= $project->created_at ?></td>
                                <td><?= $project->deadline ?></td>
                                <td><?= $project->is_done ? "Done" : "Not done yet"; ?></td>
                                <td><a href="./details.php?id=<?= $project->id_project ?>" class="btn btn-primary">Détails</a></td>
                                </tr>
                            <?php endforeach; ?>
                    </tbody>
                </table>
            <?php else : ?>
                <p class="text-center">You have not any projects</p>
            <?php endif; ?>
        </div>
    </div>
</div>
<?php require_once('./inc/footer.php'); ?>