<?php

declare(strict_types=1);

namespace OrbitaDigital\Read;

class ReadCsv
{
    /**
     * Read a file and returns the array with the data.
     * Open the filestream, r -> read mode only.
     * fgetcsv requires the file, line length to read and separator. Will return false at the end of the file
     * Save the header and the rows onto the array which is returned
     * @param string $fileStream file to be readed
     * @return mixed string with the message error or array with the file data
     */
    public static function readCSV(string $fileStream)
    {
        if (!file_exists($fileStream)) {
            return "<b>" . $fileStream . "</b> doesn't exist<br/>";
        }
        if (!is_readable($fileStream)) {
            return "<b>" . $fileStream . "</b> couldn't be read<br/>";
        }
        if (preg_match('/^.+\.csv/i', $fileStream) <= 0) {
            return "<b>" . $fileStream . "</b> isn't a .csv file<br/>";
        }

        $file = fopen($fileStream, 'r');
        $resultArr = [];
        $headArr = [];
        while (($row = fgetcsv($file, 0, ",")) !== FALSE) {
            if (count($headArr) == 0) {
                if(empty($row[0])){
                    return '<b>Header not found or incorrect</b>';
                }
                $headArr = $row;
            } else {
                //Check whetever the first value is empty
                if(empty($row[0])){
                    continue;
                }
                array_push($resultArr, array_combine($headArr, $row));
            }
        }
        return $resultArr;
    }
}
