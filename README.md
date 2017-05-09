# Validation
[![Build Status](https://travis-ci.org/klapuch/Validation.svg?branch=master)](https://travis-ci.org/klapuch/Validation)
[![Build status](https://ci.appveyor.com/api/projects/status/n6h16u8r04gh09o1?svg=true)](https://ci.appveyor.com/project/facedown/validation)
[![Coverage Status](https://coveralls.io/repos/github/klapuch/Validation/badge.svg?branch=master)](https://coveralls.io/github/klapuch/Validation?branch=master)

## Documentation
### Installation
`composer require klapuch/validation`
### Usage
#### Single rule
```php
(new EmptyRule())->satified('abc'); // false
(new EmptyRule())->satified(''); // true
(new EmptyRule())->apply('abc'); // \UnexpectedValueException - 'Subject is not empty'
(new FriendlyRule(new EmptyRule(), 'Not empty!'))->apply('abc'); // \UnexpectedValueException - 'Not empty!'
```
#### Chained rule
```php
(new ChainedRule(
	new FriendlyRule(
		new NegateRule(new EmptyRule()),
		'Value can not be empty'
	),
	new LengthRule(10),
	new PassiveRule, // it does nothing
	new EmailRule(),
))->apply('abc');
```
The above code says that a value can not be empty, length of the value must be exact 10 characters and the value must be email.