<?php
class Session
{

    /**
     * init
     *
     * @return void
     */
    public static function init(): void
    {
        session_start();
    }


    /**
     * set
     *
     * @param  string $key
     * @param  string $value
     * @return void
     */
    public static function set(string $key, string $value): void
    {
        $_SESSION[$key] = $value;
    }

    /**
     * get
     *
     * @param  string $key
     * @return string|bool
     */
    public static function get(string $key): string|bool
    {
        if (isset($_SESSION[$key])) {
            return $_SESSION[$key];
        }
        return false;
    }


    /**
     * unsetKey
     *
     * @param  string $key
     * @return bool
     */
    public static function unsetKey(string $key): bool
    {
        if (isset($_SESSION[$key])) {
            unset($_SESSION[$key]);
            return true;
        }
        return false;
    }
}
