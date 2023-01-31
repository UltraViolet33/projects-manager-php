<?php

class FormValidator
{

    
    /**
     * checkLength
     *
     * @param  string $value
     * @param  int $minLength
     * @param  int $maxLength
     * @return bool
     */
    public function checkLength(string $value, int $minLength, int $maxLength): bool
    {
        return strlen($value) >= $minLength && strlen($value) <= $maxLength;
    }


    /**
     * Validate post data
     *
     * @param array $dataPost
     * @return string|bool
     */
    public function validatePostData(array $dataPost): bool
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
