<?php

namespace com\formconstructor\form\element\custom\validator;

class RegexValidator extends Validator {

    private string $regex;

    public function __construct(string $name, string $regex) {
        parent::__construct($name);
        $this->regex = $regex;
    }

    public function validate(string $input): void {
        $this->setValidated(preg_match($this->regex, $input) === 1);
    }
}