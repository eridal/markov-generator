<?php

class MarkovGeneratorTest extends PHPUnit_Framework_TestCase {

    function test_notTrainedModelThrows() {

        $exception = null;
        $markov = new MarkovGenerator();

        try {
            $markov->generate(1);
        } catch (MarkovGeneratorException $e) {
            $exception = $e;
        }

        $this->assertInstanceOf('Exception', $exception);
    }

    function test_smallSentencesAreNotLearn() {
        $markov = new MarkovGenerator();
        $markov->learn('');
        $markov->learn('1');
        $markov->learn('1 2');

        $this->assertEquals(0, $markov->size());
        $this->assertEquals(array(), $markov->chains());
    }

    function test_goodSentencesAreLearn() {
        $markov = new MarkovGenerator();
        $markov->learn('1 2 1');
        $markov->learn('1 2 2');
        $markov->learn('1 2 3');

        $this->assertEquals(1, $markov->size());
        $this->assertEquals(array(array(1, 2)), $markov->chains());
    }

    function test_wordsAreGenerated() {
        $markov = new MarkovGenerator();
        $markov->learn('1 1 1 1 1 1 1 1');

        for ($size = 1; $size <= $markov->size(); $size++) {
            $word[] = '1';
            $this->assertEquals(implode(' ', $word), $markov->generate($size));
        }
    }

    function test_generateLength() {
        $markov = new MarkovGenerator();
        $markov->learn('1 2 3');
        $markov->learn('1 1 3');
        $markov->learn('2 2 3');

        for ($i = 0; $i < 100; $i++) {
            $generated = $markov->generate(5);
            $this->assertTrue(strlen($generated) <= 5, "failed: $generated");
        }
    }

    function test_generate() {
        $experience = array(
          '1 2 3 4 5',
          '2 4 6',
          '1 3 5',
          '1 2 3 2 1'
        );

        $markov = new MarkovGenerator();

        forEach ($experience as $sentence) {
          $markov->learn($sentence);
        }

        $generated = $markov->generate(3);
        $this->assertTrue(1 === preg_match('#[1-6]( [1-6])+#', $generated));
    }
}
