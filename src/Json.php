<?php

declare(strict_types=1);

namespace OrbitaDigital\Read;

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
    public function save(array $saveData, string $prefix = ''): string
    {
        return $this->saveJson($saveData, $prefix);
    }
}
