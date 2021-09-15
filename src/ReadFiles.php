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
     * Writes data to a json file
     * @param array $data array containing all the information
     * @param string $prefix optional, add a prefix to the file
     * @return string A message showing the result
     */
    protected function dataToFile(array $data, string $prefix = ''): string
    {
        $message = '';
        $csvData = json_encode($data, JSON_PRETTY_PRINT, JSON_FORCE_OBJECT);
        $currentDate = date('d_M_Y'); //day, short month and year 4 digits
        $dir = getcwd() . '/rates_processed'; //takes current script directory
        $file = $dir . '/' . $prefix . '_' . $currentDate . '.json';
        //Verify if directory exist and have write access (can nest directories)
        if (!is_dir($dir)) {
            $message .= 'Directory <b>' . $dir . '</b> not found, creating...';
            if (!mkdir($dir, 0777, true)) {
                $this->lastError = '<br/><b>' . $dir . '</b> cannot be created, verify the permissions';
                return $this->getError();
            }
            $message .= '<br/>Directory created';
            //If file exist and can be created in the directory, create a new one.
        } else if (!is_file($file)) {
            $message .= '<br/>File dont exist, creating <b>' . $file . '</b> ...';
            $createdFile = @fopen($file, 'w');
            //If file can't be created in the directory (access denied).
            if ($createdFile == false) {
                $this->lastError = '<br/>File couldnt be created on <b>' . $dir . '</b>, exiting';
                return $this->getError();
            }
            fclose($createdFile);
            //If file dont have write permissions
        } else if (!is_writable($file)) {
            $this->lastError = '<br/>Check your write permissions, information couldnt be written on <b>' . $file . '</b>';
            return $this->getError();
        }
        file_put_contents($file, $csvData);
        $message .= '<br/>data inserted in the file: <b>' . $file . '</b>';
        return $message;
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
