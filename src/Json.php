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
                return false;
            }
            return $jsonString;
        } else {
            echo $this->getlastError();
            return false;
        }
    }
}
