<?php

use OrbitaDigital\Read\ReadCsv;
use OrbitaDigital\Read\Resources;

require_once __DIR__ . '/vendor/autoload.php';

if (!defined('_PS_VERSION_')) {
    require_once '../../config/config.inc.php';
    require_once '../../init.php';
}

$data_lang = [
    1 => ReadCsv::ReadCsv('rates/data_en.csv'),
    2 => ReadCsv::ReadCsv('rates/data_fr.csv'),
    3 => ReadCsv::ReadCsv('rates/data_es.csv'),
    4 => ReadCsv::ReadCsv('rates/data_pt.csv'),
];

if (Resources::checkData($data_lang) != false) {
    $csvData = Resources::processCsvArray($data_lang);
    echo Resources::dataToJsonFile($csvData);
} else {
    echo "Check the files again";
}
