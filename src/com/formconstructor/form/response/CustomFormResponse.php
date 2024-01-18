<?php

namespace com\formconstructor\form\response;

use Closure;
use com\formconstructor\form\CustomForm;
use com\formconstructor\form\element\custom\CustomElement;
use com\formconstructor\form\element\custom\Dropdown;
use com\formconstructor\form\element\custom\Input;
use com\formconstructor\form\element\custom\Label;
use com\formconstructor\form\element\custom\Slider;
use com\formconstructor\form\element\custom\StepSlider;
use com\formconstructor\form\element\custom\Toggle;
use com\formconstructor\form\element\custom\validator\IValidator;
use com\formconstructor\form\element\ElementType;
use pocketmine\player\Player;

class CustomFormResponse extends FormResponse {

    private array $elements;
    private CustomForm $form;

    public function __construct(?Closure $handler, array $elements, CustomForm $form) {
        parent::__construct($handler, "");
        $this->elements = $elements;
        $this->form = $form;
    }

    public function getAllElements(): array {
        return $this->elements;
    }

    public function getForm(): CustomForm {
        return $this->form;
    }

    public function containsId(string $elementId): bool {
        foreach ($this->elements as $element) {
            if ($element->getElementId() === $elementId) {
                return true;
            }
        }
        return false;
    }

    private function getElementByIndex(int $index): ?CustomElement {
        return $this->elements[$index];
    }

    private function getElement(string $elementId, ElementType $type): mixed {
        foreach ($this->elements as $element) {
            if ($element->getElementId() === $elementId && $element->getType() === $type) {
                return $element;
            }
        }
        return null;
    }

    private function getElements(ElementType $type): array {
        return array_filter($this->elements, fn(CustomElement $element) => $element->getType() === $type);
    }

    public function getLabel(string $elementId): ?Label {
        return $this->getElement($elementId, ElementType::LABEL);
    }

    public function getLabels(): array {
        return $this->getElements(ElementType::LABEL);
    }

    public function getInput(string $elementId): ?Input {
        return $this->getElement($elementId, ElementType::INPUT);
    }

    public function getInputs(): array {
        return $this->getElements(ElementType::INPUT);
    }

    public function getToggle(string $elementId): ?Toggle {
        return $this->getElement($elementId, ElementType::TOGGLE);
    }

    public function getToggles(): array {
        return $this->getElements(ElementType::TOGGLE);
    }

    public function getSlider(string $elementId): ?Slider {
        return $this->getElement($elementId, ElementType::SLIDER);
    }

    public function getSliders(): array {
        return $this->getElements(ElementType::SLIDER);
    }

    public function getStepSlider(string $elementId): ?StepSlider {
        return $this->getElement($elementId, ElementType::STEP_SLIDER);
    }

    public function getStepSliders(): array {
        return $this->getElements(ElementType::STEP_SLIDER);
    }

    public function getDropdown(string $elementId): ?Dropdown {
        return $this->getElement($elementId, ElementType::DROPDOWN);
    }

    public function getDropdowns(): array {
        return $this->getElements(ElementType::DROPDOWN);
    }

    public function isValidated(): bool {
        return $this->form->isValidated();
    }

    public function getValidatorErrors(): array {
        $errors = [];

        foreach ($this->elements as $element) {
            if ($element instanceof IValidator) {
                foreach ($element->getValidators() as $validator) {
                    if (!$validator->isValidated()) {
                        $errors[] = $validator->getName();
                    }
                }
            }
        }

        return $errors;
    }

    public function handle(Player $player): void {
        if ($this->getHandler() !== null) {
            $this->getHandler()($player, $this);
        }
    }
}