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

if(gettype($enArr) == 'string' || gettype($esArr)=='string' || gettype($frArr)=='string' || gettype($ptArr)=='string'){
    die('Check the files again');
}

$data = [];

 $data_lang = [
     1 => $enArr,
     2 => $frArr,
     3 => $esArr,
     4 => $ptArr,
 ];

foreach ($data_lang as $id_lang => $arr_value) {
    foreach ($arr_value as $value) {
        $data[$value['Id']]['Titulo'][$id_lang] = $value['Titulo'];
        $data[$value['Id']]['Description'][$id_lang] = $value['Description'];
    }
}
$jsonData = json_encode($data,JSON_PRETTY_PRINT);
$date = date('d_F_Y_H_i_s'); //day, month in letters, year 4 digits, 24hour_mins_seconds
$dir = _PS_CORE_DIR_.'\practicas\od_read_csv';
echo $dir.'<br/>';
echo basename(__DIR__);
$file = $dir.'/data_'.$date.'.json';

    if(!is_dir($dir)){
        die('Directory not found');
    }
    else if(!is_file($file)){
        echo 'file dont exist, creating...';
        $createdFile = fopen($file,'w');
        fclose($createdFile);
    }
    else if(!is_writable($file)){
        die('Information cant be written');
    }
