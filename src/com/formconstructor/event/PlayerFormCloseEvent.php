<?php

namespace com\formconstructor\event;

use com\formconstructor\form\Form;
use pocketmine\player\Player;

class PlayerFormCloseEvent extends FormEvent {

    private Player $player;

    public function __construct(Player $player, Form $form) {
        parent::__construct($form);
        $this->player = $player;
    }

    public function getPlayer(): Player {
        return $this->player;
    }
}