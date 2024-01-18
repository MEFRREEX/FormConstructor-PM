<?php

namespace com\formconstructor\form\element\simple;

enum ImageType: string implements \JsonSerializable {
    case PATH = 'path';
    case URL = 'url';

    public function jsonSerialize(): string {
        return $this->value;
    }
}
