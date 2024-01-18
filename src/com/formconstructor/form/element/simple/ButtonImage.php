<?php

namespace com\formconstructor\form\element\simple;

class ButtonImage implements \JsonSerializable {

    private ImageType $type;
    private string $path;

    public function __construct(ImageType $type = ImageType::PATH, string $path = "") {
        $this->type = $type;
        $this->path = $path;
    }

    public function getType(): ImageType {
        return $this->type;
    }

    public function setType(ImageType $type): void {
        $this->type = $type;
    }

    public function getPath(): string {
        return $this->path;
    }

    public function setPath(string $path): void {
        $this->path = $path;
    }

    public function jsonSerialize(): array {
        return [
            "type" => $this->type,
            "data" => $this->path,
        ];
    }
}