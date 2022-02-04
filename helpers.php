<?php

function clean_name($name) {
    return ucfirst(strtolower($name));
}

function flatten(array $array) {
    $return = array();
    array_walk_recursive($array, function($a) use (&$return) { $return[] = $a; });
    return $return;
}

?>