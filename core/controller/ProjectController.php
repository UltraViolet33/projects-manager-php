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


    /**
     * projectsInProgress
     *
     * @return array
     */
    public function getProjectsInProgress(): array
    {
        return $this->projectModel->selectProjectsInProgress();
    }


    /**
     * getAllProjects
     *
     * @return array
     */
    public function getAllProjects(): array
    {
        return $this->projectModel->selectAllProjects();
    }



    /**
     * displayDetailsProject
     *
     * @return array
     */
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


    /**
     * getSingleProject
     *
     * @param  int $id
     * @return array
     */
    private function getSingleProject(int $id): array
    {
        $id = (int) $id;
        return $this->projectModel->selectSingleProject($id);
    }


    /**
     * deleteProject
     *
     * @return void
     */
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


    /**
     * isGetIdDefined
     *
     * @return bool
     */
    private function isGetIdDefined(): bool
    {
        return isset($_GET["id"]) && is_numeric($_GET["id"]);
    }


    /**
     * createProject
     *
     * @return bool
     */
    public function createProject(): bool
    {
        if (!$this->validateFormCreateProject()) {
            return false;
        }

        $dataProject = $this->cleanData();

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

    private function prepareEditData(): array
    {
        $dataForm = ["name", "description", "created_at", "deadline"];

        $preparedArray = [];

        foreach ($dataForm as $data) {
            $preparedArray[$data] = $_POST[$data];
        }

        $preparedArray["is_done"] = $_POST["is_done"] ? 1 : 0;

        return $preparedArray;
    }


    /**
     * validateDataForm
     *
     * @return bool
     */
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


    /**
     * validateLengthData
     *
     * @return bool
     */
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


    /**
     * checkDatesFormat
     *
     * @return bool
     */
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


    /**
     * checkIfDeadlineDateIsPast
     *
     * @return bool
     */
    private function checkIfDeadlineDateIsPast(): bool
    {
        $currentDate = strtotime(date('Y-m-d'));
        $deadline = strtotime($_POST['deadline']);

        return $deadline > $currentDate;
    }

    /**
     * cleanData
     *
     * @return array
     */
    private function cleanData(): array
    {
        $dataForm = ["name", "description", "created_at", "deadline"];

        $dataCleaned = array();

        foreach ($dataForm as $data) {
            $dataCleaned[$data] = Format::cleanInput($_POST[$data]);
        }

        return $dataCleaned;
    }
}
