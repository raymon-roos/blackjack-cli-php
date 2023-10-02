<?php

declare(strict_types=1);

require_once('vendor/autoload.php');

$card = new Card(Suit::spades, Value::jack);

echo $card->show() . PHP_EOL;

// Throws an error
// $card = new Card('schoffels', 13);
