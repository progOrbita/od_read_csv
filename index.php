<?php

use OrbitaDigital\Read\Csv;
use OrbitaDigital\Read\Json;
use OrbitaDigital\Read\Resources;

require_once __DIR__ . '/vendor/autoload.php';


$jsonReader = new Json();
$csvReader = new Csv();
$data_lang = [
    1 => $csvReader->read('rates/data_en.csv'),
    2 => $csvReader->read('rates/data_fr.csv'),
    3 => $csvReader->read('rates/data_es.csv'),
    4 => $csvReader->read('rates/data_pt.csv'),
];

$csvData = $csvReader->process($data_lang);
echo $jsonReader->dataToFile($csvData, 'data');
