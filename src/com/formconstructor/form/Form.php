<?php

namespace com\formconstructor\form;

use pocketmine\player\Player;
use pocketmine\Server;
use pocketmine\form\Form as PMForm;
use com\formconstructor\event\PlayerFormSendEvent;
use com\formconstructor\task\FormHandlingTask;
use com\formconstructor\form\response\FormResponse;
use pocketmine\thread\NonThreadSafeValue;

abstract class Form implements PMForm {

    private FormType $type;
    private bool $async;

    public function __construct(FormType $type) {
        $this->type = $type;
    }

    public function send(Player $player, bool $async = false): void {
        $event = new PlayerFormSendEvent($player, $this, $async);
        $event->call();

        if (!$event->isCancelled()) {
            $this->async = $event->isAsync();
            $player->sendForm($this);
        }
    }

    public function sendAsync(Player $player) {
        $this->send($player, true);
    }

    public function getType(): FormType {
        return $this->type;
    }

    public function isAsync(): bool {
        return $this->async;
    }

    public abstract function setResponse(mixed $data);

    public abstract function getResponse(): ?FormResponse;

    public final function handleResponse(Player $player, $data): void {
        $this->setResponse($data);

        $handler = new FormHandlingTask($this->getResponse(), $this, $player);

        if ($this->async) {
            // TODO async handling
            $handler->onRun();
        } else {
            $handler->onRun();
        }
    }
}