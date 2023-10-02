<?php

declare(strict_types=1);

require_once('vendor/autoload.php');

$card = new Card();

$card->suit = '♠';
$card->value = 'jack';
echo $card->show() . PHP_EOL;

$card->suit = '♦';
$card->value = 'jack';
echo $card->show() . PHP_EOL;

$card->suit = '♦';
$card->value = 5;
echo $card->show() . PHP_EOL;
