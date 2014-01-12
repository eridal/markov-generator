<?php


/**
 * This class can generate pseudo-random texts using its learned experience as input
 *
 * @example
 * <code>
 *     $experience = array(
 *         '1 2 3 4 5',
 *         '2 4 6',
 *         '1 3 5',
 *         '1 2 3 2 1'
 *     );
 *     $markov = new MarkovGenerator();
 *
 *     forEach ($experience as $sentence) {
 *         $markov->learn($sentence);
 *     }
 *
 *     echo $markov->generate(3); // generate a 3-words sentence
 */
class MarkovGenerator {

    /**
     * @var array
     */
    private $chains = array();

    /**
     * The quantity of chains this Generator has learned
     *
     * @return int
     */
    function size() {
        return count($this->chains());
    }

    /**
     * The set of chains that this Generator has learned
     *
     * @return array of strings
     */
    function chains() {
        $seeds = array();

        foreach ($this->chains as $w1 => $chain)
            foreach ($chain as $w2 => $_)
                $seeds[] = array($w1, $w2);

        return $seeds;
    }

    /**
     * Teach a $sentence to this Generator
     *
     * @param string $sentence the sentence to be learn
     */
    function learn($sentence) {

        $words = explode(' ', $sentence);

        if (count($words) < 3) {
            return;
        }

        $w2 = array_shift($words);
        $w3 = array_shift($words);

        do {

            $w1 = $w2;
            $w2 = $w3;
            $w3 = array_shift($words);

            $this->chains[$w1][$w2][] = $w3;

        } while (count($words));
    }

    /**
     * Generate a pseudo-random sentence, using the previous learned experience
     *
     * @param  int $length maximum quantity of words
     * @return string the generated sentence
     *
     * @throws MarkovGeneratorException if the
     */
    function generate ($length) {

        if (empty($this->chains)) {
            throw new MarkovGeneratorException("Markov needs to *learn* first");
        }

        $w1 = array_rand($this->chains, 1);
        $w2 = array_rand($this->chains[$w1], 1);

        $sentence = array();

        for ($i = 0; $i < $length; $i++) {

            $sentence[] = $w1;

            if (isset($this->chains[$w1][$w2])) {
                $next = $this->chains[$w1][$w2];
            } else {
                $sentence[] = $w2;
                break;
            }

            $w1 = $w2;
            $w2 = $next[array_rand($next, 1)];
        }

       return implode(' ', $sentence);
    }
}
