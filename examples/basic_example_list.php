<?php

use Sara;

require_once __DIR__ . '/../vendor/autoload.php';

$sara = new Sara();

$sara->auth("API_KEY", "API_SECRET");

$localities = $sara->hivemind()->localities()->list();
$requests = $sara->hivemind()->requests()->list();
$operations = $sara->hivemind()->operations()->list();
