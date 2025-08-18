#!/usr/bin/env php
<?php

require __DIR__ . '/func/functions.php';

$versionMaps = require __DIR__ . '/../data/object_maps.php';
ksort($versionMaps); // just in case

$combinedMaps = array();
$totalMap = array();

foreach ($versionMaps as $version => $exts) {
    foreach ($exts as $ext => $map) {
        array_walk($map, function (&$value) use ($ext) {
            $value = array($ext, $value);
        });
        $totalMap += $map;
        $combinedMaps[$version] = $totalMap;
    }
}

$combinedMaps['50000'] = array();

// generate specific versions
foreach ($combinedMaps as $version => $map) {
    ksort($map);
    file_put_contents(
        __DIR__ . '/../gen/ResourceMap' . $version . '.php',
        render('ResourceMap', array(
            'map' => $map,
            'version' => $version,
        ))
    );
}

// generate loader
file_put_contents(
    __DIR__ . '/../gen/ResourceMap.php',
    render('ResourceMapLoader', array('versions' => array_reverse(array_keys($versionMaps))))
);
