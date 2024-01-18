<?php

namespace com\formconstructor\form\element\custom;

use pocketmine\form\FormValidationException;
use com\formconstructor\form\element\ElementType;

class Toggle extends CustomElement {

    private bool $defaultValue;

    private bool $value;

    public function __construct(string $name = "", bool $defaultValue = false) {
        parent::__construct($name, ElementType::TOGGLE);
        $this->defaultValue = $defaultValue;
    }

    public function getValue(): bool {
        return $this->value;
    }

    public function getDefaultValue(): bool {
        return $this->defaultValue;
    }

    public function setDefaultValue(bool $defaultValue): self {
        $this->defaultValue = $defaultValue;
        return $this;
    }

    public function respond(mixed $data): bool {
        if (!is_bool($data)) {
            throw new FormValidationException();
        }
        $this->value = $data;
        return true;
    }

    public function jsonSerialize(): array {
        return [
            "type" => $this->getType(),
            "text" => $this->getName(),
            "default" => $this->defaultValue
        ];
    }
}