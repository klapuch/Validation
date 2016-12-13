<?php
declare(strict_types = 1);
namespace Klapuch\Validation;

/**
 * Multiple rules combined together behaving as a single one
 */
final class CombinedRule extends Rules {
	public function apply($subject): void {
		if(!$this->satisfied($subject))
			throw new \UnexpectedValueException('The rule is not applicable');
	}
}