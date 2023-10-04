<?php

declare(strict_types=1);

namespace App;

require_once('vendor/autoload.php');

$player = new Player('Ada Lovelace');
$deck = new Deck();

$player->addCard($deck->drawCard());
$player->addCard($deck->drawCard());
$player->addCard($deck->drawCard());

echo $player->showHand() . PHP_EOL;
