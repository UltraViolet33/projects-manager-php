<?php

require_once './core/helpers/FormValidator.php';
require_once "./core/connection/Session.php";


class ProjectController
{

    private $validator;

    public function __construct()
    {
        $this->validator = new FormValidator();
    }


    public function createProject(): bool
    {
        if (!$this->validateDataForm()) {
            return false;
        }

        return true;

        // insert with Project class
    }


    private function validateDataForm(): bool
    {
        $dataForm = ["name", "description", "created_at", "deadline"];

        if (!$this->validator->validatePostData($dataForm)) {
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
            if (!$this->validator->checkLength($_POST[$value], 1, 50)) {
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
            if (!$this->validator->checkDateFormat($_POST[$date])) {
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
}
