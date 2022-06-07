<?php

class Project
{
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

    public function insertProject(): string
    {
        $result = "";
        $dataPost = ["name", "description", "deadline"];

        if (!$this->validatePost($dataPost)) {
            $result = "Please, fill all inputs";
        }
        return $result;
    }
}
