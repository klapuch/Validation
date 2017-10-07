<?php
declare(strict_types = 1);
namespace Klapuch\Validation;

/**
 * Rule for making friendly, verbose and comprehensible error message
 */
final class FriendlyRule implements Rule {
	private $origin;
	private $message;

	public function __construct(Rule $origin, string $message) {
		$this->origin = $origin;
		$this->message = $message;
	}

	public function satisfied($subject): bool {
		return $this->origin->satisfied($subject);
	}

	/**
	 * @param mixed $subject
	 * @return mixed
	 */
	public function apply($subject) {
		try {
			return $this->origin->apply($subject);
		} catch (\Throwable $exception) {
			throw new \UnexpectedValueException(
				$this->message,
				$exception->getCode(),
				$exception
			);
		}
	}
}