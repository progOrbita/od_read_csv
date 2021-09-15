<?php

use OrbitaDigital\Read\Csv;
use OrbitaDigital\Read\Json;
use OrbitaDigital\Read\Resources;

require_once __DIR__ . '/vendor/autoload.php';

$data_new_lang = [
    1 => Csv::read('rates/data_en_2.csv'),
    2 => Csv::read('rates/data_fr_2.csv'),
    3 => Csv::read('rates/data_es_2.csv'),
    4 => Csv::read('rates/data_pt_2.csv'),
];

$csvData = Resources::processCsvArray($data_new_lang);

//find match as +1 number_+1 letter_+1 number
preg_match('/\d+_\w+_\d+/',basename(__FILE__),$matched);
//Date uses "-" as european dates.
$dateFile = str_replace('_','-',$matched[0]);
$date = date('d_M_Y',strtotime($dateFile.'-1 day'));

$jsonFile = Json::readJson('rates_processed/data_'.$date.'.json');
$jsonReaded = json_decode($jsonFile, true);

$dataError = Resources::findErrors($jsonReaded, $csvData);

if ($dataError === false) {
    die('Keys dont match, array cant be compared');
} else {
    echo '<br/>Error founds, '. Json::dataToFile($dataError);
}
