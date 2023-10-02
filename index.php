<?php

declare(strict_types=1);

require_once('vendor/autoload.php');

$card = new Card();

$card->suit = 'clubs';
$card->value = 'jack';

dd($card);
