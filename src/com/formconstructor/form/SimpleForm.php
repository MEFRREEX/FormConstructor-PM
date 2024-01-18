<?php

namespace com\formconstructor\form;

use com\formconstructor\form\element\simple\Button;
use com\formconstructor\form\response\SimpleFormResponse;

class SimpleForm extends CloseableForm {

    private string $title;
    private string $content;
    private array $buttons = [];

    private ?SimpleFormResponse $response = null;

    public function __construct(string $title = "", string $content = "") {
        parent::__construct(FormType::SIMPLE);
        $this->title = $title;
        $this->content = $content;
    }

    public function getTitle(): string {
        return $this->title;
    }

    public function setTitle(string $title): self {
        $this->title = $title;
        return $this;
    }

    public function getContent(): string {
        return $this->content;
    }

    public function setContent(string $content): self {
        $this->content = $content;
        return $this;
    }

    public function addContent(string $addition): self {
        $this->content .= $addition;
        return $this;
    }

    public function getButtons(): array {
        return $this->buttons;
    }

    public function setButtons(array $buttons): self {
        $this->buttons = $buttons;
        return $this;
    }

    public function addButton(Button $button): self {
        $this->buttons[] = $button;
        return $this;
    }

    public function getResponse(): ?SimpleFormResponse {
        return $this->response;
    }

    public function setResponse(mixed $data): void {
        if ($data === null) {
            return;
        }

        if (!is_int($data)) {
            return;
        }

        if ($data < 0 || $data >= count($this->buttons)) {
            $invalidButton = new Button("Invalid", fn($pl, $b) => $this->send($pl));
            $this->response = new SimpleFormResponse($invalidButton);
            return;
        }

        foreach ($this->buttons as $index => $button) {
            $button->setIndex($index);
        }

        $this->response = new SimpleFormResponse($this->buttons[$data]);
    }

    public function jsonSerialize(): array {
        return [
            "type" => $this->getType(),
            "title" => $this->title,
            "content" => $this->content,
            "buttons" => $this->buttons
        ];
    }
}