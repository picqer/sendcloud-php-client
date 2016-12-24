<?php

date_default_timezone_set('Europe/Amsterdam');

// Autoload composer stuff
require __DIR__ . '/vendor/autoload.php';

// Set up connection
$connection = new \Picqer\Carriers\SendCloud\Connection('key', 'secret');
$sendCloud = new \Picqer\Carriers\SendCloud\SendCloud($connection);

// Do stuff
$parcels = $sendCloud->parcels()->all();

var_dump($parcels);
