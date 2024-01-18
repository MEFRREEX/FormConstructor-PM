<?php

namespace com\formconstructor\event;

use com\formconstructor\form\Form;
use pocketmine\event\Cancellable;
use pocketmine\event\CancellableTrait;
use pocketmine\event\Event;

abstract class FormEvent extends Event implements Cancellable {
    use CancellableTrait;

    private Form $form;

    public function __construct(Form $form) {
        $this->form = $form;
    }

    public function getForm(): Form {
        return $this->form;
    }
}