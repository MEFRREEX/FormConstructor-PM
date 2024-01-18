<?php

namespace com\formconstructor\form\element;

enum ElementType: string implements \JsonSerializable {
    case DROPDOWN = 'dropdown';
    case INPUT = 'input';
    case LABEL = 'label';
    case SLIDER = 'slider';
    case STEP_SLIDER = 'step_slider';
    case TOGGLE = 'toggle';

    public function jsonSerialize(): string {
        return $this->value;
    }
}