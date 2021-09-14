<?php

declare(strict_types=1);

namespace OrbitaDigital\Read;

class ReadJson
{
    /**
     * Read a file and returns the array with the data.
     * Open the filestream, r -> read mode only.
     * fgetcsv requires the file, line length to read and separator. Will return false at the end of the file
     * @param string $fileStream file to be readed
     * @return mixed string with the message error or array with the file data
     */
    public static function readJson(string $jsonStream)
    {
        if (!file_exists($jsonStream)) {
            return "<b>" . $jsonStream . "</b> doesn't exist<br/>";
        }
        if (!is_readable($jsonStream)) {
            return "<b>" . $jsonStream . "</b> couldn't be read<br/>";
        }
        if (preg_match('/^.+\.json/i', $jsonStream) <= 0) {
            return "<b>" . $jsonStream . "</b> isn't a .json file<br/>";
        }
        return file_get_contents($jsonStream);
    }
}
