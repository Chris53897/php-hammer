<?php

$dummy = function () use ($a, $b, $c) {
    return $a + $b + $c;
};

$dummy = function () use ($a, &$b, $c) {
    $b = 2;

    return $a + $c;
};

// Not applicable:

$dummy = function () use (&$a) {
    $a[] = 123;
};

$dummy = function () use (&$a) {
    array_push($a, 123);
};

$dummy = function () use (&$a) {
    (function () use (&$a) {
        $a = true;
    })();
};

$dummy = function () use (&$dummy) {
    return $dummy;
};

// Not applicable, but can be resolved by UnusedUseVariableInspection.

$dummy = function () use (&$dummy) {
};
