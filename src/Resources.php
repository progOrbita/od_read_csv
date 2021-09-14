<?php

namespace OrbitaDigital\Read;

class Resources
{
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
     * Compare two arrays to find distinct values beetwen both
     * @param array $rightArray json which is fine
     * @param array $arrayToCompare json which may contains errors and will return them if the value is different
     * @return mixed $errorArrays with the errors located beetwen both files. Empty if no error. False if keys differs
     */
    public static function findErrorsJson(array $rightArray, array $arrayToCompare)
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
                    return false;
                }
            }
        }
        return $errorArrays;
    }
}
