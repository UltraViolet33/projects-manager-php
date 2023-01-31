<?php

require_once './core/helpers/FormValidator.php';


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

        // insert with Project class
    }


    private function validateDataForm(): bool
    {
        $dataForm = ["name", "description", "created_at", "deadline"];

        if (!$this->validator->validatePostData($dataForm)) {
            // set error msg
            return false;
        }

        if (!$this->validateLengthData()) {
            // set error msg
            return false;
        }

        if (!$this->checkDatesData()) {
            // set error msg
            return false;
        }

        if (!$this->checkIfDeadlineDateIsPast()) {
            // set error msg
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
     * checkDatesData
     *
     * @return bool
     */
    private function checkDatesData(): bool
    {
        $data = ["created_at", "deadline"];

        foreach ($data as $date) {
            if (!$this->validator->checkDateFormat($date)) {
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
