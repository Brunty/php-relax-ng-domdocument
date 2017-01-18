<?php

namespace Brunty;

class DOMDocument extends \DOMDocument
{

    /**
     * @var array
     */
    private $validationWarnings = [];

    /**
     * {@inheritdoc}
     */
    public function relaxNGValidate($filename)
    {
        $this->setErrorHandler();
        $result = parent::relaxNGValidate($filename);
        restore_error_handler();

        return $result;
    }

    /**
     * {@inheritdoc}
     */
    public function relaxNGValidateSource($string)
    {
        $this->setErrorHandler();
        $result = parent::relaxNGValidateSource($string);
        restore_error_handler();

        return $result;
    }

    /**
     * @return array
     */
    public function getValidationWarnings()
    {
        return $this->validationWarnings;
    }

    private function setErrorHandler()
    {
        set_error_handler(
            function ($errNumber, $errString) {
                $this->validationWarnings[] = $errString;
            }
        );
    }
}
