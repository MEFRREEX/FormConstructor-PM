<?php

namespace com\formconstructor\form\element\custom;

use com\formconstructor\form\element\ElementType;
use com\formconstructor\form\element\SelectableElement;

class Dropdown extends CustomElement {

    private int $defaultIndex;

    private array $options = [];
    private array $elements = [];

    private int $selectedIndex;

    public function __construct(
        string $name = "",
        array $elements = [],
        int $defaultIndex = 0
    ) {
        parent::__construct($name, ElementType::DROPDOWN);
        $this->addElements($elements);
        $this->defaultIndex = $defaultIndex;
    }

    public function addElement(SelectableElement $element): Dropdown {
        $element->setIndex(count($this->elements));
        $this->elements[] = $element;
        $this->options[] = $element->getName();
        return $this;
    }

    public function addElements(array $elements): Dropdown {
        foreach ($elements as $element) $this->addElement($element);
        return $this;
    }

    public function addText(string $name): Dropdown {
        return $this->addElement(new SelectableElement($name, null));
    }

    public function setDefaultIndex(int $defaultIndex): Dropdown {
        $this->defaultIndex = $defaultIndex;
        return $this;
    }

    public function getDefaultIndex(): int {
        return $this->defaultIndex;
    }

    public function getElements(): array {
        return $this->elements;
    }

    public function getSelectedIndex(): int {
        return $this->selectedIndex;
    }

    public function getDefault(): ?SelectableElement {
        return empty($this->elements) ? null : $this->elements[$this->defaultIndex];
    }

    public function getValue(): ?SelectableElement {
        return empty($this->elements) ? null : $this->elements[$this->selectedIndex];
    }

    public function respond(mixed $data): bool {
        $this->selectedIndex = (int) $data;
        return !empty($this->elements) && $this->selectedIndex >= 0 && $this->selectedIndex < count($this->elements);
    }

    public function jsonSerialize() : array{
        return [
            "type" => $this->getType(),
            "text" => $this->getName(),
            "options" => $this->options,
            "default" => $this->defaultIndex
        ];
    }
}