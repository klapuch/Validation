<?php
declare(strict_types = 1);

namespace Klapuch\Validation;

/**
 * Chained rules
 */
final class ChainedRule implements Rule {
	/** @var \Klapuch\Validation\Rule[] */
	private $rules;

	public function __construct(Rule ...$rules) {
		$this->rules = $rules;
	}

	/**
	 * @param mixed $subject
	 * @return bool
	 */
	public function satisfied($subject): bool {
		return array_filter(
			$this->rules,
			static function(Rule $rule) use ($subject): bool {
				return $rule->satisfied($subject) === true;
			}
		) === $this->rules;
	}

	/**
	 * @param mixed $subject
	 * @return mixed
	 */
	public function apply($subject) {
		return array_reduce(
			$this->rules,
			static function($application, Rule $rule) {
				return $rule->apply($application);
			},
			$subject
		);
	}
}
