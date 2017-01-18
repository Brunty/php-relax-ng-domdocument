<?php

namespace Brunty;

class DOMDocument extends \DOMDocument
{

    /**
     * {@inheritdoc}
     */
    public function relaxNGValidate($filename)
    {
        set_error_handler(
            function ($errNumber, $errString) {
            }
        );
        $result = parent::relaxNGValidate($filename);
        restore_error_handler();

        return $result;
    }

    /**
     * {@inheritdoc}
     */
    public function relaxNGValidateSource($string)
    {
        set_error_handler(
            function ($errNumber, $errString) {
            }
        );
        $result = parent::relaxNGValidateSource($string);
        restore_error_handler();

        return $result;
    }
}
