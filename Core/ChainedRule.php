<?php
declare(strict_types = 1);
namespace Klapuch\Validation;

/**
 * Chained rule
 */
final class ChainedRule extends Rules {
	public function apply($subject): void {
		foreach($this->rules as $rule)
			$rule->apply($subject);
	}
}