<?php

namespace com\formconstructor\form\element\custom;

use com\formconstructor\form\element\custom\validator\IValidator;
use com\formconstructor\form\element\custom\validator\Validator;
use com\formconstructor\form\element\ElementType;

class Input extends CustomElement implements IValidator {

    private string $placeholder;
    private string $defaultValue;
    private string $value;
    private bool $trim = false;

    private array $validators = [];

    public function __construct(
        string $name = "",
        string $placeholder = "",
        string $defaultValue = ""
    ) {
        parent::__construct($name, ElementType::INPUT);
        $this->placeholder = $placeholder;
        $this->defaultValue = $defaultValue;
    }

    public function getPlaceholder(): string {
        return $this->placeholder;
    }

    public function setPlaceholder(string $placeholder): self {
        $this->placeholder = $placeholder;
        return $this;
    }

    public function getDefaultValue(): string {
        return $this->defaultValue;
    }

    public function setDefaultValue(string $defaultValue): self {
        $this->defaultValue = $defaultValue;
        return $this;
    }

    public function getValue(): string {
        return $this->value;
    }

    public function setValue(string $value): self {
        $this->value = $value;
        return $this;
    }

    public function isTrim(): bool {
        return $this->trim;
    }

    public function setTrim(bool $trim): self {
        $this->trim = $trim;
        return $this;
    }

    public function validate(): void {
        foreach ($this->validators as $validator) {
            $validator->validate($this->value);
        }
    }

    public function isValidated(): bool {
        return array_reduce(
            $this->validators,
            fn($carry, $validator) => $carry && $validator->isValidated(),
            true
        );
    }

    public function getValidators(): array {
        return $this->validators;
    }

    public function addValidator(Validator $validator): self {
        $this->validators[] = $validator;
        return $this;
    }

    public function respond(mixed $data): bool {
        $this->value = $this->trim ? trim($data) : $data;
        $this->validate();
        return true;
    }

    public function jsonSerialize() : array {
        return [
            "type" => $this->getType(),
            "text" => $this->getName(),
            "placeholder" => $this->placeholder,
            "default" => $this->defaultValue
        ];
    }
}