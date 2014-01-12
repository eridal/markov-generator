Markov-Generator
===============

Generate pseudo-random texts using Markov chains as input.

# Using from shell
A convenience script is provided. Pass the files you want to use a learn experience, and the script will read them and generate a sentence.
```sh
    $ php markov.php FILE1 FILE2 ....
```

# Using from php
The API is dead simple: first train, then generate.
```php
$markov = new MarkoGenerator();

// train the model
foreach (trainSet() as $sentence)
    $markov->learn($sentence);

// generate a 5-words length sentence
echo $markov->generate(5);
```

# Shakespeare Sonet
This sonet was generated using Shakespeare's Sonets 140 to 157 as trainning input.

    The likeness of a man,
    Or if they have, where is my sin, grounded on
    Not, then love doth well denote,
    Words, and words express
    Random from the truth vainly expressed:
    Give the lie to my love,
    View is pleased to dote.
    Why of two oaths' breach do I accuse thee,
    Whilst her neglected child holds her in chase,
    Sees not till heaven clears.
    With others thou shouldst not abhor my state.
    Spirit a woman coloured ill.
      On that which longer nurseth the disease,
      Triumph in love; flesh stays no farther reason.

To generate another pseudo-random sonet, take a look at the example folder, or simply run:
```sh
$ php examples/shakespeare.php
```
