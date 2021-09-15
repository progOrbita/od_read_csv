<?php

declare(strict_types=1);

namespace OrbitaDigital\Read;

class Json extends ReadFiles
{
    /**
     * Read a json file and returns the array with the data. Ends the script if there's an error with the file
     * @param string $jsonStream json file to be readed
     * @return mixed string with the json encoded.
     */
    public function readJson(string $jsonStream)
    {
        if ($this->checkFile($jsonStream, 'json')) {
            $jsonString = file_get_contents($jsonStream);
            if (empty($jsonString)) {
                die('<b>' . $jsonStream . '</b> is empty, check it again');
            }
            return $jsonString;
        } else {
            die($this->getError());
        }
    }
    /**
     * Writes data to a file
     * @param array $data array containing all the information
     * @param string $prefix optional, add a prefix to the file
     * @return string A message showing the result
     */
    public function saveJson(array $data, string $prefix = ''): string
    {
        return $this->dataToFile($data,$prefix);
    }
}
