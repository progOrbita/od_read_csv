<?php

declare(strict_types=1);

namespace OrbitaDigital\Read;

class Json extends ReadFiles
{
    /**
     * Read a json file and returns the array with the data.
     * @param string $jsonStream json file to be readed
     * @return mixed string with the json encoded or ends script
     */
    public function readJson(string $jsonStream): string
    {
        if(parent::checkFile($jsonStream,'json')){
            return file_get_contents($jsonStream);
        }
        else{
           echo parent::getError();
           return;
        }
    }
