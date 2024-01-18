<?php

namespace com\formconstructor\event;

use com\formconstructor\form\Form;
use pocketmine\player\Player;

class PlayerFormSendEvent extends FormEvent {

    private Player $player;
    private bool $async;

    public function __construct(Player $player, Form $form, bool $async) {
        parent::__construct($form);
        $this->player = $player;
        $this->async = $async;
    }

    public function getPlayer(): Player {
        return $this->player;
    }

    public function isAsync(): bool {
        return $this->async;
    }

    public function setAsync(bool $async): void {
        $this->async = $async;
    }
}