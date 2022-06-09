<?php

require_once('core/connection/Database.php');
require_once('core/helpers/FormValidator.php');


class Project
{
    private $con = null;
    private $validator = null;

    public function __construct()
    {
        $this->con = Database::getInstance();
        $this->validator = new FormValidator();
    }


    /**
     * Check the form and insert in the bdd
     *
     * @return string
     */
    public function insertProject(): string
    {
        $result = "";
        $dataPost = ["name", "description", "deadline"];

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

        // Check if the dealine date is past
        $currentDate = strtotime(date('Y-m-d'));
        $deadline = strtotime($_POST['deadline']);

        if ($deadline < $currentDate)  return $result = "The deadline must not be in the past";

        $deadline = date("Y-m-d", $deadline);
        $created_at = date("Y-m-d", $currentDate);

        // Check the beginning date
        if (strlen($_POST['created']) > 0) {
            $checkCreatedAt = $this->validator->checkdate("Date begining", $_POST['created']);
            if (is_string($checkCreatedAt)) return $checkCreatedAt;
            $created_at = date("Y-m-d", strtotime($_POST['deadline']));
        }

        // Insert in the BDD
        $values = array(
            "name" => $_POST['name'],
            "description" => $_POST['description'],
            "deadline" => $deadline,
            "created_at" => $created_at,
        );

        $sql = "INSERT INTO projects(name, description, created_at, deadline) VALUES(:name, :description, :created_at, :deadline)";

        if ($this->con->write($sql, $values)) {
            Session::set("message", "Your project have been created");
            header("Location: index.php");
        }

        $result = "An error occured, please try again or go away";
        return $result;
    }

    // private function validatePost(array $dataPost): bool
    // {
    //     foreach ($dataPost as $data) {
    //         if (!isset($_POST[$data])) {
    //             return false;
    //         }

    //         if (empty($_POST[$data])) {
    //             return false;
    //         }
    //     }

    //     return true;
    // }

    public function getAllProjects()
    {
        $sql = "SELECT * FROM projects ORDER BY created_at DESC";
        return $this->con->read($sql);
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
        $sql = "SELECT * FROM projects WHERE id_project = :id_project";
        return $this->con->read($sql, ['id_project' => $id], true);
    }

    public function deleteProject($id)
    {
        $sql = "DELETE FROM projects WHERE id_project = :id_project";
        $result = $this->con->write($sql, ['id_project' => $id]);
    }
}
