<?php
declare(strict_types = 1);
namespace Klapuch\Validation;

interface Rule {
	/**
	 * Is the rule satisfied by the given subject?
	 * @param mixed $subject
	 * @return bool
	 */
	public function satisfied($subject): bool;
}
