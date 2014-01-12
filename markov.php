<?php

require 'vendor/autoload.php';

if (count($argv) < 2) {
    exit("USAGE: {$argv[0]} file-1 file-2 ...");
} else {
    array_shift($argv);
}

$markov = new MarkovGenerator();

$min = PHP_INT_MAX;
$max = 0;

while (count($argv) > 0) {
    $lines = explode(PHP_EOL, file_get_contents(array_shift($argv)));

    foreach ($lines as $sentence) {
        if ($sentence) {
            $min = min($min, strlen($sentence));
            $max = max($max, strlen($sentence));
            $markov->learn($sentence);
        }
    }
}

$length = rand($min, $max);
echo $markov->generate($length), PHP_EOL;
