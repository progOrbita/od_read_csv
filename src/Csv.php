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
    public function read(string $csvFile)
    {
        if ($this->checkFile($csvFile, 'csv')) {
            $file = fopen($csvFile, 'r');
            $resultArr = [];
            $headArr = [];
            if (filesize($csvFile) === 0) {
                return '<b>' . $csvFile . ' file is empty</b>, verify the content again';
            }
            while (($row = fgetcsv($file, 0, ",")) !== FALSE) {
                if (count($headArr) == 0) {
                    if (empty($row[0])) {
                        return '<b>Error reading the header of ' . $csvFile . ', exiting</b>';
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
            die($this->getError());
        }
    }
    /**
     * Read and extract the data from an array of csv files into an joined array. Exit if a file is empty
     * @param array $csvData csv array to extract information
     * @return array $data array with the joined csv information
     */
    public function process(array $csvData): array
    {
        //each id_lang key contains the csv with that language csv
        $this->verifyContent($csvData);
        foreach ($csvData as $id_lang => $lang_csv) {
            foreach ($lang_csv as $csv_values) {
                $data[$csv_values['Id']]['Titulo'][$id_lang] = $csv_values['Titulo'];
                $data[$csv_values['Id']]['Description'][$id_lang] = $csv_values['Description'];
            }
        }
        return $data;
    }
    /**
     * Check if the csv files have content, exiting if an error was found.
     * @param array $csvData array with the csv information
     * @return bool if content is right, ends process if there's an error.
     */
    private function verifyContent(array $csvData): bool
    {
        foreach ($csvData as $lang_csv) {
            if (is_string($lang_csv)) {
                die($lang_csv);
            }
        }
        return true;
    }
}
