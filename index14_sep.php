<?php

use OrbitaDigital\Read\Csv;
use OrbitaDigital\Read\Json;
use OrbitaDigital\Read\Resources;

require_once __DIR__ . '/vendor/autoload.php';


$data_new_lang = [
    1 => Csv::readCSV('rates/data_en_2.csv'),
    2 => Csv::readCSV('rates/data_fr_2.csv'),
    3 => Csv::readCSV('rates/data_es_2.csv'),
    4 => Csv::readCSV('rates/data_pt_2.csv'),
];

$csvData = Resources::processCsvArray($data_new_lang);

$jsonFile = Json::readJson('rates_processed/data_13_Sep_2021.json');
$jsonReaded = json_decode($jsonFile, true);
echo Json::showJsonData($jsonReaded);

$dataError = Resources::findErrorsArray($jsonReaded, $csvData);

if ($dataError === false) {
    die('Keys dont match, json cant be compared');
} else {
    echo 'Error founds, saved in a file';
    echo Json::dataToJsonFile($dataError);
}
