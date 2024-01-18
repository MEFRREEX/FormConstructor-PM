<?php

namespace com\formconstructor\form\element\custom\validator;

interface IValidator {

    public function validate(): void;

    public function isValidated(): bool;

    public function getValidators(): array;

    public function addValidator(Validator $validator): IValidator;
}