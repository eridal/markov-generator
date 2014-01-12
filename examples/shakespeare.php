<?php

require __DIR__ . '/../vendor/autoload.php';

$lines = explode(PHP_EOL, file_get_contents(__DIR__ . '/shakespeare.txt'));
$markov = new MarkovGenerator();

foreach ($line as $sentence) {
    if ($sentence) {
        $markov->learn($sentence);
    }
}

for ($i=0; $i < 14; $i++) {
    if ($i > 12) echo "\t";
    echo $markov->generate(rand($avg - 2, $avg + 2)), PHP_EOL;
}
