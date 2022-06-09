<?php

class FormValidator
{

    /**
     * Check the length
     *
     * @param string $name
     * @param string $value
     * @param int $length
     * @return string|bool
     */
    public function checkLength(string $name, string $value, int $length): string|bool
    {
        if (strlen($value) < $length) {
            return "$name must me be longer than $length characters";
        }

        return true;
    }


    /**
     * Validate post data
     *
     * @param array $dataPost
     * @return string|bool
     */
    public function validatePost(array $dataPost): string|bool
    {
        foreach ($dataPost as $data) {

            if (!isset($_POST[$data])) {
                return "Please fill all inputs";
            }

            if (empty($_POST[$data])) {
                return "Please fill all inputs";
            }
        }

        return true;
    }
    

    /**
     * check the date form
     *
     * @param string $name
     * @param string $date
     * @return string|bool
     */
    public function checkDate($name, $date): string|bool
    {
        $date_regex = '/^(19|20)\d\d[\-\/.](0[1-9]|1[012])[\-\/.](0[1-9]|[12][0-9]|3[01])$/';

        if (!preg_match($date_regex, $date)) {
            return $result = "The $name input must be a date with the format dd-mm-yyyy";
        }

        return true;
    }
}
