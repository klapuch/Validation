<?php
declare(strict_types = 1);
namespace Klapuch\Validation;

/**
 * Fake
 */
final class FakeRule implements Rule {
	private $satisfied;
	private $exception;

	public function __construct(
		bool $satisfied = null,
		\Throwable $exception = null
	) {
		$this->satisfied = $satisfied;
		$this->exception = $exception;
	}

	public function satisfied($subject): bool {
		return $this->satisfied;
	}

	public function apply($subject): void {
		if($this->exception !== null) {
			throw $this->exception;
		}
	}
}