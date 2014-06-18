<?php

include 'html_writer.class.php';
include 'id3tagreader.php';

/**
 * Returns random hex colour code
 *
 * @param array $selection predefined selection of colours to choose from
 * @return string
 */
function random_colour($selection=array()) {

    if ($selection) {
        return $selection[rand(1, count($selection))-1];
    }

    $colour = '';
    $levels = array(255, 255, 255);
    for ($i = 0; $i < 3; $i++) {
        $colour .= str_pad(dechex(mt_rand(0, $levels[$i])), 2, '0', STR_PAD_LEFT);
    }

    return $colour;
}

/**
 * Returns random filename from passed folder
 *
 * @param string directory to pick a random file from
 * @return string
 */
function random_file($dir) {

    $files = array();
    $new = array();

    if (is_dir($dir)) {
        if ($dh = opendir($dir)) {
            while (($file = readdir($dh)) !== false) {
                if ($file != '.' && $file != '..') {
                    $files[] = $file;
                }
            }
            closedir($dh);
        }

        $keys = array_keys($files);
        shuffle($keys);
        foreach($keys as $key) {
            $new[$key] = $files[$key];
        }

        // todo: return the whole array?

        return $dir . array_values($new)[0];
    }
}

/**
 * Use to print object and array structures
 *
 * @param obj/array $obj
 */
function print_object($obj) {

    echo '<pre>';
    print_r($obj);
    echo '</pre>';
}
