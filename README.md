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
