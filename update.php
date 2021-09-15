<?php

namespace OrbitaDigital\Read;

use OrbitaDigital\Read\Csv;
use OrbitaDigital\Read\Json;

require_once __DIR__ . '/vendor/autoload.php';

$jsonReader = new Json();
$csvReader = new Csv();

$data_new_lang = [
    1 => $csvReader->read('rates/data_en_2.csv'),
    2 => $csvReader->read('rates/data_fr_2.csv'),
    3 => $csvReader->read('rates/data_es_2.csv'),
    4 => $csvReader->read('rates/data_pt_2.csv'),
];

$csvData = $csvReader->process($data_new_lang);

$date = date('d_M_Y', strtotime('-1 day'));
$jsonFile = $jsonReader->readJson('rates_processed/data_' . $date . '.json');

$dataError = $jsonReader->findErrors(json_decode($jsonFile, true), $csvData);

if ($dataError === false) {
    die('Keys dont match, arrays cant be compared');
}
if ($dataError === true) {
    die('No errors found');
} else {
    echo '<br/>Error founds, ' . $jsonReader->saveJson($dataError, 'error');
}
