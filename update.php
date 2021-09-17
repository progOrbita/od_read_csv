<?php

use OrbitaDigital\Read\Csv;
use OrbitaDigital\Read\Json;

require_once __DIR__ . '/vendor/autoload.php';

$jsonReader = new Json();
$csvReader = new Csv(['Id', 'Titulo', 'Description']);

$data_new_lang = [];

$csvLang = [1 => 'rates/data_en_2_ed.csv', 2 => 'rates/data_fr_2.csv', 3 => 'rates/data_es_2.csv', 4 => 'rates/data_pt_2.csv'];

foreach ($csvLang as $id_lang =>  $file) {

    $data_new_lang[$id_lang] = $csvReader->read($file);
    if (!($data_new_lang[$id_lang])) {
        die($csvReader->getLastError());
    }
}

$date = date('d_M_Y', strtotime('-1 day'));
$jsonData = $jsonReader->read('rates_processed/data_' . $date . '.json');

if (!$jsonData) {
    die($jsonReader->getLastError());
}

$csvData = $csvReader->process($data_new_lang);
$dataError = $jsonReader->findErrors(json_decode($jsonData, true), $csvData);
if (is_array($dataError)) {
    if (!$jsonReader->save($dataError, 'error')) {
        die($jsonReader->getLastError());
    }
    die($jsonReader->getMessage());
}
echo ($dataError === true) ? 'No errors found' : 'Headers dont match, json and csv files cant be compared';
