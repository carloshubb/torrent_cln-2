<?php

function export($array)
{
    if ($array === array()) {
        return 'array()';
    }

    $output = "array(\n";

    foreach ($array as $key => $values) {
        $output .=
            '            ' .
            var_export($key, true) .
            ' => array(' .
            implode(', ', array_map(function ($value) {
                return var_export($value, true);
            }, $values)) .
            "),\n";
    }

    $output .= '        )';

    return $output;
}

function render($template, $values = array())
{
    extract($values);
    ob_start();
    require __DIR__ . '/../../data/' . $template . '.tpl.php';
    return ob_get_clean();
}
