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
    /**
     * Show jsonData on index
     * @param array $jsonData json information to be shown in the screen
     */
    public function showJsonData(array $jsonData)
    {
        foreach ($jsonData as $key => $value) {
            foreach ($value as $key2 => $value2) {
                echo $key . '<br/>';
                echo $key2;
                for ($i = 1; $i <= 4; $i++) {
                    echo '<br/>' . $value2[$i];
                }
                echo '<br/>';
            }
            echo '<br/>';
        }
    }
}
