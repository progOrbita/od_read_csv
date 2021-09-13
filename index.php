<?php

use OrbitaDigital\Read\ReadCsv;
use OrbitaDigital\Read\Resources;

require_once __DIR__ .'/vendor/autoload.php';

if(!defined('_PS_VERSION_')){
    require_once '../../config/config.inc.php';
    require_once '../../init.php';
}

$data_en = ReadCsv::ReadCsv('data_en.csv');
$data_fr = ReadCsv::ReadCsv('data_fr.csv');
$data_es = ReadCsv::ReadCsv('data_es.csv');
$data_pt = ReadCsv::ReadCsv('data_pt.csv');
$aaArr = ReadCsv::ReadCsv('data_e.csv');
$write = ReadCsv::ReadCsv('write_only.json');
$noncsv = ReadCsv::ReadCsv('readme.md');

if(gettype($data_en) == 'string' ){
    echo $data_en;
}
if(gettype($data_fr) == 'string'){
    echo $data_fr;
}
if(gettype($data_es) == 'string'){
    echo $data_es;
}
if(gettype($data_pt) == 'string'){
    echo $data_pt;
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

if(gettype($data_en) == 'string' || gettype($data_es)=='string' || gettype($data_fr)=='string' || gettype($data_pt)=='string'){
    die('Check the files again');
}

$data = [];

 $data_lang = [
     1 => $data_en,
     2 => $data_fr,
     3 => $data_es,
     4 => $data_pt,
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
$file = $dir.'/data_'.$date.'.json';

echo Resources::dataToJsonFile($data,$file,$dir);
?>