# Spinner field for SilverStripe
A spinner field for SilverStripe using jQuery UI's Spinner Widget providing a nice interface for number input fields and the ability to customize them. 

## Requirements
```JSON
"require": {
    "php": "^5.4",
    "silverstripe/framework": "~3.1"
}
```

## Installation

`composer require jjjjjjjjjjjjjjjjjjjj/silverstripe-spinner-field`

## Example usage
```PHP
SpinnerField::create(

    // Field name
    'Answer',

    // Label
    'What is the answer to the ultimate question of life, the universe, and everything?',

    // Initial value
    rand(0, 42),

    // Optional options (see available options below under heading: UI settings)
    [
        'min'  => 0,
        'max'  => 42,
        'step' => 3 // Increment and decrement in steps of 3
    ]

);
```

## Configuration
#### UI settings
You can configure the spinner widget's UI by passing an array of options in the constructor like shown [above](#example-usage), or you could do something like:
```PHP
// Setting a batch of options.
$spinnerField->setUIOptions(
    [
        'disabled'  => true,
        'max'       => 314159265359,
        'page'      => 100000000000,
        'icon_up'   => 'ui-icon-plus',
        'icon_down' => 'ui-icon-minus'
    ]
);

// On second thought...
$spinnerField->setUIOption('disabled', false);
```

Here's a list of available UI options. See https://api.jqueryui.com/spinner/ for detailed description of the options and what they do.
```PHP
// Available options and their default values
[
    culture      => null,
    disabled     => false,
    icon_down    => 'ui-icon-triangle-1-s',
    icon_up      => 'ui-icon-triangle-1-n',
    incremental  => true,
    max          => null,
    min          => null,
    numberFormat => null, // Currently only 'n'||null is supported
    page         => 10,
    step         => 1
]
```

#### Field settings
```PHP
/**
 * Enforce step validation. Will cause validation to fail if input is
 * not evenly divisible with the 'step' UI option. Example: if 'step'
 * is set to 4, validation will fail for 0 !== $input % 4
 *
 * @var bool
 */
protected $enforceStepValidation = false;
```
```PHP
/**
 * Will cause validation to fail if input is below the 'min' UI option.
 *
 * @var bool
 */
protected $enforceBelowMinValidation = true;
```
```PHP
/**
 * Will cause validation to fail if input is above the 'max' UI option.
 *
 * @var bool
 */
protected $enforceAboveMaxValidation = true;
```
Furthermore see [NumericField](https://github.com/silverstripe/silverstripe-framework/blob/master/forms/NumericField.php) for inherited field settings.
