<?php

namespace Brunty\Tests\DOMDocumentTest;

use Brunty\DOMDocument;

class DOMDocumentTest extends \PHPUnit_Framework_TestCase
{

    /** @test */
    public function it_extends_dom_document()
    {
        $document = new DOMDocument;

        self::assertInstanceOf(\DOMDocument::class, $document);
    }

    /** @test */
    public function it_suppresses_the_warnings_generated_when_invalid_xml_is_supplied_for_validation()
    {
        $document = $this->getDomDocument();

        ob_start();
        $result = $document->relaxNGValidate(__DIR__ . '/resources/relaxng/validation.rng');
        $output = ob_get_contents();
        ob_end_clean();

        self::assertEquals('', $output);
        self::assertFalse($result);
    }

    /** @test */
    public function it_suppresses_the_warnings_generated_when_invalid_xml_is_supplied_for_validation_from_source()
    {
        $document = $this->getDomDocument();

        ob_start();
        $result = $document->relaxNGValidateSource(file_get_contents(__DIR__ . '/resources/relaxng/validation.rng'));
        $output = ob_get_contents();
        ob_end_clean();

        self::assertEquals('', $output);
        self::assertFalse($result);
    }

    /** @test */
    public function it_replaces_the_error_handler_when_invalid_xml_is_supplied_for_validation()
    {
        $document = $this->getDomDocument();

        $standardDocument = $this->getStandardDomDocument();

        $this->setHandler();

        ob_start();
        $document->relaxNGValidate(__DIR__ . '/resources/relaxng/validation.rng');
        $standardDocument->relaxNGValidate(__DIR__ . '/resources/relaxng/validation.rng');
        $output = ob_get_contents();
        ob_end_clean();

        self::assertEquals(
            'DOMDocument::relaxNGValidate(): Expecting an element dob, got nothingDOMDocument::relaxNGValidate(): Invalid sequence in interleaveDOMDocument::relaxNGValidate(): Element member failed to validate content',
            $output
        );
    }

    /** @test */
    public function it_replaces_the_error_handler_when_invalid_xml_is_supplied_for_validation_from_source()
    {
        $document = $this->getDomDocument();
        $standardDocument = $this->getStandardDomDocument();

        $this->setHandler();

        ob_start();
        $document->relaxNGValidateSource(file_get_contents(__DIR__ . '/resources/relaxng/validation.rng'));
        $standardDocument->relaxNGValidateSource(file_get_contents(__DIR__ . '/resources/relaxng/validation.rng'));
        $output = ob_get_contents();
        ob_end_clean();

        self::assertEquals(
            'DOMDocument::relaxNGValidateSource(): Expecting an element dob, got nothingDOMDocument::relaxNGValidateSource(): Invalid sequence in interleaveDOMDocument::relaxNGValidateSource(): Element member failed to validate content',
            $output
        );
    }

    /** @test */
    public function it_captures_the_validation_warnings_when_invalid_xml_is_supplied_for_validation()
    {
        $document = $this->getDomDocument();

        $this->setHandler();

        $document->relaxNGValidate(__DIR__ . '/resources/relaxng/validation.rng');

        $expectedWarnings = [
            'DOMDocument::relaxNGValidate(): Expecting an element dob, got nothing',
            'DOMDocument::relaxNGValidate(): Invalid sequence in interleave',
            'DOMDocument::relaxNGValidate(): Element member failed to validate content'
        ];

        self::assertEquals($expectedWarnings, $document->getValidationWarnings());
    }

    /** @test */
    public function it_captures_the_validation_warnings_when_invalid_xml_is_supplied_for_validation_from_source()
    {
        $document = $this->getDomDocument();

        $this->setHandler();

        $document->relaxNGValidateSource(file_get_contents(__DIR__ . '/resources/relaxng/validation.rng'));

        $expectedWarnings = [
            'DOMDocument::relaxNGValidateSource(): Expecting an element dob, got nothing',
            'DOMDocument::relaxNGValidateSource(): Invalid sequence in interleave',
            'DOMDocument::relaxNGValidateSource(): Element member failed to validate content'
        ];

        self::assertEquals($expectedWarnings, $document->getValidationWarnings());
    }

    /** @test */
    public function it_resets_the_validation_warnings_when_invalid_xml_is_supplied_for_validation_from_source_twice()
    {
        $document = $this->getDomDocument();

        $this->setHandler();

        $document->relaxNGValidateSource(file_get_contents(__DIR__ . '/resources/relaxng/validation.rng'));
        $document->relaxNGValidateSource(file_get_contents(__DIR__ . '/resources/relaxng/validation.rng'));

        $expectedWarnings = [
            'DOMDocument::relaxNGValidateSource(): Expecting an element dob, got nothing',
            'DOMDocument::relaxNGValidateSource(): Invalid sequence in interleave',
            'DOMDocument::relaxNGValidateSource(): Element member failed to validate content'
        ];

        self::assertEquals($expectedWarnings, $document->getValidationWarnings());
    }


    /** @test */
    public function it_resets_the_validation_warnings_when_invalid_xml_is_supplied_for_validation_twice()
    {
        $document = $this->getDomDocument();

        $this->setHandler();

        $document->relaxNGValidate(__DIR__ . '/resources/relaxng/validation.rng');
        $document->relaxNGValidate(__DIR__ . '/resources/relaxng/validation.rng');

        $expectedWarnings = [
            'DOMDocument::relaxNGValidate(): Expecting an element dob, got nothing',
            'DOMDocument::relaxNGValidate(): Invalid sequence in interleave',
            'DOMDocument::relaxNGValidate(): Element member failed to validate content'
        ];

        self::assertEquals($expectedWarnings, $document->getValidationWarnings());
    }

    private function setHandler()
    {
        set_error_handler(
            function ($errNumber, $errString) {
                echo $errString;
            }
        );
    }

    /**
     * @return DOMDocument
     */
    private function getDomDocument()
    {
        $document = new DOMDocument;
        $document->load(__DIR__ . '/resources/xml-document-invalid.xml');

        return $document;
    }

    /**
     * @return \DOMDocument
     */
    private function getStandardDomDocument()
    {
        $standardDocument = new \DOMDocument;
        $standardDocument->load(__DIR__ . '/resources/xml-document-invalid.xml');

        return $standardDocument;
    }
}
