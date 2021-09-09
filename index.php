<?php

if(!defined('_PS_VERSION_')){
    require_once '../../config/config.inc.php';
    require_once '../../init.php';
}
use OrbitaDigital\Read\ReadCsv;
require_once __DIR__ .'/vendor/autoload.php';

$esArr = [];
$enArr = [];
$ptArr = [];
$frArr = [];
$masterArray = [];

$enArr = ReadCsv::readCSV('data_en.csv');
$frArr = ReadCsv::readCSV('data_fr.csv');
$esArr = ReadCsv::readCSV('data_es.csv');
$ptArr = ReadCsv::readCSV('data_pt.csv');

$fileNumber = 4;

for ($i=1; $i < $fileNumber; $i++) { 
    for ($j=1; $j < $fileNumber-1; $j++) {
        for ($k=1; $k < $fileNumber-2; $k++) { 
            $masterArray[][$esArr[$i][0]] = [
                    $esArr[0][$j] => [
                        $enArr[$i][$j],
                        $frArr[$i][$j],
                        $esArr[$i][$j],
                        $ptArr[$i][$j]
                    ]
                ];
        }
    }
}
//Merge the E1/E2/E3 fields
$arrayJson = array_merge_recursive($masterArray[0],$masterArray[1],$masterArray[2],$masterArray[3],$masterArray[4],$masterArray[5]);
$saveJson = json_encode($arrayJson);
file_put_contents('fileJson.json',$saveJson);
