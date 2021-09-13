<?php

use OrbitaDigital\Read\ReadCsv;
use OrbitaDigital\Read\Resources;
require_once __DIR__ .'/vendor/autoload.php';

$esArr = [];
$enArr = [];
$ptArr = [];
$frArr = [];
$masterArray = [];

$enArr = Resources::processCsv('data_en.csv');
$frArr = Resources::processCsv('data_fr.csv');
$esArr = Resources::processCsv('data_es.csv');
$ptArr = Resources::processCsv('data_pt.csv');
$aaArr = Resources::processCsv('data_e.csv');
$write = Resources::processCsv('write_only.json');
$noncsv = Resources::processCsv('readme.md');
foreach ($merge as $key => $value) {
    $data[$value['Id']]['Titulo'][] = $value['Titulo'];
    $data[$value['Id']]['Description'][] = $value['Description'];
    
}
//Merge the E1/E2/E3 fields
$arrayJson = array_merge_recursive($masterArray[0],$masterArray[1],$masterArray[2],$masterArray[3],$masterArray[4],$masterArray[5]);
$saveJson = json_encode($arrayJson);
file_put_contents('fileJson.json',$saveJson);
