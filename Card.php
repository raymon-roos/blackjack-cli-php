<?php

declare(strict_types=1);

class Card
{
	private string $suit;
	private string $value;

	private const SUITS = [
		'clubs'    => '♣',
		'diamonds' => '♦',
		'hearts'   => '♥',
		'spades'   => '♠',
	];

	private const VALUES = [
		'ace'   => 'A',
		'two'   => '2',
		'three' => '3',
		'four'  => '4',
		'five'  => '5',
		'six'   => '6',
		'seven' => '7',
		'eight' => '8',
		'nine'  => '9',
		'ten'   => '10',
		'jack'  => 'J',
		'queen' => 'Q',
		'king'  => 'K',
	];

	public function __construct(
		string|Suit $suit,
		int|string|Value $value
	) {
		$this->suit = $this->validateSuit($suit);
		$this->value = $this->validateValue($value);
	}

	public function show(): string
	{
		return "{$this->suit} {$this->value}";
	}

	private function validateSuit(string $suit): string
	{
		return self::SUITS[$suit] ?? throw new InvalidArgumentException();
	}

	private function validateValue(string $suit): string
	{
		return self::VALUES[$suit] ?? throw new InvalidArgumentException();
	}
}
