<?php

declare(strict_types=1);

require_once('vendor/autoload.php');

$card = new BetterCard(BetterSuit::spades, BetterValue::jack);

echo $card->show() . PHP_EOL;

// Throws an error
// $card = new Card('schoffels', 13);
