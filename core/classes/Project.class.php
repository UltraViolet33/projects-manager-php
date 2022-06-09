<?php

require_once('core/connection/Database.php');

class Project
{
    private $con = null;

    public function __construct()
    {
        $this->con = Database::getInstance();
    }

    private function validatePost(array $dataPost): bool
    {
        foreach ($dataPost as $data) {
            if (!isset($_POST[$data])) {
                return false;
            }

            if (empty($_POST[$data])) {
                return false;
            }
        }

        return true;
    }

    public function getAllProjects()
    {
        $sql = "SELECT * FROM projects ORDER BY created_at DESC";
        return $this->con->read($sql);
    }

    public function insertProject(): string
    {
        $result = "";
        $dataPost = ["name", "description", "deadline"];

        if (!$this->validatePost($dataPost)) {
            $result = "Please, fill all inputs";
        }

        if (strlen($_POST['name']) < 1) {
            $result = "Name must be longer than 1 character";
        }

        if (strlen($_POST['description']) < 1) {
            $result = "Description must be longer than 1 character";
        }

        $date_regex = '/^(19|20)\d\d[\-\/.](0[1-9]|1[012])[\-\/.](0[1-9]|[12][0-9]|3[01])$/';

        if (!preg_match($date_regex, $_POST['deadline'])) {
            $result = "The dealine input must be a date with the format dd-mm-yyyy";
        }

        $deadline = date("Y-m-d", strtotime($_POST['deadline']));

        $values = array(
            "name" => $_POST['name'],
            "description" => $_POST['description'],
            "deadline" => $deadline,
        );

        $sql = "INSERT INTO projects(name, description, deadline) VALUES(:name, :description, :deadline)";

        if ($this->con->write($sql, $values)) {
            Session::set("message", "Your project have bee created");
            header("Location: index.php");
        }

        $result = "An error occured, please try again or go away";
        return $result;
    }

    public function updateProject($id)
    {
        $result = "";
        $dataPost = ["name", "description", "created", "deadline"];

        if (!$this->validatePost($dataPost)) {
            $result = "Please, fill all inputs";
        }

        if (strlen($_POST['name']) < 1) {
            $result = "Name must be longer than 1 character";
        }

        if (strlen($_POST['description']) < 1) {
            $result = "Description must be longer than 1 character";
        }

        $date_regex = '/^(19|20)\d\d[\-\/.](0[1-9]|1[012])[\-\/.](0[1-9]|[12][0-9]|3[01])$/';

        if (!preg_match($date_regex, $_POST['created'])) {
            $result = "The created_at input must be a date with the format dd-mm-yyyy";
        }

        if (!preg_match($date_regex, $_POST['deadline'])) {
            $result = "The dealine input must be a date with the format dd-mm-yyyy";
        }

        $deadline = date("Y-m-d", strtotime($_POST['deadline']));
        $created_at = date("Y-m-d", strtotime($_POST['created']));

        $isDone = 0;
        if (isset($_POST['isDone']) && $_POST['isDone'] == "true") {
            $isDone = 1;
        }

        $values = array(
            "name" => $_POST['name'],
            "description" => $_POST['description'],
            "created_at" => $created_at,
            "deadline" => $deadline,
            "is_done" => $isDone,
        );

        $sql = "UPDATE projects SET name = :name, description = :description, created_at=:created_at, deadline=:deadline, is_done=:is_done";

        if ($this->con->write($sql, $values)) {
            Session::set("message", "Your project have been updated");
            header("Location: details.php?id=$id");
        }

        $result = "An error occured, please try again or go away";
        return $result;
    }

    public function getSingleProject(int $id)
    {
        $sql = "SELECT * FROM projects WHERE id_project = :id_project";
        return $this->con->read($sql, ['id_project' => $id], true);
    }

    public function deleteProject($id)
    {
        $sql = "DELETE FROM projects WHERE id_project = :id_project";
        $result = $this->con->write($sql, ['id_project' => $id]);
    }
}
