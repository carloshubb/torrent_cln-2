<?php

require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/assert.php';

$testCases = array();

// test some popular and easy to config extensions
// add other if they become problematic

// converted in 5.6
$testCases[] = array('GMP integer', function() { return gmp_init('1'); });
// converted in 7.2
$testCases[] = array('Hash Context', function() { return hash_init('md5'); });
// converted in 8.0
$testCases[] = array('gd', function() { return imagecreate(100, 100); });
// converted in 8.1
$testCases[] = array('file_info', function() { return finfo_open(); });
// not converted as of 8.1
$testCases[] = array('stream', function() { return fopen(__FILE__, 'r'); });

foreach ($testCases as $testCase) {
    list($resourceType, $callback) = $testCase;

    $resource = $callback();

    assert_true(\Arokettu\IsResource\is_resource($resource));
    assert_equals($resourceType, \Arokettu\IsResource\get_resource_type($resource));
    assert_equals($resourceType, \Arokettu\IsResource\try_get_resource_type($resource));
}
