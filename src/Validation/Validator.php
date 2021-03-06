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
        $validationSet = $this->field($field);
        $validationPatterns = self::$validationPatterns;
        $pattern->each(function($key) use ($field, $validationSet, $validationPatterns) {
            if (empty($validationPatterns[$key])) {
                if (method_exists($this, $key)) {
                    $this->{$key}($field);
                    return;
                }
                throw new NoValidationPatternException('Not found pattern `' . $key . '`');
            }
            $rules = new Collection($validationPatterns[$key]);
            $rules->each(function($rule, $name) use ($validationSet) {
                $validationSet->add($name, $rule);
            });
        });
        return $this;
    }


    /**
     * syntax sugar methods
     *
     */
    public function requirePresenceWhenCreate($field){
        return $this->requirePresence($field, 'create');
    }
    public function requirePresenceWhenUpdate($field){
        return $this->requirePresence($field, 'update');
    }
    public function allowEmptyWhenCreate($field){
        return $this->allowEmpty($field, 'create');
    }
    public function allowEmptyWhenUpdate($field){
        return $this->allowEmpty($field, 'update');
    }
    public function notEmptyWhenCreate($field, $message = null){
        return $this->notEmpty($field, $message, 'create');
    }
    public function notEmptyWhenUpdate($field, $message = null){
        return $this->notEmpty($field, $message, 'update');
    }

}
