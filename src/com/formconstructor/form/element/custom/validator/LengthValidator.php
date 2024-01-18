<?php

namespace com\formconstructor\form\element\custom\validator;

class LengthValidator extends Validator {

    private int $min;
    private int $max;

    public function __construct(string $name, int $min, int $max) {
        parent::__construct($name);
        $this->min = $min;
        $this->max = $max;
    }

    public function validate(string $input): void {
        $this->setValidated(($this->min === -1 || strlen($input) >= $this->min) && ($this->max === -1 || $this->max >= strlen($input)));
    }
}