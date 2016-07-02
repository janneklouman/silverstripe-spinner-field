<?php

/**
 * An input field that uses jQuery UI's customizable spinner widget to provide a
 * nice interface for fields that require number input with specific validation.
 *
 * @package forms
 * @subpackage fields
 */
class SpinnerField extends NumericField
{

    /**
     * Options that will be passed to the jQuery UI spinner's initialization
     * method. Set by using $this->setUIOption(), or $this->setUIOptions()
     *
     * @var array
     */
    protected $spinnerUIOptions = [];

    /**
     * Enforce step validation. Will cause validation to fail if input is
     * not evenly divisible with the 'step' UI option. Example: if 'step'
     * is set to 4, validation will fail for ($input && $input % 4 !== 0)
     *
     * @var bool
     */
    protected $enforceStepValidation = false;

    /**
     * Available option keys.
     * 
     * @var array
     */
    public static $available_ui_options = [
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
            $this->setUIOptions($options);
        }

        parent::__construct($name, $title, $value);
    }

    /**
     * @see $this->spinnerUIOptions
     * @return array
     */
    public function getUIOptions()
    {
        return $this->spinnerUIOptions;
    }

    /**
     * Takes a multidimensional array to set spinner options that will be
     * put into the javascript file.
     *
     * @param array $options
     * @return $this
     */
    public function setUIOptions(array $options)
    {
        if (is_array($options)) {
            foreach ($options as $key => $value) {
                $this->setUIOption($key, $value);
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
    public function getUIOption($key)
    {
        if (array_key_exists($key, $this->getUIOptions())) {
            return $this->getUIOptions()[$key];
        }

        if ($key === 'icon_up'
            || $key === 'icon_down'
            && isset($this->getUIOptions()['icon'][substr($key, 5)])
        ) {
            return $this->getUIOptions()['icon'][substr($key, 5)];
        }

        return false;
    }

    /**
     * Set a UI option value based on key. See self::$available_ui_options.
     *
     * @param $key
     * @param $value
     * @return bool
     */
    public function setUIOption($key, $value)
    {
        if ($this->isValidUIOption($key)) {
            if ($key === 'icon_up' || $key === 'icon_down') {
                return $this->spinnerUIOptions['icons'][substr($key, 5)] = $value;
            } else {
                return $this->spinnerUIOptions[$key] = $value;
            }
        }

        return false;
    }

    /**
     * @see $this->enforceStepValidation.
     * @return bool
     */
    public function getEnforceStepValidation()
    {
        return $this->enforceStepValidation;
    }

    /**
     * @see $this->enforceStepValidation.
     * @param bool $value
     * @return bool
     */
    public function setEnforceStepValidation($value)
    {
        return $this->enforceStepValidation = (bool) $value;
    }

    /**
     * Check if a UI option key exists.
     *
     * @param $key
     * @return bool
     */
    public function isValidUIOption($key)
    {
        return in_array($key, self::$available_ui_options);
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
        $this->setAttribute('data-spinner-options', json_encode($this->getUIOptions()));

        return $this->customise($properties)->renderWith(['templates/SpinnerField']);
    }

    /**
     * Validation for this field.
     *
     * @param Validator $validator
     * @return bool
     */
    public function validate($validator)
    {
        if (!$this->value) {
            return true;
        }

        $validationChecks = [true];

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

            $validationChecks[] = false;
        }

        if ($this->getUIOption('max') && $this->value > $this->getUIOption('max')) {
            $validator->validationError(
                $this->name,
                _t(
                    'SpinnerField.ABOVEMAX',
                    '\'{value}\' exceeds the maximum allowed number {max}',
                    [
                        'value' => $this->value,
                        'max'   => $this->getUIOption('max')
                    ]
                ),
                'validation'
            );

            $validationChecks[] = false;
        }

        if ($this->getUIOption('min') && $this->value < $this->getUIOption('min')) {
            $validator->validationError(
                $this->name,
                _t(
                    'SpinnerField.BELOWMIN',
                    '\'{value}\' is below the minimum allowed number {min}',
                    [
                        'value' => $this->value,
                        'min'   => $this->getUIOption('min')
                    ]
                ),
                'validation'
            );

            $validationChecks[] = false;
        }

        if ($this->getEnforceStepValidation() && $this->value % $this->getUIOption('step') !== 0) {
            $validator->validationError(
                $this->name,
                _t(
                    'SpinnerField.NOTEVENLYDIVISIBLE',
                    '\'{value}\' is not evenly divisible by {step}',
                    [
                        'value' => $this->value,
                        'step'  => $this->getUIOption('step')
                    ]
                ),
                'validation'
            );

            $validationChecks[] = false;
        }

        return min($validationChecks);
    }
}
