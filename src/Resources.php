<?php

namespace OrbitaDigital\Read;

class Resources
{

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
