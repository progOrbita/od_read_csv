<?php

declare(strict_types=1);

namespace OrbitaDigital\Read;

class Save
{
    /**
     * Writes data to a json file
     * @param array $data array containing all the information
     * @param string $prefix optional, add a prefix to the file
     * @return string A message showing the result
     */
    public function saveJson(array $data, string $prefix = ''): string
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
                $message .= '<br/><b>' . $dir . '</b> cannot be created, verify the permissions';
                return $message;
            }
            $message .= '<br/>Directory created';
        }
        if (!is_writable($file)) {
            $message .= '<br/>Check your write permissions, information couldnt be written on <b>' . $file . '</b>';
            return $message;
        }
        if (!is_file($file)) {
            $message .= '<br/>File dont exist, creating <b>' . $file . '</b> ...';
            $createdFile = @fopen($file, 'w');
            //If file can't be created in the directory (access denied).
            if ($createdFile === false) {
                $message .= '<br/>File couldnt be created on <b>' . $dir . '</b>, exiting';
                return $message;
            }
            fclose($createdFile);
        }
        file_put_contents($file, $csvData);
        $message .= '<br/>data inserted in the file: <b>' . $file . '</b>';
        return $message;
    }
}