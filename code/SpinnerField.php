<?php

/**
 * An input field that uses jQuery UI's customizable spinner to provide a
 * nice interface for fields that require number input.
 *
 * @package forms
 * @subpackage fields
 */
class SpinnerField extends NumericField
{

    /**
     * Options that will be passed to the spinner.
     *
     * @var array
     */
    protected $options = [];

    /**
     * Available option keys.
     * 
     * @var array
     */
    public static $available_options = [
        'culture',
        'disabled',
        'icon_up',
        'icon_down',
        'incremental',
        'max',
        'min',
        'numberFormat',
        'page',
        'step'
    ];
    
    /**
     * Returns an input field.
     *
     * @param string $name
     * @param null|string $title
     * @param string $value
     * @param null|array $options
     */
    public function __construct($name, $title = null, $value = '', array $options = null)
    {
        if ($options) {
            $this->setOptions($options);
        }

        parent::__construct($name, $title, $value);
    }

    /**
     * @return array
     */
    public function getOptions()
    {
        return $this->options;
    }

    /**
     * Takes a multidimensional array to set spinner options that will be
     * put into the javascript file.
     *
     * @param array $options
     * @return $this
     */
    public function setOptions(array $options)
    {
        if (is_array($options)) {
            foreach ($options as $key => $value) {
                $this->setOption($key, $value);
            }
        }

        return $this;
    }

    /**
     * Get a specific option based on key.
     *
     * @param $key
     * @return mixed
     */
    public function getOption($key)
    {
        if (array_key_exists($key, $this->getOptions())) {
            return $this->getOptions()[$key];
        }

        if ($key === 'icon_up'
            || $key === 'icon_down'
            && isset($this->getOptions()['icon'][substr($key, 5)])
        ) {
            return $this->getOptions()['icon'][substr($key, 5)];
        }

        return false;
    }

    /**
     * Set an option value.
     *
     * @param $key
     * @param $value
     */
    public function setOption($key, $value)
    {
        if ($this->isOption($key)) {
            if ($key === 'icon_up' || $key === 'icon_down') {
                $this->options['icon'][substr($key, 5)] = $value;
            } else {
                $this->options[$key] = $value;
            }
        }
    }

    /**
     * Check if an option key exists.
     *
     * @param $key
     * @return bool
     */
    public function isOption($key)
    {
        return in_array($key, self::$available_options);
    }
    
    /**
     * The actual spinner field.
     *
     * @param array $properties
     * @return HTMLText
     */
    public function Field($properties = array())
    {
        // Javascript requirements.
        Requirements::javascript(THIRDPARTY_DIR . '/jquery/jquery.js');
        Requirements::javascript(THIRDPARTY_DIR . '/jquery/jquery-ui.js');
        Requirements::javascript(THIRDPARTY_DIR . '/jquery-entwine/dist/jquery.entwine-dist.js');
        Requirements::javascript(SPINNER_FIELD_DIR . '/js/spinner-field.js');

        // Add text css class to style the field.
        $this->addExtraClass('text');

        // Add a css class to allow for custom styling.
        $this->addExtraClass('spinner-field');

        /*
         * Set options as a HTML attribute to supply init.js
         * with data to initialize the spinner.
         */
        $this->setAttribute('data-spinner-options', json_encode($this->getOptions()));

        return $this->customise($properties)->renderWith(['templates/SpinnerField']);
    }

    /**
     * Validation for this field.
     *
     * @param Validator $validator
     * @return bool
     */
    public function validate($validator) {

        if (!$this->value) {
            return true;
        }

        if (!$this->isNumeric()) {
            $validator->validationError(
                $this->name,
                _t(
                    'NumericField.VALIDATION',
                    "'{value}' is not a number, only numbers can be accepted for this field",
                    ['value' => $this->value]
                ),
                'validation'
            );

            return false;
        }

        if ($this->getOption('max') && $this->value > $this->getOption('max')) {
            $validator->validationError(
                $this->name,
                _t(
                    'SpinnerField.ABOVEMAX',
                    '\'{value}\' exceeds the maximum allowed number {max}',
                    [
                        'value' => $this->value,
                        'max' => $this->getOption('max')
                    ]
                ),
                'validation'
            );

            return false;
        }

        if ($this->getOption('min') && $this->value < $this->getOption('min')) {
            $validator->validationError(
                $this->name,
                _t(
                    'SpinnerField.BELOWMIN',
                    '\'{value}\' is below the minimum allowed number {min}',
                    [
                        'value' => $this->value,
                        'min' => $this->getOption('min')
                    ]
                ),
                'validation'
            );

            return false;
        }

        return true;
    }
}
