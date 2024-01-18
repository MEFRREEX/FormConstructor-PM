<?php

namespace com\formconstructor\form\element;

abstract class FormElement implements \JsonSerializable {

    private string $name;
    private int $index = -1;

    public function __construct(string $name) {
        $this->name = $name;
    }

    public function getName(): string {
        return $this->name;
    }

    public function setName(string $name): self {
        $this->name = $name;
        return $this;
    }

    public function getIndex(): int {
        return $this->index;
    }

    public function setIndex(int $index): void {
        $this->index = $index;
    }

    public abstract function jsonSerialize(): array;
}