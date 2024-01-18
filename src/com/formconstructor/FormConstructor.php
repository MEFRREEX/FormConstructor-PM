<?php

declare(strict_types=1);

namespace com\formconstructor;

use com\formconstructor\form\CustomForm;
use com\formconstructor\form\element\custom\Dropdown;
use com\formconstructor\form\element\custom\Input;
use com\formconstructor\form\element\custom\Slider;
use com\formconstructor\form\element\custom\StepSlider;
use com\formconstructor\form\element\custom\Toggle;
use com\formconstructor\form\element\SelectableElement;
use com\formconstructor\form\element\simple\Button;
use com\formconstructor\form\element\simple\ImageType;
use com\formconstructor\form\response\CustomFormResponse;
use com\formconstructor\form\SimpleForm;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\event\Listener;
use pocketmine\player\Player;
use pocketmine\plugin\PluginBase;

class FormConstructor extends PluginBase implements Listener {

    private static FormConstructor $instance;

    public function onLoad(): void {
        self::$instance = $this;
    }

    public static function getInstance(): self {
        return self::$instance;
    }

    public function onCommand(CommandSender $sender, Command $command, string $label, array $args): bool {
        if ($command->getName() === "test") {
            $form = new SimpleForm("Sample title");
            $form->addContent("New content line");

// Easiest way to add a button
            $form->addButton(new Button("Button", function (Player $pl, Button $b) {
                $pl->sendMessage("Button clicked: " . $b->getName() . " (" . $b->getIndex() . ")");
            }))

                // Button with image
                ->addButton((new Button("Button with image"))
                    ->setImage(ImageType::PATH, "textures/items/diamond"))

                // Another way to add a button
                ->addButton((new Button("Another button"))
                    ->setImage(ImageType::PATH, "textures/blocks/stone")
                    ->onClick(function (Player $pl, Button $b) {
                        $pl->sendMessage("Another button clicked: " . $b->getName() . " (" . $b->getIndex() . ")");
                    }));

// Setting the form close handler
            $form->setCloseHandler(function (Player $pl) {
                $pl->sendMessage("You closed the form!");
            });

            $form->send($sender);
        }
        return true;
    }
}
