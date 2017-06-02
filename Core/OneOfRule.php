<?php
declare(strict_types = 1);
namespace Klapuch\Validation;

/**
 * Allowing one of passed set
 */
final class OneOfRule implements Rule {
	private $set;

	public function __construct(array $set) {
		$this->set = $set;
	}

	public function satisfied($subject): bool {
		return in_array($subject, $this->set, true);
	}

	public function apply($subject): void {
		if (!$this->satisfied($subject)) {
			throw new \UnexpectedValueException(
				sprintf(
					'%s set do not contain "%s"',
					implode(
						', ',
						array_map(
							function(string $one): string {
								return sprintf('"%s"', $one);
							},
							$this->set
						)
					),
					$subject
				)
			);
		}
	}
}