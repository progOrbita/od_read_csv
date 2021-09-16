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
     * if everything is right, save the header and the rows into an array which is returned
     * @param string $file csv to be readed
     * @return string|array string with the message error or array with the file data.
     */
    public function read(string $file)
    {
        if (!$this->checkFile($file, 'csv')) {
            return $this->getlastError();
        }
        $data = [];
        $fileOpen = fopen($file, 'r');
        $header = fgetcsv($fileOpen, 0, ",");

        if (!$this->checkHeader($header)) {
            return 'header of <b>' . $file . '</b> is not fine';
        }

        while (($row = fgetcsv($fileOpen, 0, ",")) !== FALSE) {
            //if the first value after header is empty, skip the row
            if (empty($row[0])) {
                continue;
            }
            array_push($data, array_combine($header, $row));
        }
        return $data;
    }
    /**
     * Check if the header is the expected
     * @param array $header header of the file
     * @return bool false if headers dont match, true otherwise
     */
    private function checkHeader(array $header): bool
    {
        if (empty($this->csv_header)) {
            $this->csv_header = $header;
        }
        if ($header !== $this->csv_header) {
            return false;
        }
        return true;
    }
    /**
     * Read and extract the data from the array of files into an joined array.
     * @param array $filesData array to extract information
     * @return array $joinedData array with the joined information
     */
    public function process(array $filesData): array
    {
        //each id_lang key contains the csv with that language csv
        foreach ($filesData as $id_lang => $lang_csv) {
            foreach ($lang_csv as $csv_values) {
                $joinedData[$csv_values['Id']]['Titulo'][$id_lang] = $csv_values['Titulo'];
                $joinedData[$csv_values['Id']]['Description'][$id_lang] = $csv_values['Description'];
            }
        }
        return $joinedData;
    }
    /**
     * Check if the files array contains an error message.
     * @param array $csvData array with the files
     * @return bool true if the array dont contains messages, false if there's one
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
