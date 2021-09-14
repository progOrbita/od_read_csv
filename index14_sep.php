<?php

use OrbitaDigital\Read\ReadCsv;
use OrbitaDigital\Read\Resources;
use OrbitaDigital\Read\ReadJson;

require_once __DIR__ . '/vendor/autoload.php';

if (!defined('_PS_VERSION_')) {
    require_once '../../config/config.inc.php';
    require_once '../../init.php';
}

$data_new_lang = [
    1 => ReadCsv::readCSV('rates/data_en_2.csv'),
    2 => ReadCsv::readCSV('rates/data_fr_2.csv'),
    3 => ReadCsv::readCSV('rates/data_es_2.csv'),
    4 => ReadCsv::readCSV('rates/data_pt_2.csv'),
];

if (Resources::checkCsvData($data_new_lang) != false) {
    $csvData = Resources::processCsvArray($data_new_lang);
} else {
    echo "Check the files again";
}
$readed = json_decode(ReadJson::readJson('rates_processed/data_13_Sep_2021.json'), true);
Resources::showJsonData($readed);
Resources::compareJsonData($csvData,$readed);    echo 'Error founds, saved in a file';
    echo Resources::dataToJsonFile($dataError, 'error');
}
