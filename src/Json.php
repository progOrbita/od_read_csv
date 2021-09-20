<?php

declare(strict_types=1);

namespace OrbitaDigital\Read;

use OrbitaDigital\Read\ReadFiles;

class Json extends ReadFiles
{

    /**
     * Read the file and returns an array with the data if no errors are found.
     * @param string $stream file to be readed
     * @return string|bool string with the file information encoded. False if there's an error.
     */
    public function read(string $stream)
    {
        if (!$this->checkFile($stream, 'json')) {
            return false;
        }
        return file_get_contents($stream);
    }
    /**
     * Save the data into a json file.
     * @param array $saveData information to be saved
     * @param string $prefix optional, include a prefix in the file
     * @return bool false if there's an error, true if data was saved
     */
    public function save(array $saveData, string $prefix = ''): bool
    {
        if (empty($saveData)) {
            $this->lastError = 'csv information not found';
            return false;
        }
        return $this->saveJson($saveData, $prefix);
    }
}
