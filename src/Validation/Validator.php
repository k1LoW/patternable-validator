<?php

namespace PatternableValidator\Validation;

use Cake\Validation\Validator as CakeValidator;
use Cake\Collection\Collection;
use PatternableValidator\Error\NoValidationPatternException;

class Validator extends CakeValidator
{
    public static $validationPatterns = [];

    /**
     * addPattern
     *
     */
    public function addPattern($field, $pattern)
    {
        $pattern = new Collection((array)$pattern);
        $field = $this->field($field);
        $validationPatterns = self::$validationPatterns;
        $pattern->each(function($key) use ($field, $validationPatterns) {
            if (empty($validationPatterns[$key])) {
                throw new NoValidationPatternException();
            }
            $rules = new Collection($validationPatterns[$key]);
            $rules->each(function($rule, $name) use ($field) {
                $field->add($name, $rule);
            });
        });
        return $this;
    }
}
