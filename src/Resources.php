<?php

namespace OrbitaDigital\Read;

class Resources{

    public static function processCsv(string $fileName){
        $processFile = ReadCsv::readCSV($fileName);
        if(gettype($processFile) == 'string'){
            echo $processFile;
        }
        else{
            echo $fileName.' is a csv file<br/>';
            return $processFile;
        }
    }
}


?>