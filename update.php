<?php

namespace OrbitaDigital\Read;

use OrbitaDigital\Read\Csv;
use OrbitaDigital\Read\Json;
use OrbitaDigital\Read\Save;

require_once __DIR__ . '/vendor/autoload.php';

$jsonReader = new Json();
$csvReader = new Csv();
$save = new Save();
$data_new_lang = [];

$csvLang = ['rates/data_en_2.csv', 'rates/data_fr_2.csv', 'rates/data_es_2.csv', 'rates/data_pt_2.csv'];

for ($i = 0; $i < count($csvLang); $i++) {
    $data_new_lang[$i + 1] = $csvReader->read($csvLang[$i]);
}

if (!$csvReader->verifyContent($data_new_lang)) {
    die();
}

$date = date('d_M_Y', strtotime('-1 day'));
$jsonData = $jsonReader->read('rates_processed/data_' . $date . '.json');

if (!$jsonData) {
    die();
}

$csvData = $csvReader->process($data_new_lang);
$dataError = $jsonReader->findErrors(json_decode($jsonData, true), $csvData);

if ($dataError === false) {
    die('Headers dont match, json and csv files cant be compared');
}
if ($dataError === true) {
    die('No errors found');
} else {
    echo '<br/>Error founds, ' . $save->saveJson($dataError, 'error');
}
