<?php

namespace PatternableValidator\Error;

use Cake\Core\Exception\Exception;

class NoValidationPatternException extends Exception
{

    /**
     * Constructor
     *
     * @param string $message Message string.
     * @param int $code Code.
     * @param string|null $file File name.
     * @param int|null $line Line number.
     */
    public function __construct($message, $code = 500, $file = null, $line = null)
    {
        parent::__construct($message, $code);
        if ($file) {
            $this->file = $file;
        }
        if ($line) {
            $this->line = $line;
        }
    }
}
