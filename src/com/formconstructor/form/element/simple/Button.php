<?php

namespace com\formconstructor\form\element\simple;

use Closure;
use com\formconstructor\form\element\FormElement;

class Button extends FormElement implements \JsonSerializable {

    private ButtonImage $image;
    private ?Closure $handler;

    public function __construct(string $name = "", ?Closure $handler = null) {
        parent::__construct($name);
        $this->handler = $handler;
        $this->image = new ButtonImage();
    }

    public function getImage(): ButtonImage {
        return $this->image;
    }

    public function setImage(ImageType $imageType, string $image): self {
        $this->image = new ButtonImage($imageType, $image);
        return $this;
    }

    public function getHandler(): ?Closure {
        return $this->handler;
    }

    public function onClick(callable $handler): self {
        $this->handler = $handler;
        return $this;
    }

    public function jsonSerialize(): array {
        return [
            "text" => $this->getName(),
            "image" => $this->image
        ];
    }
}