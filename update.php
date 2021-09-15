<?php

use OrbitaDigital\Read\Csv;
use OrbitaDigital\Read\Json;
use OrbitaDigital\Read\Resources;

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
$jsonReaded = json_decode($jsonFile, true);

$dataError = ReadFiles::findErrors($jsonReaded, $csvData);

if ($dataError === false) {
    die('Keys dont match, arrays cant be compared');
} else {
    echo '<br/>Error founds, ' . $jsonReader->dataToFile($dataError, 'error');
}
