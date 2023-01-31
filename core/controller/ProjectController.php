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

    public function createProject(): bool
    {
        if (!$this->validateDataForm()) {
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

    private function cleanData(): array
    {
        $dataForm = ["name", "description", "created_at", "deadline"];

        $dataCleaned = array();

        foreach ($dataForm as $data) {
            // array_push($dataCleaned, Format::cleanInput($_POST[$data]));
            $dataCleaned[$data] = Format::cleanInput($_POST[$data]);
        }

        return $dataCleaned;
    }
}
