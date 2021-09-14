<?php

use OrbitaDigital\Read\Json;
use OrbitaDigital\Read\Csv;
use OrbitaDigital\Read\Resources;

require_once __DIR__ . '/vendor/autoload.php';

$readerCsv = new Csv();
$data_lang = [
    1 => $readerCsv->readCSV('rates/data_en.csv'),
    2 => $readerCsv->readCSV('rates/data_fr.csv'),
    3 => $readerCsv->readCSV('rates/data_es.csv'),
    4 => $readerCsv->readCSV('rates/data_pt.csv'),
];

if (Resources::checkCsvData($data_lang) != false) {
    $csvData = Resources::processCsvArray($data_lang);
    echo Resources::dataToJsonFile($csvData, 'data');
} else {
    die("Check the files again");
}
$readerJson = new Json();
$jsonReaded = json_decode($readerJson->readJson('rates_processed/data_13_Sep_2021.json'), true);
echo $readerJson->showJsonData($jsonReaded);
