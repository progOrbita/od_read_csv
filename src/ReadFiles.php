<?php

declare(strict_types=1);

namespace OrbitaDigital\Read;

class ReadFiles
{
    private static $lastError = '';
    /**
     * Check if file exist, can be readed and extension is right
     * @param string $file file to be checked
     * @param string $extension extension of the file
     * @return bool true if there's no error. False otherwise
     */
    protected static function checkFile(string $file, string $extension): bool
    {
        if (!file_exists($file)) {
            self::$lastError = "<b>" . $file . "</b> doesn't exist<br/>";
            return false;
        }
        if (!is_readable($file)) {
            self::$lastError = "<b>" . $file . "</b> couldn't be read<br/>";
            return false;
        }
        if (preg_match('/^.+\.' . $extension . '/i', $file) <= 0) {
            self::$lastError = "<b>" . $file . "</b> isn't a " . $extension . " file<br/>";
            return false;
        }
        return true;
    }
    /**
     * Get the information of the error from the checks.
     * @return string string containing the information
     */
    protected function getError(): string
    {
        return self::$lastError;
    }
}
