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


$json = Json::readJson('rates_processeda_13_Sep_2021.json');
$jsonRead = json_decode($json, true);
echo Json::showJsonData($jsonRead);

$dataError = Resources::findErrorsJson($readed, $csvData);
if (sizeof($dataError) > 0) {
    echo 'Error founds, saved in a file';
    echo Resources::dataToJsonFile($dataError, 'error');
}
