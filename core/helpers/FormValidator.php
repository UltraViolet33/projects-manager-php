<?php

class FormValidator
{
    
    /**
     * checkLength
     *
     * @param  string $value
     * @param  int $maxLength
     * @return bool
     */
    public static function checkLength(string $value, int $maxLength): bool
    {
        return strlen($value) >= 1 && strlen($value) <= $maxLength;
    }


    /**
     * validatePostData
     *
     * @param  array $dataPost
     * @return bool
     */
    public static function validatePostData(array $dataPost): bool
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
     * checkDateFormat
     *
     * @param string $name
     * @param string $date
     * @return bool
     */
    public static function checkDateFormat(string $date): bool
    {
        $date_regex = '/^(19|20)\d\d[\-\/.](0[1-9]|1[012])[\-\/.](0[1-9]|[12][0-9]|3[01])$/';

        if (!preg_match($date_regex, $date)) {
            return false;
        }

        return true;
    }
}
