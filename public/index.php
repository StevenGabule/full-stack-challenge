<?php

require_once __DIR__ . '/../vendor/autoload.php';

$app = new Otto\Challenge();
$content = null;

$records = $app->getRecords();
include __DIR__ . '/../views/index.phtml';