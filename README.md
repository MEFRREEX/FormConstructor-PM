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
// Result returns true if a positive button was ckicked and false if a negative button was ckicked
$form->setHandler(function (Player $pl, bool $result) {
    $pl->sendMessage("You clicked " . ($result ? "correct" : "wrong") . " button!");
});

// Setting the form close handler
$form->setCloseHandler(fn(Player $pl) => $pl->sendMessage("You closed the form!"));

$form->send($sender);
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

$form->send($sender);
```

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