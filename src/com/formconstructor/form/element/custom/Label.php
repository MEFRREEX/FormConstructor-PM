<?php

namespace com\formconstructor\form\element\custom;

use com\formconstructor\form\element\ElementType;

class Label extends CustomElement {

    public function __construct(string $text = "") {
        parent::__construct($text, ElementType::LABEL);
    }

    public function respond(mixed $data): bool {
        return true;
    }

    public function jsonSerialize(): array {
        return [
            "type" => $this->getType(),
            "text" => $this->getName()
        ];
    }
}