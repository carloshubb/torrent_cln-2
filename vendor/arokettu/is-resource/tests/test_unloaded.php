<?php

require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/assert.php';

if (extension_loaded('gd')) {
    throw new LogicException("GD should be not loaded for this test");
}

class GdImage {}

$gd = new GdImage();

assert_false(\Arokettu\IsResource\is_resource($gd));
assert_null(\Arokettu\IsResource\try_get_resource_type($gd));

// >= 8.0 throws TypeError, < 8.0 null + warning
if (PHP_VERSION_ID >= 80000) {
    assert_exception(function () use ($gd) {
        \Arokettu\IsResource\get_resource_type($gd);
    }, 'TypeError');
} else {
    assert_null(@\Arokettu\IsResource\get_resource_type($gd));
}
