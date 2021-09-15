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
    protected function checkFile(string $file, string $extension): bool
    {
        if (!file_exists($file)) {
            $this->lastError = "<b>" . $file . "</b> doesn't exist<br/>";
            return false;
        }
        if (!is_readable($file)) {
            $this->lastError = "<b>" . $file . "</b> couldn't be read<br/>";
            return false;
        }
        if (preg_match('/^.+\.' . $extension . '/i', $file) <= 0) {
            $this->lastError = "<b>" . $file . "</b> isn't a " . $extension . " file<br/>";
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
    /**
     * Compare two arrays to find distinct values beetwen both
     * @param array $rightArray json which is fine
     * @param array $arrayToCompare csv array which may contains errors and will return them if the value is different
     * @return bool|array $errorArrays with the errors located beetwen both files. False if keys differs.
     */
    public static function findErrors(array $rightArray, array $arrayToCompare)
    {

        $dataError = [];
        foreach ($rightArray as $id => $value) {
            if (array_keys($rightArray[$id]) === array_keys($arrayToCompare[$id])) {
                for ($id_lang = 1; $id_lang <= 4; $id_lang++) {
                    if ($rightArray[$id]['Titulo'][$id_lang] !== $arrayToCompare[$id]['Titulo'][$id_lang]) {
                        $dataError[$id]['Titulo'][$id_lang][] = $arrayToCompare[$id]['Titulo'][$id_lang];
                    }
                    if ($rightArray[$id]['Description'][$id_lang] !== $arrayToCompare[$id]['Description'][$id_lang]) {
                        $dataError[$id]['Description'][$id_lang] = $arrayToCompare[$id]['Description'][$id_lang];
                    }
                }
            } else {
                return false;
            }
        }
        return $dataError;
    }
}
