<?php

declare(strict_types=1);

namespace com\formconstructor;

use pocketmine\plugin\PluginBase;

class FormConstructor extends PluginBase {

    private static FormConstructor $instance;

    public function onLoad(): void {
        self::$instance = $this;
    }

    public static function getInstance(): self {
        return self::$instance;
    }
}
