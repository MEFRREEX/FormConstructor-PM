<?php

namespace com\formconstructor\form\element\custom;

use com\formconstructor\form\element\ElementType;
use com\formconstructor\form\element\FormElement;

abstract class CustomElement extends FormElement {

    private ElementType $type;
    private ?string $elementId;

    public function __construct(string $name, ElementType $type) {
        parent::__construct($name);
        $this->type = $type;

    }

    public abstract function respond(mixed $data): bool;

    public function getType(): ElementType {
        return $this->type;
    }

    public function getElementId(): ?string {
        return $this->elementId;
    }

    public function setElementId(?string $elementId): void {
        $this->elementId = $elementId;
    }
}