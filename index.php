<?php

use OrbitaDigital\Read\Csv;
use OrbitaDigital\Read\Json;
use OrbitaDigital\Read\Resources;

require_once __DIR__ . '/vendor/autoload.php';


$data_lang = [
    1 => Csv::read('rates/data_en.csv'),
    2 => Csv::read('rates/data_fr.csv'),
    3 => Csv::read('rates/data_es.csv'),
    4 => Csv::read('rates/data_pt.csv'),
];

$csvData = Resources::processCsvArray($data_lang);
echo Json::dataToFile($csvData, 'data');
