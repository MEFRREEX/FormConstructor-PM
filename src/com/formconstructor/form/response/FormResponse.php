<?php

namespace com\formconstructor\form\response;

use Closure;
use pocketmine\player\Player;

abstract class FormResponse {

    private ?Closure $handler;
    private ?string $data;

    public function __construct(?Closure $handler, ?string $data) {
        $this->handler = $handler;
        $this->data = $data;
    }

    public function getHandler(): ?Closure {
        return $this->handler;
    }

    public function getData(): ?string {
        return $this->data;
    }

    public abstract function handle(Player $player): void;
}