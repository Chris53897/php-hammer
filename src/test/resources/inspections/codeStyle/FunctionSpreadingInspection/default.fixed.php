<?php

$arr1 = [ 1, 2, 3 ];
$arr2 = [ 'a' => 1, 'b' => 2, 'c' => 3 ];
$arr3 = function (): array { return [ 1, 2, 3 ]; };
/** @return int[] */
$arr4 = function () { return [ 1, 2, 3 ]; };
$gen1 = function (): \Generator { yield 1; };
$gen2 = function (): \Generator { yield 'a' => 1; };
$gen3 = function (): \Generator {};
$fun1 = function (): int { return 123; };

$dummy10000 = [...something()];

$dummy10100 = [...$arr1, ...$arr2];

$dummy10200 = [...$arr1, ...$arr2, 'x' => 1, 'y' => 2, 'z' => 3];

$dummy10300 = [...$arr1, ...$arr2, ['x' => 1, 'y' => 2, 'z' => 3]];

$dummy10400 = [...$arr1, ...$arr2, ...$arr3];

$dummy10500 = [...$arr1, ...$arr2, ...$gen1()];

$dummy10600 = [...$arr1, ...$arr2, ...$arr3, ...$arr4];

// Not applicable:

$dummy90000 = iterator_to_array();

$dummy90100 = iterator_to_array(something());

$dummy90200 = iterator_to_array(something(), 0);

$dummy90300 = array_merge();

$dummy90400 = array_merge($arr1); // Not applicable because another inspection will ask for replacement to just $arr1.

$dummy90500 = array_merge($arr1, $arr2, $gen2());

$dummy90510 = array_merge($arr1, $arr2, $gen3());

$dummy90600 = array_merge($arr1, $arr2, $unknown());

$dummy90700 = array_merge($arr1, $arr2, unknown());

$dummy90800 = array_merge($arr1, $arr2, $fun1());
