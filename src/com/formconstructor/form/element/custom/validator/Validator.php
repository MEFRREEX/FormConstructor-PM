<?php

namespace com\formconstructor\form\element\custom\validator;

abstract class Validator {

    private string $name;
    private bool $validated;

    public function __construct(string $name) {
        $this->name = $name;
    }

    public function getName(): string {
        return $this->name;
    }

    public function isValidated(): bool {
        return $this->validated;
    }

    protected function setValidated(bool $validated): void {
        $this->validated = $validated;
    }

    public abstract function validate(string $input);
}