<?php

declare(strict_types=1);

namespace OrbitaDigital\Read;

class Csv extends ReadFiles
{
    private $csv_header = [];

    function __construct(array $csv_header)
    {
        $this->csv_header = $csv_header;
    }
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
     * Check if there's an error in the csv files.
     * @param array $csvFiles array with the files
     * @return bool true if the array dont contains errors, false if there's one
     */
    public function verifyContent(array $csvFiles)
    {
        foreach ($csvFiles as $fileData) {
            if (is_string($fileData)) {
                $this->lastError = $fileData;
                return false;
            }
        }
        return true;
    }
}
