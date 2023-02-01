<?php

require_once "./core/helpers/FormValidator.php";
require_once "./core/helpers/Session.php";
require_once "./core/helpers/Format.php";
require_once "./core/models/Project.php";


class ProjectController
{
    private Project $projectModel;


    public function __construct()
    {
        $this->projectModel = new Project();
    }


    public function getProjectsInProgress(): array
    {
        $projects = $this->projectModel->selectProjectsInProgress();
        return $this->cleanData($projects);
    }


    public function getAllProjects(): array
    {
        $projects =  $this->projectModel->selectAllProjects();
        return  $this->cleanData($projects);
    }


    public function displayDetailsProject(): array
    {
        if (!$this->isGetIdDefined()) {
            header("Location: allProjects.php");
            die;
        }

        $singleProject = $this->getSingleProject($_GET["id"]);

        if (!$singleProject) {
            header("Location: allProjects.php");
            die;
        }

        return $singleProject;
    }


    private function getSingleProject(int $id): array
    {
        $id = (int) $id;
        return $this->projectModel->selectSingleProject($id);
    }


    public function deleteProject(): void
    {
        if (!$this->isGetIdDefined()) {
            header("Location: allProjects.php");
            die;
        }

        $id = (int) $_GET["id"];

        $singleProject = $this->getSingleProject($id);

        if (!$singleProject) {
            header("Location: allProjects.php");
            die;
        }

        if ($this->projectModel->deleteProject($id)) {
            Session::set("message", "Project deleted !");
            header("Location: index.php");
            die;
        }

        Session::set("message", "Error !");
        header("Location: index.php");
        die;
    }


    public function createProject(): bool
    {
        if (!$this->validateFormCreateProject()) {
            return false;
        }

        $dataProject = $this->prepareCreateProjectData();

        if ($this->projectModel->insertProject($dataProject)) {
            Session::set("message", "Project created !");
            header("Location: index.php");
            return true;
        }

        return false;
    }


    public function editProject(int $id): bool
    {
        if (!$this->validateFormEditProject()) {
            return false;
        }

        $dataEditProject = $this->prepareEditData();

        $dataEditProject["id_project"] = $id;

        if ($this->projectModel->updateProject($dataEditProject)) {
            Session::set("message", "Project updated !");
            header("Location: index.php");
            return true;
        }

        return false;
    }


    private function isGetIdDefined(): bool
    {
        return isset($_GET["id"]) && is_numeric($_GET["id"]);
    }


    private function prepareCreateProjectData(): array
    {
        $dataForm = ["name", "description", "created_at", "deadline"];

        $preparedArray = [];

        foreach ($dataForm as $data) {
            $preparedArray[$data] = $_POST[$data];
        }


        return $preparedArray;
    }

    private function prepareEditData(): array
    {
        $preparedArray = $this->prepareCreateProjectData();
        $preparedArray["is_done"] = $_POST["is_done"] ? 1 : 0;

        return $preparedArray;
    }


    private function validateFormEditProject(): bool
    {
        if (!$this->validateDataForm()) {
            return false;
        }

        if (!isset($_POST["id_done"])) {
            if (!$this->checkIfDeadlineDateIsPast()) {
                Session::set("error", "Deadline must be in the past");
                return false;
            }
        }

        return true;
    }


    private function validateFormCreateProject(): bool
    {
        if (!$this->validateDataForm()) {
            return false;
        }

        if (!$this->checkIfDeadlineDateIsPast()) {
            Session::set("error", "Deadline must be in the past");
            return false;
        }

        return true;
    }



    private function validateDataForm(): bool
    {
        $dataForm = ["name", "description", "created_at", "deadline"];

        if (!FormValidator::validatePostData($dataForm)) {
            Session::set("error", "Please filsl all inputs");
            return false;
        }

        if (!$this->validateLengthData()) {
            Session::set("error", "Name and description project must be less than 50 characters");
            return false;
        }

        if (!$this->checkDatesFormat()) {
            Session::set("error", "Date must be in format dd/mm/yyyy");
            return false;
        }

        return true;
    }



    private function validateLengthData(): bool
    {
        $data = ["name", "description"];

        foreach ($data as $value) {
            if (!FormValidator::checkLength($_POST[$value], 50)) {
                return false;
            }
        }

        return true;
    }


    private function checkDatesFormat(): bool
    {
        $data = ["created_at", "deadline"];

        foreach ($data as $date) {
            if (!FormValidator::checkDateFormat($_POST[$date])) {
                return false;
            }
        }

        return true;
    }


    private function checkIfDeadlineDateIsPast(): bool
    {
        $currentDate = strtotime(date('Y-m-d'));
        $deadline = strtotime($_POST['deadline']);

        return $deadline > $currentDate;
    }


    private function cleanData($data): array
    {
        $final = [];

        foreach ($data as $value) {
            $dataCleaned = array();

            foreach ($value as $key => $item) {
                $dataCleaned[$key] = Format::cleanInput($item);
            }

            $final[] = $dataCleaned;
        }

        return $final;
    }
}
