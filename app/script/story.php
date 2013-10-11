<?php
require_once '../_config.php';

$dataService = new DataService('stories');
$eras = $dataService->service_get();

$res = json_decode($eras, 1);

print_r($res);