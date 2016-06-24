# Spinner field for SilverStripe
A spinner field for SilverStripe using jQuery UI's Spinner Widget providing a nice interface for number input fields and the ability to customize them. 

## Installation
`composer require janneklouman/silverstripe-spinner-field`

## Example usage
```PHP
SpinnerField::create(

    // Field name
    'Answer',

    // Label
    'What is the answer to the ultimate question of life, the universe, and everything?',

    // Initial value
    rand(0, 42),

    // Optional options (see available options below)
    [
        'min'  => 0,
        'max'  => 42,
        'step' => 3
    ]

);
```

## Available options
See https://api.jqueryui.com/spinner/ for detailed description of the options and their effects.
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
    numberFormat => null,
    page         => 10,
    step         => 1
]
```
