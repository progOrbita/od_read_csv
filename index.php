<?php

use OrbitaDigital\Read\Resources;
require_once __DIR__ .'/vendor/autoload.php';

$enArr = ReadCsv::ReadCsv('data_en.csv');
$frArr = ReadCsv::ReadCsv('data_fr.csv');
$esArr = ReadCsv::ReadCsv('data_es.csv');
$ptArr = ReadCsv::ReadCsv('data_pt.csv');
$aaArr = ReadCsv::ReadCsv('data_e.csv');
$write = ReadCsv::ReadCsv('write_only.json');
$noncsv = ReadCsv::ReadCsv('readme.md');

if(gettype($enArr) == 'string' ){
    echo $enArr;
}
if(gettype($frArr) == 'string'){
    echo $frArr;
}
if(gettype($esArr) == 'string'){
    echo $esArr;
}
if(gettype($ptArr) == 'string'){
    echo $ptArr;
}
if(gettype($aaArr) == 'string'){
    echo $aaArr;
}
if(gettype($write) == 'string'){
    echo $write;
}
if(gettype($noncsv) == 'string'){
    echo $noncsv;
}

//Merge the arrays
$merge = array_merge($enArr,$frArr,$esArr,$ptArr);
if(gettype($enArr) == 'string' || gettype($esArr)=='string' || gettype($frArr)=='string' || gettype($ptArr)=='string'){
    die('Check the files again');
}

$data = [];

foreach ($merge as $key => $value) {
    $data[$value['Id']]['Titulo'][] = $value['Titulo'];
    $data[$value['Id']]['Description'][] = $value['Description'];   
}
$saveJson = json_encode($arrayJson);
file_put_contents('fileJson.json',$saveJson);
