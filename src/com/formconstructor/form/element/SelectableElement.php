<?php

namespace com\formconstructor\form\element;

class SelectableElement {

    private string $name;
    private mixed $value;
    private int $index = -1;

    public function __construct(string $name, mixed $value = null) {
        $this->name = $name;
        $this->value = $value;
    }

    public function getName(): string {
        return $this->name;
    }

    public function getValue(): mixed {
        return $this->value;
    }

    public function getIndex(): int {
        return $this->index;
    }

    public function setIndex(int $index): void {
        $this->index = $index;
    }

    public function __toString(): string {
        return "SelectableElement(name: " . $this->name . ", value: " . $this->value . ", index: " . $this->index . ")";
    }
}