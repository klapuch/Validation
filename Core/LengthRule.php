<?php
declare(strict_types = 1);

namespace Klapuch\Validation;

/**
 * Rule for satisfying allowed length
 */
final class LengthRule implements Rule {
	/** @var int */
	private $length;

	public function __construct(int $length) {
		$this->length = $length;
	}

	/**
	 * @param string $subject
	 * @return bool
	 */
	public function satisfied($subject): bool {
		return mb_strlen($subject, 'UTF-8') === $this->length;
	}

	/**
	 * @param mixed $subject
	 * @return string
	 */
	public function apply($subject): string {
		if (!$this->satisfied($subject)) {
			throw new \UnexpectedValueException(
				sprintf(
					'Subject is not %d characters long',
					$this->length
				)
			);
		}
		return $subject;
	}
}
