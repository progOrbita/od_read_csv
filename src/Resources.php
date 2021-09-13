<?php

namespace OrbitaDigital\Read;

class Resources{
    /**
     * Write data to a file
     * @param array $data array containing all the information
     * @param string $file Name of the file to be created and inserted the data
     * @param string $dir Optional, folder where to insert the file
     * @return string A message showing the result
     */
    public static function dataToJsonFile($data,$file,$dir=null){
        $jsonData = json_encode($data,JSON_PRETTY_PRINT);
        $date = date('d_F_Y_H_i_s'); //day, month in letters, year 4 digits, 24hour_mins_seconds
        if($dir==null){
            //default route when no directory is sent, where script is executed.
            $dir = getcwd();
        }
        $file = $dir.'/data_'.$date.'.json';
        if(!is_dir($dir)){
            return 'Directory not found';
        }
        else if(!is_file($file)){
            echo '<br/>File dont exist, creating '.$file.' ...';
            $createdFile = fopen($file,'w');
            fclose($createdFile);
        }
        else if(!is_writable($file)){
            return 'Information cant be written';
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