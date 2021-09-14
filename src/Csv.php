<?php

declare(strict_types=1);

namespace OrbitaDigital\Read;

class Csv extends ReadFiles
{
    /**
     * Read a file and returns the array with the data.
     * Open the file, r -> read mode only.
     * fgetcsv requires the file, line length to read and separator. Will return false at the end of the file
     * Save the header and the rows onto the array which is returned
     * @param string $csvFile file to be readed
     * @return mixed string with the message error or array with the file data. Exit if file cant be readed by any means.
     */
    public static function readCSV(string $csvFile)
    {
        if (parent::checkFile($csvFile, 'csv')) {
            $file = fopen($csvFile, 'r');
            $resultArr = [];
            $headArr = [];
            while (($row = fgetcsv($file, 0, ",")) !== FALSE) {
                if (count($headArr) == 0) {
                    if (empty($row[0])) {
                        return '<b>Header not found or incorrect</b>';
                    }
                    $headArr = $row;
                } else {
                    //Check whetever the first value is empty
                    if (empty($row[0])) {
                        continue;
                    }
                    array_push($resultArr, array_combine($headArr, $row));
                }
            }
            return $resultArr;
        } else {
            die(parent::getError());
        }
    }
}
