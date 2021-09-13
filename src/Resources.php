<?php

namespace OrbitaDigital\Read;

class Resources
{
    /**
     * Write data to a file
     * @param array $data array containing all the information
     * @param string $file Name of the file to be created and inserted the data
     * @param string $dir Optional, folder where to insert the file. Default value is script location
     * @return string A message showing the result
     */
    public static function dataToJsonFile($data)
    {
        $jsonData = json_encode($data, JSON_PRETTY_PRINT);
        $currentDate = date('d_M_Y_H_i_s'); //day, short month, year 4 digits, 24hour_mins_seconds
        $dir = _PS_CORE_DIR_ . '/practicas/od_read_csv/rates_processed';
        $file = $dir . '/data_' . $currentDate . '.json';
        //Verify if directory exist and have write access
        if (!is_dir($dir)) {
            echo 'Directory <b>'.$dir.'</b> not found, creating...';
            if (!mkdir($dir)) {
                echo '<br/><b>' . $dir . '</b> cannot be created, verify the permissions';
                return;
            }
            echo '<br/>Directory created';
            //If file exist and can be created in the directory, create a new one.
        } else if (!is_file($file)) {
            echo '<br/>File dont exist, creating <b>' . $file . '</b> ...';
            $createdFile = fopen($file, 'w');
            //If file can't be created in the directory (access denied).
            if ($createdFile == false) {
                echo '<br/>File couldnt be created on <b>' . $dir . '</b>, exiting';
                return;
            }
            fclose($createdFile);
            //If file dont have write permissions
        } else if (!is_writable($file)) {
            return 'Information cant be written on <b>'.$file.'</b>';
        }
        file_put_contents($file, $jsonData);
        return '<br/>Data inserted in file: <b>' . $file.'</b>';
    }
        }
        file_put_contents($file,$jsonData);
        return "<br/>Data inserted in file: ".$file;
    }
    /**
     * Checks if the content of the data is right
     * @param array $dataArray array to verify the content
     */
    public static function checkData(array $dataArray){
        $false = 0;
        foreach ($dataArray as $value) {
            if(gettype($value) == 'string' ){
                echo $value;
                $false = 1;
            }
        }
        if($false == 1){
            return false;
        }
        return true;
    }
}


?>