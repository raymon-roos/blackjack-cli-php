<?php

declare(strict_types=1);

namespace App;

class UserPrompter
{
	public function promptForPlayerName(): ?string
	{
		$prompt = <<<prompt

			Type "r(eady)" or leave empty to start the game

			Please enter your name
			>
			prompt;

        $input = readline($prompt);

        if (empty($input) || $this->matchesKeywords($input, ['r', 'ready'])) {
			return null;
        }

		return $input;
	}

	public function promptForPlayerToDrawCard(): bool
	{
		$prompt = <<<PROMPT

			Do you want to draw another card?
			Type "h(it)/y(es)" to draw another card, s(tand)/n(o) or leave empty to end your turn
			>
			PROMPT;

		while ($input = readline($prompt)) {
			if ($this->matchesKeywords($input, ['s', 'stand', 'n', 'no'])) {
				return false;
			}

			if ($this->matchesKeywords($input, ['h', 'hit', 'y', 'yes'])) {
				return true;
			}
		}

		return false;
	}

	private function matchesKeywords(string $input, array $keywords): bool
	{
		return in_array(strtolower(trim($input)), $keywords);
	}
}
