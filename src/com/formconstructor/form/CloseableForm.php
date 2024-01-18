<?php

namespace com\formconstructor\form;

use Closure;

abstract class CloseableForm extends Form {

    private ?Closure $closeHandler = null;

    public function __construct(FormType $type) {
        parent::__construct($type);
    }

    public function getCloseHandler(): ?Closure {
        return $this->closeHandler;
    }

    public function setCloseHandler(Closure $closeHandler): self {
        $this->closeHandler = $closeHandler;
        return $this;
    }
}