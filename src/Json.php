<?php

declare(strict_types=1);

namespace OrbitaDigital\Read;

class Json extends ReadFiles
{

    /**
     * Read a json file and returns the array with the data if no errors are found.
     * @param string $jsonStream json file to be readed
     * @return string|bool string with the json encoded. False if there's an error.
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
