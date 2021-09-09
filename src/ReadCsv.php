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
        $file = fopen($fileStream,'r');
        while(($row = fgetcsv($file,0,","))!== FALSE){   
            $arrayCSV[] = $row;
        }
        return $arrayCSV;
    }
}