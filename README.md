![logo](https://github.com/MEFRREEX/FormConstructor-PM/assets/83061703/cdbd20c2-7046-4636-a6c7-6482beb51ecf)

This plugin is a rewritten version of the FormConstructor plugin for Nukkit on PocketMine-MP API 5.0.0

[![License: GPL v3](https://img.shields.io/badge/License-GPLv3-blue.svg)](LICENSE) 
[![Version](https://img.shields.io/badge/Version-2.0.1-brightgreen)](https://github.com/MEFRREEX/FormConstructor-PM/releases/tag/1.0.0)

🤔 Introduction
------------- 

Library is designed to simplify the creation and handling of forms.
It has a few key advantages over other form libraries:

- Forms are handled using a callback function that is passed in when the form itself is created.
- For each button in SimpleForm we can set a callback function.
- In SimpleForm we get a button object as a response, where we can get its name and index.
- In CustomForm we can mark elements with an identifier to conveniently get this element in its handler. We can get element by id and its index.
- For each form we can set its closing handler.

🛠 Examples
-------------

Creating a SimpleForm:

```php
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

$form->send($player);
```

Creating a ModalForm:

```php
$form = new ModalForm("Test modal form");
$form->addContent("New content line");

$form->setPositiveButton("Positive button")
     ->setNegativeButton("Negative button");

// Setting the form handler
// Result returns true if a positive button was clicked and false if a negative button was clicked
$form->setHandler(function (Player $pl, bool $result) {
    $pl->sendMessage("You clicked " . ($result ? "correct" : "wrong") . " button!");
});

// Setting the form close handler
$form->setCloseHandler(fn(Player $pl) => $pl->sendMessage("You closed the form!"));

$form->send($player);
```

Creating a CustomForm:

```php
$form = new CustomForm("Test custom form");

$form->addContent("Test label")
    ->addElement("input", (new Input("Input"))
        ->setPlaceholder("Text")
        ->setDefaultValue("Default value"))
    ->addElement("slider", new Slider("Slider", 1, 100, 1, 1))
    ->addElement("stepslider", (new StepSlider("Step slider"))
        ->addText("1")
        ->addText("2")
        ->addText("3"))
    ->addElement("dropdown", (new Dropdown("Dropdown"))
        ->addText("Element 1")
        ->addText("Element 2")
        ->addText("Element 3"))
    ->addElement("dropdown1", (new Dropdown("Second dropdown"))
        ->addElement(new SelectableElement("Option 1"))
        ->addElement(new SelectableElement("Option 2"))
        ->addElement(new SelectableElement("Option with value", 15)))
    ->addElement("toggle", new Toggle("Toggle", false));

// Setting the form handler
$form->setHandler(function (Player $pl, CustomFormResponse $response) {
    $input = $response->getInput("input")->getValue();

    $slider = $response->getSlider("slider")->getValue();
    $stepslider = $response->getStepSlider("stepslider")->getValue();
    $dropdown = $response->getDropdown("dropdown")->getValue();

    // Getting the value we set in SelectableElement
    $dropdownValue = $response->getDropdown("dropdown1")->getValue()->getValue();

    $toggle = $response->getToggle("toggle")->getValue();

    $pl->sendMessage("Input: " . $input . ", Slider: " . $slider . ", Step Slider: " . $stepslider . ", Dropdown: " . $dropdown . ", Toggle: " . $toggle);
    $pl->sendMessage("Second dropdown value: " . $dropdownValue);
});

$form->send($player);
```

Download Example plugin: https://github.com/MEFRREEX/FormConstructor-PM-Example

📋 Events
-------------
| Name                 | Cancellable | Description                      |
|----------------------|-------------|----------------------------------|
| PlayerFormSendEvent  | true        | Called when a form is sent       |
| PlayerFormCloseEvent | false       | Called when the form is closed   |

Example:
```php
public function onFormSend(PlayerFormSendEvent $event) {
    // Getting a player
    $player = $event->getPlayer();
    // Getting the form
    $form = $event->getForm();
}
```
