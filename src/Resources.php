<?php

namespace OrbitaDigital\Read;

class Resources{
    /**
     * Write data to a file
     * @param array $data array containing all the information
     * @param string $file Name of the file to be created and inserted the data
     * @param string $dir Optional, folder where to insert the file. Default value is script location
     * @return string A message showing the result
     */
    public static function dataToJsonFile($data,$file,$dir=null){
        $jsonData = json_encode($data,JSON_PRETTY_PRINT);
        if($dir==null){
            //default route when no directory is sent, where script is executed.
            $dir = getcwd();
        }
        if(!is_dir($dir)){
            return 'Directory <b>'.$dir.'</b> not found';
        }
        else if(!is_file($file)){
            echo '<br/>File dont exist, creating '.$file.' ...';
            $createdFile = fopen($file,'w');
            fclose($createdFile);
        }
        else if(!is_writable($file)){
            return 'Information cant be written on '.$file;
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