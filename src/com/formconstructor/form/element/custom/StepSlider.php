<?php

namespace com\formconstructor\form\element\custom;

use com\formconstructor\form\element\ElementType;
use com\formconstructor\form\element\SelectableElement;

class StepSlider extends CustomElement {

    private int $defaultIndex;

    private array $options = [];
    private array $elements = [];

    private int $selectedIndex;

    public function __construct(
        string $name = "",
        array $elements = [],
        int $defaultIndex = 0
    ) {
        parent::__construct($name, ElementType::STEP_SLIDER);
        $this->addSteps($elements);
        $this->defaultIndex = $defaultIndex;
    }

    public function addStep(SelectableElement $element): self {
        $element->setIndex(count($this->elements));
        $this->elements[] = $element;
        $this->options[] = $element->getName();
        return $this;
    }

    public function addSteps(array $elements): self {
        foreach ($elements as $element) $this->addStep($element);
        return $this;
    }

    public function addText(string $name): self {
        return $this->addStep(new SelectableElement($name, null));
    }

    public function setDefaultIndex(int $defaultIndex): self {
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

        if (empty($this->elements) || $this->selectedIndex < 0 || (count($this->elements) == 1 && $this->selectedIndex == 1)) {
            return true;
        }

        return $this->selectedIndex < count($this->elements);
    }

    public function jsonSerialize() : array{
        return [
            "type" => $this->getType(),
            "text" => $this->getName(),
            "steps" => $this->options,
            "default" => $this->defaultIndex
        ];
    }
}