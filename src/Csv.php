<?php

declare(strict_types=1);

namespace OrbitaDigital\Read;

class Csv extends ReadFiles
{
    private $csv_header = [];
    /**
     * Read a file and returns the array with the data.
     * Open the file, r -> read mode only.
     * fgetcsv requires the file, line length to read and separator. Will return false at the end of the file
     * Save the header and the rows onto the array which is returned
     * @param string $file csv to be readed
     * @return string|array string with the message error or array with the file data.
     */
    public function read(string $file)
    {
        if ($this->checkFile($file, 'csv')) {
            $fileOpen = fopen($file, 'r');
            $data = [];
            $header = [];

            if (filesize($file) === 0) {
                return '<b>' . $file . ' file is empty</b>, verify the content again';
            }
            while (($row = fgetcsv($fileOpen, 0, ",")) !== FALSE) {
                if (count($header) == 0) {
                    $header = $row;
                    if (count($this->csv_header) == 0) {
                        $this->csv_header = $row;
                    }
                    if (!$this->checkHeader($row)) {
                        return 'Header of <b>'.$file.'</b> is wrong';
                    }
                } else {
                    //if the first value after header is empty, skip the row
                    if (empty($row[0])) {
                        continue;
                    }
                    array_push($data, array_combine($header, $row));
                }
            }
            return $data;
        } else {
            return $this->getlastError();
        }
    }
    /**
     * Check if the csv header is the expected
     * @param array $header header of the csv file (first row from read)
     * @return bool false if dont match, true otherwise
     */
    private function checkHeader(array $header): bool
    {
        if ($header !== $this->csv_header) {
            return false;
        }
        return true;
    }
    /**
     * Read and extract the data from an array of csv files into an joined array.
     * @param array $csvData csv array to extract information
     * @return array $data array with the joined csv information
     */
    public function process(array $csvData): array
    {
        //each id_lang key contains the csv with that language csv
        foreach ($csvData as $id_lang => $lang_csv) {
            foreach ($lang_csv as $csv_values) {
                $data[$csv_values['Id']]['Titulo'][$id_lang] = $csv_values['Titulo'];
                $data[$csv_values['Id']]['Description'][$id_lang] = $csv_values['Description'];
            }
        }
        return $data;
    }
    /**
     * Check if the csv files array contains an error message.
     * @param array $csvData array with the csv information
     * @return bool true if content dont contains messages, false if contains one
     */
    public function verifyContent(array $csvData): bool
    {
        foreach ($csvData as $lang_csv) {
            if (is_string($lang_csv)) {
                echo $lang_csv;
                return false;
            }
        }
        return true;
    }
}
