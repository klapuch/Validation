<?php
declare(strict_types = 1);

namespace Klapuch\Validation;

/**
 * Apply rule only for not null subject
 */
final class IfNotNullRule implements Rule {
	/** @var \Klapuch\Validation\Rule */
	private $origin;

	public function __construct(Rule $origin) {
		$this->origin = $origin;
	}

	/**
	 * @param mixed|null $subject
	 * @return bool
	 */
	public function satisfied($subject): bool {
		if ($subject === null)
			return true;
		return $this->origin->satisfied($subject);
	}

	/**
	 * @param mixed|null $subject
	 * @throws \UnexpectedValueException
	 * @return mixed|null
	 */
	public function apply($subject) {
		if ($subject === null)
			return $subject;
		return $this->origin->apply($subject);
	}
}
