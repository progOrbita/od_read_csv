<?php

namespace OrbitaDigital\Read;

class Resources
{
    /**
     * Read and extract the data from an array of csv files into an joined array
     * @param array $csvData csv array to extract information
     * @return array $data array with the joined csv information
     */
    public static function processCsvArray(array $csvData)
    {
        //each id_lang key contains the csv with that language csv
        self::verifyCsvContent($csvData);
        foreach ($csvData as $id_lang => $lang_csv) {
            foreach ($lang_csv as $csv_values) {
                $data[$csv_values['Id']]['Titulo'][$id_lang] = $csv_values['Titulo'];
                $data[$csv_values['Id']]['Description'][$id_lang] = $csv_values['Description'];
            }
        }
        return $data;
    }
    /**
     * Check if the csv files have content, exiting if an error was found.
     * @param array $csvData array with the csv information
     */
    private static function verifyCsvContent(array $csvData): bool
    {
        foreach ($csvData as $lang_csv) {
            if (is_string($lang_csv)) {
                die($lang_csv);
            }
        }
        return true;
    }

    /**
     * Compare two arrays to find distinct values beetwen both
     * @param array $rightArray json which is fine
     * @param array $arrayToCompare json which may contains errors and will return them if the value is different
     * @return bool|array $errorArrays with the errors located beetwen both files. False if keys differs.
     */
    public static function findErrors(array $rightArray, array $arrayToCompare)
    {

        $dataError = [];
        foreach ($rightArray as $id => $value) {
            if (array_keys($rightArray[$id]) === array_keys($arrayToCompare[$id])) {
                for ($id_lang = 1; $id_lang <= 4; $id_lang++) {
                    if ($rightArray[$id]['Titulo'][$id_lang] !== $arrayToCompare[$id]['Titulo'][$id_lang]) {
                        $dataError[$id]['Titulo'][$id_lang][] = $arrayToCompare[$id]['Titulo'][$id_lang];
                    }
                    if ($rightArray[$id]['Description'][$id_lang] !== $arrayToCompare[$id]['Description'][$id_lang]) {
                        $dataError[$id]['Description'][$id_lang] = $arrayToCompare[$id]['Description'][$id_lang];
                    }
                }
            } else {
                return false;
            }
        }
        return $dataError;
    }
}
