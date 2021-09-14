<?php

use OrbitaDigital\Read\Csv;
use OrbitaDigital\Read\Json;
use OrbitaDigital\Read\Resources;

require_once __DIR__ . '/vendor/autoload.php';


$data_lang = [
    1 => Csv::readCSV('rates/data_en.csv'),
    2 => Csv::readCSV('rates/data_fr.csv'),
    3 => Csv::readCSV('rates/data_es.csv'),
    4 => Csv::readCSV('rates/data_pt.csv'),
];

$csvData = Resources::processCsvArray($data_lang);
echo Json::dataToJsonFile($csvData, 'data');
$jsonFile = Json::readJson('rates_processed/data_13_Sep_2021.json');

$jsonReaded = json_decode($jsonFile, true);
echo Json::showJsonData($jsonReaded);
