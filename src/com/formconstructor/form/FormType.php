<?php

namespace com\formconstructor\form;

enum FormType: string implements \JsonSerializable {
    case SIMPLE = 'form';
    case MODAL = 'modal';
    case CUSTOM = 'custom_form';

    public function jsonSerialize(): string {
        return $this->value;
    }
}
