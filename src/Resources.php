<?php

namespace OrbitaDigital\Read;

class Resources
{
    /**
     * Writes data to a file
     * @param array $data array containing all the information
     * @param string $prefix optional, add a prefix to the file
     * @return string A message showing the result
     */
    public static function dataToJsonFile(array $data, string $prefix = ''): string
    {
        $csvData = json_encode($data, JSON_PRETTY_PRINT, JSON_FORCE_OBJECT);
        $currentDate = date('d_M_Y'); //day, short month, year 4 digits, 24hour_mins_seconds
        $dir = getcwd() . '/rates_processed'; //takes current script directory
        $file = $dir . '/' . $prefix . '_' . $currentDate . '.json';
        //Verify if directory exist and have write access
        if (!is_dir($dir)) {
            echo 'Directory <b>' . $dir . '</b> not found, creating...';
            if (!mkdir($dir, 0777, true)) {
                return '<br/><b>' . $dir . '</b> cannot be created, verify the permissions';
            }
            echo '<br/>Directory created';
            //If file exist and can be created in the directory, create a new one.
        } else if (!is_file($file)) {
            echo '<br/>File dont exist, creating <b>' . $file . '</b> ...';
            $createdFile = fopen($file, 'w');
            //If file can't be created in the directory (access denied).
            if ($createdFile == false) {
                return '<br/>File couldnt be created on <b>' . $dir . '</b>, exiting';
            }
            fclose($createdFile);
            //If file dont have write permissions
        } else if (!is_writable($file)) {
            return 'Information cant be written on <b>' . $file . '</b>';
        }
        file_put_contents($file, $csvData);
        return '<br/>Data inserted in file: <b>' . $file . '</b>';
    }
    /**
     * Read and extract the data from an array of csv files into an joined array
     * @param array $csvData csv array to extract information
     * @return array $data array with the joined csv information
     */
    public static function processCsvArray(array $csvData): array
    {
        //each id_lang key contains the csv with that language csv
        foreach ($csvData as $id_lang => $lang_csv) {
            foreach ($lang_csv as $csv_values) {
                $data[$csv_values['Id']]['Titulo'][$id_lang] = $csv_values['Titulo'];
                $data[$csv_values['Id']]['Description'][$id_lang] = $csv_values['Description'];
            }
        }
        return $data;
    }
    /**
     * Checks if the content of the data is right
     * @param array $dataArray array to verify the content
     * @return bool true if there's no errors and false otherwise
     */
    public static function checkCsvData(array $dataArray): bool
    {
        foreach ($dataArray as $csvData) {

            if (is_string($csvData)) {
                return false;
            }
        }
        return true;
    }

    /**
     * Compare two arrays to find distinct values beetwen both
     * @param array $rightArray json which is fine
     * @param array $arrayToCompare json which may contains errors and will return them if the value is different
     * @return array $errorArrays with the errors located beetwen both files. Empty if no
     */
    public static function findErrorsJson(array $rightArray, array $arrayToCompare): array
    {
        $errorArrays = [];
        foreach ($rightArray as $key => $value) {
            foreach ($value as $key2 => $value2) {
                if (array_keys($rightArray[$key]) === array_keys($arrayToCompare[$key])) {
                    for ($i = 1; $i <= 4; $i++) {
                        if ($rightArray[$key][$key2][$i] !== $arrayToCompare[$key][$key2][$i]) {
                            $errorArrays[$key][$key2][$i][] = $arrayToCompare[$key][$key2][$i];
                        }
                    }
                } else {
                    return $errorArrays;
                }
            }
        }
        return $errorArrays;
    }
}
