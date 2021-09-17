<?php

declare(strict_types=1);

namespace OrbitaDigital\Read;

use OrbitaDigital\Read\ReadFiles;

class Csv extends ReadFiles
{
    private $csv_header = [];
    /**
     * Constructor
     * @param array $csv_header Header expected in the csv files
     */
    function __construct(array $csv_header)
    {
        $this->csv_header = $csv_header;
    }
    /**
     * Read a file and returns the array with the data.
     * Open the file, r -> read mode only.
     * fgetcsv requires the file, line length to read and separator. Will return false at the end of the file
     * if everything is right, save the header and the rows into an array which is returned if there's no errors
     * @param string $file csv to be readed
     * @return bool|array array with the file data or false if there's an error
     */
    public function read(string $file)
    {
        if (!$this->checkFile($file, 'csv')) {
            return false;
        }
        $data = [];
        $fileOpen = fopen($file, 'r');
        $header = fgetcsv($fileOpen, 0, ",");

        if (!$this->checkHeader($header)) {
            $this->lastError = 'header of <b>' . $file . '</b> is not fine';
            return false;
        }

        while (($row = fgetcsv($fileOpen, 0, ",")) !== false) {
            //if the first value of the row is empty, skip it
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
        return $header === $this->csv_header;
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
}
