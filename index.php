<?php

use OrbitaDigital\Read\Csv;
use OrbitaDigital\Read\Json;

require_once __DIR__ . '/vendor/autoload.php';

if (!isset($_GET['add']) && !isset($_GET['update'])) {
    die('put add or update in header, what is your choice?');
}

$jsonReader = new Json();
$csvReader = new Csv(['Id', 'Titulo', 'Description']);
$csvLang = [1 => 'rates/data_en.csv', 2 => 'rates/data_fr.csv', 3 => 'rates/data_es.csv', 4 => 'rates/data_pt.csv'];
$csv_new_lang = [1 => 'rates/data_en_2.csv', 2 => 'rates/data_fr_2.csv', 3 => 'rates/data_es_2.csv', 4 => 'rates/data_pt_2.csv'];

if (isset($_GET['add'])) {

    echo 'Attempting to add data...<br/>';
    $csvData = $csvReader->process($csvLang);
    if (!$csvData) {
        die($csvReader->getLastError());
    }
    if (!$jsonReader->save($csvData, 'data')) {
        die($jsonReader->getLastError());
    }
    echo ($jsonReader->getMessage());
}

if (isset($_GET['update'])) {
    echo '<br/>checking errors...<br/>';
    $csv_new_data = $csvReader->process($csv_new_lang);
    if (!$csv_new_data) {
        die($csvReader->getLastError());
    }
    $date = date('d_M_Y');

    $jsonData = $jsonReader->read('rates_processed/data_' . $date . '.json');

    if (!$jsonData) {
        die($jsonReader->getLastError());
    }

    $dataError = $jsonReader->findErrors(json_decode($jsonData, true), $csv_new_data);
    if (is_array($dataError)) {
        if ($jsonReader->save($dataError, 'error')) {
            die('Error founds, ' . $jsonReader->getMessage());
        }
        die($jsonReader->getLastError());
    }
    echo ($dataError === true) ? 'No errors found' : 'Headers dont match, json and csv files cant be compared';
}
