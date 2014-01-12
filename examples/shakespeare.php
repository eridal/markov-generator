<?php
/**
 * This example will create a pseudo-random sonet using Shakespeare's as a trainning model.
 * Sonets were taken from wikipedia:
 *     from https://en.wikipedia.org/wiki/Sonnet_140
 *     till https://en.wikipedia.org/wiki/Sonnet_157
 */

define('SONET_LINES', 14);
define('WORDS_PER_LINE', 10);

require __DIR__ . '/../vendor/autoload.php';

$sonets = explode(PHP_EOL, file_get_contents(__DIR__ . '/shakespeare.txt'));
$markov = new MarkovGenerator();

foreach ($sonets as $sentence) {
    if ($sentence) {
        $markov->learn($sentence);
    }
}


for ($i=0; $i < SONET_LINES; $i++) {
    if ($i > SONET_LINES - 3) {
        // last two lines should be indented
        echo "  ";
    }

    $line = ucfirst($markov->generate(WORDS_PER_LINE));

    if ($i === (SONET_LINES - 1)) {
        // last line should end with a dot
        $last = substr($line, -1, 1);
        if (',' === $last) {
            $line = substr($line, 0, -1) . '.';
        } elseif (preg_match('#\w#', $last)) {
            $line .= '.';
        }
    }

    echo $line, PHP_EOL;
}
