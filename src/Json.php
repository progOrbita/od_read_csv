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
     * Show the data contained in the array
     * @param array $jsonData json information to be shown in the screen
     * @return string $output html string with the information extracted
     */
    public function showJsonData(array $jsonData)
    {
        $output = '';
        foreach ($jsonData as $key => $value) {
            foreach ($value as $key2 => $value2) {
                $output .= $key . '<br/>';
                $output .= $key2;
                for ($i = 1; $i <= 4; $i++) {
                    $output .= '<br/>' . $value2[$i];
                }
                $output .= '<br/>';
            }
            $output .= '<br/>';
        }
        return $output;
    }
}
