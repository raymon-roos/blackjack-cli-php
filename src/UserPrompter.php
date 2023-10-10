<?php

declare(strict_types=1);

namespace App;

class UserPrompter
{
	public function promptForPlayerNames(): ?array
	{
		$prompt = <<<prompt

			Type "r(eady)" or leave empty to start the game

			Please enter your name
			>
			prompt;

		while ($input = readline($prompt)) {
			if (empty($input) || $this->inputMatchesKeywords($input, ['r', 'ready'])) {
				break;
			}

			$result[] = $input;
		}

		return $result ?? null;
	}

	public function promptForPlayerToDrawCard(): bool
	{
		$prompt = <<<PROMPT

			Do you want to draw another card?
			Type "h(it)/y(es)" to draw another card, s(tand)/n(o) or leave empty to end your turn
			>
			PROMPT;

		while ($input = readline($prompt)) {
			if ($this->inputMatchesKeywords($input, ['s', 'stand', 'n', 'no'])) {
				return false;
			}

			if ($this->inputMatchesKeywords($input, ['h', 'hit', 'y', 'yes'])) {
				return true;
			}
		}

		return false;
	}

	private function inputMatchesKeywords(string $input, array $keywords): bool
	{
		return in_array(strtolower(trim($input)), $keywords);
	}
}
