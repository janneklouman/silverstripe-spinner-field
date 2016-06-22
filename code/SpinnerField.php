<?php

/**
 * An input field that uses jQuery UI's customizable spinner to provide a
 * nice interface for fields that require number input.
 *
 * @package forms
 * @subpackage fields
 */
class SpinnerField extends TextField
{

    /**
     * Options that will be passed to the spinner.
     *
     * @var array
     */
    protected $options = [];
    
    /**
     * Returns an input field.
     *
     * @param string $name
     * @param null|string $title
     * @param string $value
     * @param null|array $options
     */
    public function __construct($name, $title = null, $value = '', $options = null) {
        
        if($options) {
            $this->setOptions($options);
        }

        $this->addExtraClass('text');
        $this->addExtraClass('spinner-field');

        parent::__construct($name, $title, $value);
    }

    /**
     * Takes a multidimensional array to set spinner options that will be
     * put into the javascript file.
     * See js/spinner-field.js for available options.
     * 
     * @param array $options
     * @return $this
     */
    public function setOptions(array $options)
    {
        $this->options = $options;
        return $this;
    }

    /**
     * @return array
     */
    public function getOptions()
    {
        return $this->options;
    }

    /**
     * The actual spinner field.
     *
     * @param array $properties
     * @return HTMLText
     */
    public function Field($properties = array())
    {
        $spinnerJSParameters['SpinnerOptions'] = '\'' . json_encode($this->getOptions()) . '\'';
        $spinnerJSParameters['Name'] = '\'' . $this->name . '\'';

        Requirements::javascript(THIRDPARTY_DIR . '/jquery/jquery.js');
        Requirements::javascript(THIRDPARTY_DIR . '/jquery/jquery-ui.js');
        Requirements::javascript(THIRDPARTY_DIR . '/jquery-entwine/dist/jquery.entwine-dist.js');
        Requirements::javascript(SPINNER_FIELD_DIR . '/js/spinner-field.js');
        Requirements::javascriptTemplate(
            SPINNER_FIELD_DIR . '/js/init.js',
            $spinnerJSParameters
        );

        return $this->customise($properties)->renderWith(['templates/SpinnerField']);
    }
    
}