<?php
declare(strict_types = 1);
namespace Klapuch\Validation;

/**
 * Rule for satisfying allowed length
 */
final class LengthRule implements Rule {
	private $length;

	public function __construct(int $length) {
		$this->length = $length;
	}

	public function satisfied($subject): bool {
		return mb_strlen($subject, 'UTF-8') === $this->length;
	}

	public function apply($subject): void {
		if(!$this->satisfied($subject)) {
			throw new \UnexpectedValueException(
				sprintf(
					'Subject is not %d characters long',
					$this->length
				)
			);
		}
	}
}