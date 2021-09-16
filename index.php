<?php

namespace OrbitaDigital\Read;

use OrbitaDigital\Read\Csv;
use OrbitaDigital\Read\Json;

require_once __DIR__ . '/vendor/autoload.php';

$jsonReader = new Json();
$csvReader = new Csv(['Id', 'Titulo', 'Description']);

$data_lang = [];
$csvLang = ['rates/data_en.csv', 'rates/data_fr.csv', 'rates/data_es.csv', 'rates/data_pt.csv'];

for ($i = 0; $i < count($csvLang); $i++) {
    $data_lang[$i + 1] = $csvReader->read($csvLang[$i]);
}

if (!$csvReader->verifyContent($data_lang)) {
    die($csvReader->getLastError());
}
$csvData = $csvReader->process($data_lang);

echo $jsonReader->save($csvData, 'data');
