<?php

declare(strict_types=1);

namespace App;

class Card
{
    private Suit $suit;
    private Rank $rank;

    public function __construct(
        string|Suit $suit,
        int|string|Rank $rank
    ) {
        $this->suit = match (gettype($suit)) {
            'string' => Suit::fromString($suit),
            'object' => $suit
        };

        $this->rank = match (gettype($rank)) {
            'string', 'integer' => Rank::from("$rank"),
            'object' => $rank
        };
    }

    public function show(): string
    {
        return "{$this->suit->value} {$this->rank->value}";
    }

    public function getScore(): int
    {
        return $this->rank->getWorth();
    }
}
