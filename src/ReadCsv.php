<?php

declare (strict_types=1);

namespace OrbitaDigital\Read;

class ReadCsv{
    /**
     * Read a file and returns the array with the data.
     * Open the filestream, r -> read mode only.
     * fgetcsv requires de file, line length to read and separator. Will return false at the end of the file
     * Save all the rows onto the array which is returned
     */
    public static function readCSV(string $fileStream){
        //If file isn't a csv.
        if(!is_readable($fileStream) && preg_match('/.+\.csv/',$fileStream)){
            return false;
        }
        echo $fileStream.' it is a csv file<br/>';
        $file = fopen($fileStream,'r');
        while(($row = fgetcsv($file,0,","))!== FALSE){   
            $arrayCSV[] = $row;
        }
        return $arrayCSV;
    }
    /**
     * Check whetver file exist
     */
    public static function fileExist(string $source){
        return file_exists($source);
    }
    /**
     * Check whetever file can be readed
     */
    public static function fileReadable(string $source){
            return is_readable($source);
    }
}