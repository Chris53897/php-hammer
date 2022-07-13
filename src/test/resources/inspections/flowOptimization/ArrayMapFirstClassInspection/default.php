<?php

$dummy = <weak_warning descr="[PHP Hammer] Call to array_map() can be replaced by first-class callback.">array_map(function ($dummy) {
    return strlen($dummy);
}, [])</weak_warning>;

$dummy = <weak_warning descr="[PHP Hammer] Call to array_map() can be replaced by first-class callback.">array_map(static function ($dummy) {
    return strlen($dummy);
}, [])</weak_warning>;

$dummy = <weak_warning descr="[PHP Hammer] Call to array_map() can be replaced by first-class callback.">array_map(fn($dummy) => strlen($dummy), [])</weak_warning>;

$dummy = <weak_warning descr="[PHP Hammer] Call to array_map() can be replaced by first-class callback.">array_map(static fn($dummy) => strlen($dummy), [])</weak_warning>;

// Not applicable:

$dummy = array_map(static fn() => 123, []);

$dummy = array_map(static fn() => strlen('123'), []);

$dummy = array_map(static fn($self) => strlen($self) + 1, []);

$dummy = array_map(static fn($self) => array_merge($self, $self), []);

$dummy = array_map(static fn($dummy) => strlen(... $dummy), []);

$dummy = array_map(static function ($self) {
    if ($self) {
    }

    return strlen($self);
}, []);

$dummy = array_map(static function ($dummy) {
    strlen($dummy);
}, []);
