<?php

require_once "./core/connection/Database.php";

class Project
{
    private ?Database $con = null;
    

    public function __construct()
    {
        $this->con = new Database();
    }


    /**
     * insertProject
     *
     * @param  array $data
     * @return bool
     */
    public function insertProject(array $data): bool
    {
        $query = "INSERT INTO projects(name, description, created_at, deadline) 
        VALUES(:name, :description, :created_at, :deadline)";

        return $this->con->write($query, $data);
    }


    /**
     * selectProjectsInProgress
     *
     * @return array
     */
    public function selectProjectsInProgress(): array
    {
        $query = "SELECT *, DATEDIFF(deadline, NOW()) AS remains_days FROM projects
        WHERE is_done=0 ORDER BY remains_days ASC";

        return $this->con->read($query);
    }


    /**
     * selectAllProjects
     *
     * @return array
     */
    public function selectAllProjects(): array
    {
        $query = "SELECT * FROM projects ORDER BY created_at DESC";
        return $this->con->read($query);
    }



    public function updateProject($id)
    {
        $result = "";
        $dataPost = ["name", "description", "created", "deadline"];

        // Check inputs
        $checkInputs = $this->validator->validatePost($dataPost);
        if (is_string($checkInputs)) return $checkInputs;

        // Check length
        $checkName = $this->validator->checkLength("name", $_POST['name'], 1);
        if (is_string($checkName))  return $checkName;

        $checkDescription = $this->validator->checkLength("Description", $_POST['description'], 1);
        if (is_string($checkDescription)) return $checkDescription;

        $checkDeadline = $this->validator->checkDate("Deadline", $_POST['deadline']);
        if (is_string($checkDeadline)) return $checkDeadline;

        $checkCreated = $this->validator->checkDate("Date begining", $_POST['created']);
        if (is_string($checkCreated)) return $checkCreated;

        // Check if the dealine date is past
        $currentDate = strtotime(date('Y-m-d'));
        $deadline = strtotime($_POST['deadline']);

        if ($deadline < $currentDate)  return $result = "The deadline must not be in the past";

        $deadline = date("Y-m-d", $deadline);
        $created_at = date("Y-m-d", $currentDate);

        // Check the beginning date

        $checkCreatedAt = $this->validator->checkdate("Date begining", $_POST['created']);
        if (is_string($checkCreatedAt)) return $checkCreatedAt;
        $created_at = date("Y-m-d", strtotime($_POST['deadline']));

        $isDone = 0;
        if (isset($_POST['isDone']) && $_POST['isDone'] == "true") {
            $isDone = 1;
        }

        $values = array(
            "id_project" => $id,
            "name" => $_POST['name'],
            "description" => $_POST['description'],
            "created_at" => $created_at,
            "deadline" => $deadline,
            "is_done" => $isDone,
        );

        $sql = "UPDATE projects SET name = :name, description = :description, created_at=:created_at, deadline=:deadline, is_done=:is_done WHERE id_project=:id_project";

        if ($this->con->write($sql, $values)) {
            Session::set("message", "Your project have been updated");
            header("Location: details.php?id=$id");
        }

        $result = "An error occured, please try again or go away";
        return $result;
    }

    public function getSingleProject(int $id)
    {
        $sql = "SELECT *, DATEDIFF(deadline, NOW()) AS remains_days FROM projects WHERE id_project = :id_project";
        return $this->con->read($sql, ['id_project' => $id], true);
    }

    public function deleteProject($id)
    {
        $sql = "DELETE FROM projects WHERE id_project = :id_project";
        $result = $this->con->write($sql, ['id_project' => $id]);
    }
}
