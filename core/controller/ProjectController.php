<?php

require_once './core/helpers/FormValidator.php';


class ProjectController
{

    private $validator;

    public function __construct()
    {
        $this->validator = new FormValidator();
    }

    public function createProject()
    {
    }


    private function validateDataForm(array $data): bool
    {
        $dataForm = ["name", "description", "created_at", "deadline"];
        if (!$this->validator->validatePostData($dataForm)) {
            return false;
        }

        if (!$this->validateLengthData()) {
            return false;
        }

        if(!$this->checkIfDeadlineDateIsPast())
        {
            return false;
        }

        return true;

        // check if the data are in good format
        // check the dates
    }

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

    private function checkIfDeadlineDateIsPast(): bool
    {
        $currentDate = strtotime(date('Y-m-d'));
        $deadline = strtotime($_POST['deadline']);

        if ($deadline < $currentDate)
        {
            return false;
        }

        return true;
    }
}
