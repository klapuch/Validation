<?php
declare(strict_types = 1);

namespace Klapuch\Validation;

/**
 * Fake
 */
final class FakeRule implements Rule {
	/** @var bool|null */
	private $satisfied;

	/** @var \Throwable|null */
	private $exception;

	public function __construct(
		?bool $satisfied = null,
		?\Throwable $exception = null
	) {
		$this->satisfied = $satisfied;
		$this->exception = $exception;
	}

	/**
	 * @param mixed $subject
	 * @return bool
	 */
	public function satisfied($subject): bool {
		return $this->satisfied;
	}

	/**
	 * @param mixed $subject
	 * @return mixed
	 */
	public function apply($subject) {
		if ($this->exception !== null) {
			throw $this->exception;
		}
		return $subject;
	}
}
