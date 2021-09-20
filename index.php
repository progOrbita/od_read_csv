<?php

use OrbitaDigital\Read\Csv;
use OrbitaDigital\Read\Json;

require_once __DIR__ . '/vendor/autoload.php';

$jsonReader = new Json();
$csvReader = new Csv(['Id', 'Titulo', 'Description']);

$date = date('d_M_Y');
$data_lang = [];
$data_new_lang = [];
$csvLang = [1 => 'rates/data_en.csv', 2 => 'rates/data_fr.csv', 3 => 'rates/data_es.csv', 4 => 'rates/data_pt.csv'];
$csv_new_lang = [1 => 'rates/data_en_2.csv', 2 => 'rates/data_fr_2.csv', 3 => 'rates/data_es_2.csv', 4 => 'rates/data_pt_2.csv'];

foreach ($csvLang as $id_lang =>  $file) {

    $data_file = $csvReader->read($file);
    $data_file ? $data_lang[$id_lang] = $data_file : die($csvReader->getLastError());
}

if (isset($_GET['add'])) {
    echo 'Attempting to add data...<br/>';
    $csvData = $csvReader->process($data_lang);

    if ($jsonReader->save($csvData, 'data')) {
        die($jsonReader->getMessage());
    }
    die($jsonReader->getLastError());
}

if (isset($_GET['update'])) {
    echo 'checking errors...<br/>';

    foreach ($csv_new_lang as $id_lang =>  $file) {

        $data_new_file = $csvReader->read($file);
        $data_new_file ? $data_new_lang[$id_lang] = $data_new_file : die($csvReader->getLastError());
    }
    
    $jsonData = $jsonReader->read('rates_processed/data_' . $date . '.json');

    if (!$jsonData) {
        die($jsonReader->getLastError());
    }

    $csvData = $csvReader->process($data_new_lang);
    $dataError = $jsonReader->findErrors(json_decode($jsonData, true), $csvData);
    if (is_array($dataError)) {
        if ($jsonReader->save($dataError, 'error')) {
            die('Error founds, '.$jsonReader->getMessage());
        }
        die($jsonReader->getLastError());
    }
    echo ($dataError === true) ? 'No errors found' : 'Headers dont match, json and csv files cant be compared';
}
