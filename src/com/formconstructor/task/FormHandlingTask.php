<?php

namespace com\formconstructor\task;

use com\formconstructor\event\PlayerFormCloseEvent;
use com\formconstructor\form\CloseableForm;
use com\formconstructor\form\Form;
use com\formconstructor\form\response\CustomFormResponse;
use com\formconstructor\form\response\FormResponse;
use com\formconstructor\form\response\ModalFormResponse;
use com\formconstructor\form\response\SimpleFormResponse;
use pocketmine\player\Player;

// TODO async handing
class FormHandlingTask {

    private ?FormResponse $response;
    private Form $form;
    private Player $player;

    public function __construct(?FormResponse $response, Form $form, Player $player) {
        $this->response = $response;
        $this->form = $form;
        $this->player = $player;
    }

    public function onRun(): void {
        if ($this->response === null && $this->form instanceof CloseableForm) {
            $closeHandler = $this->form->getCloseHandler();

            $event = new PlayerFormCloseEvent($this->player, $this->form);
            $event->call();

            if ($closeHandler !== null) $closeHandler($this->player);
            return;
        }

        if ($this->response instanceof ModalFormResponse) {
            $this->response->handle($this->player);
            return;
        }

        if ($this->response instanceof SimpleFormResponse) {
            $this->response->handle($this->player);
            return;
        }

        if ($this->response instanceof CustomFormResponse) {
            $this->response->handle($this->player);
        }
    }
}