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
        if (!file_exists($fileStream)) {
            return "<b>" . $fileStream . "</b> doesn't exist<br/>";
        }
        if (!is_readable($fileStream)) {
            return "<b>" . $fileStream . "</b> couldn't be read<br/>";
        }
        $file = fopen($fileStream, 'r');
        $resultArr = [];
        $headArr = [];
        while (($row = fgetcsv($file, 0, ",")) !== FALSE) {
            if (count($headArr) == 0) {
                $headArr = $row;
            } else {
                array_push($resultArr, array_combine($headArr, $row));
            }
        }
        return $resultArr;
    }
