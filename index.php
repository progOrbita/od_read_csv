<?php

namespace OrbitaDigital\Read;

use OrbitaDigital\Read\Csv;
use OrbitaDigital\Read\Json;

require_once __DIR__ . '/vendor/autoload.php';

$jsonReader = new Json();
$csvReader = new Csv(['Id', 'Titulo', 'Description']);

$data_lang = [];
$csvLang = [1 => 'rates/data_en.csv', 2 => 'rates/data_fr.csv', 3 => 'rates/data_es.csv', 4 => 'rates/data_pt.csv'];

foreach ($csvLang as $id_lang =>  $file) {
    $data_lang[$id_lang] = $csvReader->read($file);
    if (is_string($data_lang[$id_lang])) {
        die($csvReader->getLastError());
    }
}

$csvData = $csvReader->process($data_lang);

if (!$jsonReader->save($csvData, 'data')) {
    die($jsonReader->getLastError());
}
die($jsonReader->getMessage());
