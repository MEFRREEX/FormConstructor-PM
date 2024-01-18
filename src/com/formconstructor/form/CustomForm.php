<?php

namespace com\formconstructor\form;

use Closure;
use com\formconstructor\form\element\custom\CustomElement;
use com\formconstructor\form\element\custom\Label;
use com\formconstructor\form\element\custom\validator\IValidator;
use com\formconstructor\form\response\CustomFormResponse;
use com\formconstructor\form\response\FormResponse;
use pocketmine\player\Player;

class CustomForm extends CloseableForm {

    private string $title;

    private array $elements = [];

    private bool $validated = true;

    private ?Closure $handler;
    private ?CustomFormResponse $response = null;

    public function __construct(string $title = "", ?Closure $handler = null) {
        parent::__construct(FormType::CUSTOM);
        $this->title = $title;
        $this->handler = $handler;
    }

    public function getTitle(): string {
        return $this->title;
    }

    public function setTitle(string $title): self {
        $this->title = $title;
        return $this;
    }

    public function addContent(string $addition): self {
        return $this->addElement(null, new Label($addition));
    }

    public function addElement(?string $elementId, CustomElement $element): self {
        $element->setElementId($elementId);
        $this->elements[] = $element;
        return $this;
    }

    public function isValidated(): bool {
        return $this->validated;
    }

    public function setHandler(Closure $handler): self {
        $this->handler = $handler;
        return $this;
    }

    public function getResponse(): ?FormResponse {
        return $this->response;
    }

    public function setResponse(mixed $data): void {
        if ($data === null) {
            return;
        }

        foreach ($this->elements as $i => $element) {
            if (!$element->respond($data[$i])) {
                $this->response = new CustomFormResponse(
                    function (Player $player, CustomFormResponse $response) {
                        $this->send($player);
                    },
                    $this->elements,
                    $this
                );
                return;
            }

            if ($element instanceof IValidator && $this->validated && !$element->isValidated()) {
                $this->validated = false;
            }
        }

        foreach ($this->elements as $index => $element) {
            $element->setIndex($index);
        }

        $this->response = new CustomFormResponse($this->handler, $this->elements, $this);
    }

    public function jsonSerialize() : array{
        return [
            "type" => $this->getType(),
            "title" => $this->title,
            "content" => $this->elements
        ];
    }
}