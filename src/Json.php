<?php

declare(strict_types=1);

namespace OrbitaDigital\Read;

class Json extends ReadFiles
{
    /**
     * Read a json file and returns the array with the data. Ends the script if there's an error with the file
     * @param string $jsonStream json file to be readed
     * @return mixed string with the json encoded.
     */
    public static function readJson(string $jsonStream)
    {
        if (parent::checkFile($jsonStream, 'json')) {
            return file_get_contents($jsonStream);
        } else {
            die(parent::getError());
        }
    }
    /**
     * Writes data to a file
     * @param array $data array containing all the information
     * @param string $prefix optional, add a prefix to the file
     * @return string A message showing the result
     */
    public static function dataToJsonFile(array $data, string $prefix = ''): string
    {
        $csvData = json_encode($data, JSON_PRETTY_PRINT, JSON_FORCE_OBJECT);
        $currentDate = date('d_M_Y'); //day, short month and year 4 digits
        $dir = getcwd() . '/rates_processed'; //takes current script directory
        $file = $dir . '/' . $prefix . '_' . $currentDate . '.json';
        //Verify if directory exist and have write access
        if (!is_dir($dir)) {
            echo 'Directory <b>' . $dir . '</b> not found, creating...';
            if (!mkdir($dir, 0777, true)) {
                return '<br/><b>' . $dir . '</b> cannot be created, verify the permissions';
            }
            echo '<br/>Directory created';
            //If file exist and can be created in the directory, create a new one.
        } else if (!is_file($file)) {
            echo '<br/>File dont exist, creating <b>' . $file . '</b> ...';
            $createdFile = fopen($file, 'w');
            //If file can't be created in the directory (access denied).
            if ($createdFile == false) {
                return '<br/>File couldnt be created on <b>' . $dir . '</b>, exiting';
            }
            fclose($createdFile);
            //If file dont have write permissions
        } else if (!is_writable($file)) {
            return 'Information cant be written on <b>' . $file . '</b>';
        }
        file_put_contents($file, $csvData);
        return '<br/>Data inserted in file: <b>' . $file . '</b>';
    }
    /**
     * Show the data contained in the array
     * @param array $jsonData json information to be shown in the screen
     * @return string $output html string with the information extracted
     */
    public static function showJsonData(array $jsonData)
    {
        $output = '';
        foreach ($jsonData as $key => $value) {
            foreach ($value as $key2 => $value2) {
                $output .= $key . '<br/>';
                $output .= $key2;
                for ($i = 1; $i <= 4; $i++) {
                    $output .= '<br/>' . $value2[$i];
                }
                $output .= '<br/>';
            }
            $output .= '<br/>';
        }
        return $output;
    }
}
