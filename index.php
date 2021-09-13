<?php

use OrbitaDigital\Read\Resources;
require_once __DIR__ .'/vendor/autoload.php';


$enArr = Resources::processCsv('data_en.csv');
$frArr = Resources::processCsv('data_fr.csv');
$esArr = Resources::processCsv('data_es.csv');
$ptArr = Resources::processCsv('data_pt.csv');
$aaArr = Resources::processCsv('data_e.csv');
$write = Resources::processCsv('write_only.json');
$noncsv = Resources::processCsv('readme.md');

//Merge the arrays
$merge = array_merge($enArr,$frArr,$esArr,$ptArr);

$data = [];

foreach ($merge as $key => $value) {
    $data[$value['Id']]['Titulo'][] = $value['Titulo'];
    $data[$value['Id']]['Description'][] = $value['Description'];   
}
$saveJson = json_encode($arrayJson);
file_put_contents('fileJson.json',$saveJson);
