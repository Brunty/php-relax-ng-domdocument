# Brunty\DOMDocument

[![Build Status](https://travis-ci.org/Brunty/php-relax-ng-domdocument.svg?branch=master)](https://travis-ci.org/Brunty/php-relax-ng-domdocument)

This class is just a little helper to remove error handling when using `DOMDocument::relaxNGValidate` and `DOMDocument::relaxNGValidateSource` as by default, PHP warnings are generated when validation fails.

## Compatibility

* PHP 5.6 and above

## Installation

`composer require brunty/relax-ng-domdocument`

## Usage

The class extents `\DOMDocument` and the method calls are compatible with the parent class.

```php
$document = new \Brunty\DOMDocument;
$document->load('my-file.xml');

$result = $document->relaxNGValidate('my-schema.rng');
// or 
$result = $document->relaxNGValidateSource(file_get_contents('my-schema.rng'));

// $result will be true / false depending on whether the document validated
```

You can get the warnings that came up during validation by using the `getValidationWarnings()` method, it'll return an array of the warning messages generated.

```php
$document = new \Brunty\DOMDocument;
$document->load('my-invalid-file.xml');

$result = $document->relaxNGValidate('my-schema.rng');

$warnings = $document->getValidationWarnings();
```

## Contributing

Although this project is small, openness and inclusivity are taken seriously. To that end the following code of conduct has been adopted.

[Contributor Code of Conduct](CONTRIBUTING.md)
