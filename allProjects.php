<?php 
$title = "Projects List";
require_once('./inc/header.php');
$allProjects = $project->getAllProjects();
?>
<div class="container my-3">
    <div class="row">
        <div class="col-12">
            <h1 class="text-center">All Projects</h1>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Name</th>
                        <th scope="col">Start</th>
                        <th scope="col">Dealine</th>
                        <th scope="col">Status</th>
                        <th scope="col">Détails</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($allProjects as $project) : ?>
                        <?php $deadline = date('d/m/y', strtotime($project->deadline));
                        $date = date('d/m/y', strtotime($project->created_at));
                        $status = $project->is_done ? "Done" : "Not done yet";
                        ?>
                        <tr>
                            <th scope="row"><?= $project->id_project ?></th>
                            <td><?= $project->name ?></td>
                            <td><?= $date ?></td>
                            <td><?= $deadline ?></td>
                            <td><?= $status ?></td>
                            <td><a href="./details.php?id=<?= $project->id_project?>" class="btn btn-primary">Détails</a></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?php require_once('./inc/footer.php'); ?>