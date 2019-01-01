<?php
declare(strict_types = 1);

namespace Klapuch\Validation;

/**
 * Allowing one of passed set
 */
final class OneOfRule implements Rule {
	/** @var mixed[] */
	private $set;

	public function __construct(array $set) {
		$this->set = $set;
	}

	/**
	 * @param mixed $subject
	 * @return bool
	 */
	public function satisfied($subject): bool {
		return in_array($subject, $this->set, true);
	}

	/**
	 * @param mixed $subject
	 * @return mixed
	 */
	public function apply($subject) {
		if (!$this->satisfied($subject)) {
			throw new \UnexpectedValueException(
				sprintf(
					'%s set do not contain "%s" as type %s',
					implode(
						', ',
						array_map(
							static function(string $one): string {
								return sprintf('"%s"', $one);
							},
							$this->set
						)
					),
					$subject,
					gettype($subject)
				)
			);
		}
		return $subject;
	}
}
