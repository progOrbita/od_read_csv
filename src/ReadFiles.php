<?php

declare(strict_types=1);

namespace OrbitaDigital\Read;

class ReadFiles
{
    private $lastError = '';

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
     * Get the information of the error produced
     * @return string string containing the information
     */
    protected function getError(): string
    {
        return $this->lastError;
    }
    
    /**
     * Compare the json file with the array of csv files to find distinct values beetwen both
     * @param array $jsonDecoded json which have right values
     * @param array $csvFiles csv array with the files
     * @return bool|array Array with the errors located beetwen both files. True if no errors were found, false if keys differs.
     */
    public function findErrors(array $jsonDecoded, array $csvFiles)
    {

        $dataError = [];
        foreach ($jsonDecoded as $id => $value) {
            if (array_keys($jsonDecoded[$id]) === array_keys($csvFiles[$id])) {
                for ($id_lang = 1; $id_lang <= 4; $id_lang++) {
                    if ($jsonDecoded[$id]['Titulo'][$id_lang] !== $csvFiles[$id]['Titulo'][$id_lang]) {
                        $dataError[$id]['Titulo'][$id_lang][] = $csvFiles[$id]['Titulo'][$id_lang];
                    }
                    if ($jsonDecoded[$id]['Description'][$id_lang] !== $csvFiles[$id]['Description'][$id_lang]) {
                        $dataError[$id]['Description'][$id_lang] = $csvFiles[$id]['Description'][$id_lang];
                    }
                }
            } else {
                return false;
            }
        }
        return sizeof($dataError) === 0 ? true : $dataError;
    }
}
