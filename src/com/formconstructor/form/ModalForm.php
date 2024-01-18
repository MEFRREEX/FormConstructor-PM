<?php

namespace com\formconstructor\form;

use Closure;
use com\formconstructor\form\response\FormResponse;
use com\formconstructor\form\response\ModalFormResponse;

class ModalForm extends CloseableForm {

    private string $title;
    private string $content;

    private string $positiveButton;
    private string $negativeButton;

    private ?Closure $handler;
    private ?ModalFormResponse $response = null;

    public function __construct(string $title = "", string $content = "", ?Closure $handler = null) {
        parent::__construct(FormType::MODAL);
        $this->title = $title;
        $this->content = $content;
        $this->handler = $handler;
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

    public function getPositiveButton(): string {
        return $this->positiveButton;
    }

    public function setPositiveButton(string $positiveButton): self {
        $this->positiveButton = $positiveButton;
        return $this;
    }

    public function getNegativeButton(): string {
        return $this->negativeButton;
    }

    public function setNegativeButton(string $negativeButton): self {
        $this->negativeButton = $negativeButton;
        return $this;
    }

    public function setHandler(Closure $handler): self {
        $this->handler = $handler;
        return $this;
    }

    public function getResponse(): ?FormResponse {
        return $this->response;
    }

    public function setResponse(mixed $data): void {
        if ($data !== null && $this->handler !== null) {
            $this->response = new ModalFormResponse($this->handler, $data);
        }
    }

    public function jsonSerialize(): array {
        return [
            "type" => $this->getType(),
            "title" => $this->title,
            "content" => $this->content,
            "button1" => $this->positiveButton,
            "button2" => $this->negativeButton,
        ];
    }
}