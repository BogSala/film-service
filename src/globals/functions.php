<?php

function arrayFlat($array): array
{
    $return = array();
    foreach ($array as $key => $value) {
        if (is_array($value)){ $return = array_merge($return, arrayFlat($value));}
        else {$return[$key] = $value;}
    }
    return $return;
}