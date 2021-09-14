<?php

use OrbitaDigital\Read\Csv;
use OrbitaDigital\Read\Json;
use OrbitaDigital\Read\Resources;

require_once __DIR__ . '/vendor/autoload.php';

$readerCsv = new Csv();
$data_new_lang = [
    1 => $readerCsv->readCSV('rates/data_en_2.csv'),
    2 => $readerCsv->readCSV('rates/data_fr_2.csv'),
    3 => $readerCsv->readCSV('rates/data_es_2.csv'),
    4 => $readerCsv->readCSV('rates/data_pt_2.csv'),
];

if (Resources::checkCsvData($data_new_lang) != false) {
    $csvData = Resources::processCsvArray($data_new_lang);
} else {
    echo "Check the files again";
}
$reader = new Json();
$json = $reader->readJson('rates_processed/data_13_Sep_2021.json');
$readed = json_decode($json, true);
$reader->showJsonData($readed);

$dataError = Resources::findErrorsJson($readed, $csvData);
if (sizeof($dataError) > 0) {
    echo 'Error founds, saved in a file';
    echo Resources::dataToJsonFile($dataError, 'error');
}
