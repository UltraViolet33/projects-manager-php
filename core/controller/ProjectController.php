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
        $dataForm = ["name", "description","created_at", "deadline"];
        if(!$this->validator->validatePostData($dataForm))
        {
            return false;
        }

        // check if the data are in good format
        // check the dates
    }

    private function validateLengthData(array $data): bool
    {
        if(!$this->validator->checkLength($data["name"], 1, 50))
        {
            return false;
        }

        
        if(!$this->validator->checkLength($data["description"], 1, 50))
        {
            return false;
        }
    }
}