<?php

namespace com\formconstructor\form\element\custom;

use com\formconstructor\form\element\ElementType;

class Slider extends CustomElement {

    private float $defaultValue;

    private float $min;
    private float $max;
    private float $step;

    private float $value = -1;

    public function __construct(
        string $name = "",
        float $min = 0.0,
        float $max = 100.0,
        float $step = 1.0,
        float $defaultValue = -1.0
    ) {
        parent::__construct($name, ElementType::SLIDER);
        $this->min = max($min, 0.0);
        $this->max = max($max, $this->min);
        $this->defaultValue = $defaultValue;
        if ($step > 0) {
            $this->step = $step;
        }
    }

    public function getDefaultValue(): float {
        return $this->defaultValue;
    }

    public function setDefaultValue(float $defaultValue): self {
        $this->defaultValue = $defaultValue;
        return $this;
    }

    public function getMin(): float {
        return $this->min;
    }

    public function setMin(float $min): self {
        $this->min = $min;
        return $this;
    }

    public function getMax(): float {
        return $this->max;
    }

    public function setMax(float $max): self {
        $this->max = $max;
        return $this;
    }

    public function getStep(): float {
        return $this->step;
    }

    public function setStep(float $step): self {
        $this->step = $step;
        return $this;
    }

    public function getValue(): int {
        return $this->value;
    }

    public function setValue(float $value): self {
        $this->value = $value;
        return $this;
    }

    public function respond(mixed $data): bool {
        $this->value = (float) $data;
        return $this->value >= $this->min && $this->value <= $this->max;
    }

    public function jsonSerialize() : array{
        return [
            "type" => $this->getType(),
            "text" => $this->getName(),
            "min" => $this->min,
            "max" => $this->max,
            "step" => $this->step,
            "default" => $this->defaultValue
        ];
    }
}